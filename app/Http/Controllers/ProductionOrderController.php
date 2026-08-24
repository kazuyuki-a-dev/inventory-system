<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\Product;
use App\Models\ProductionOrder;
use Illuminate\Http\Request;

class ProductionOrderController extends Controller
{
    public function index()
    {
        $productionOrders = ProductionOrder::with(['product', 'user'])->latest()->paginate(10);
        return view('production-orders.index', compact('productionOrders'));
    }

    public function create()
    {
        $products = Product::all();
        return view('production-orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'planned_date' => 'nullable|date',
        ]);

        ProductionOrder::create([
            ...$validated,
            'user_id' => auth()->id(),
            'status' => 'pending',
        ]);

        return redirect()->route('production-orders.index')->with('success', '製造指示を登録しました。');
    }

    public function show(ProductionOrder $productionOrder)
    {
        //
    }

    public function edit(ProductionOrder $productionOrder)
    {
        //
    }

    public function update(Request $request, ProductionOrder $productionOrder)
    {
        //
    }

    public function destroy(ProductionOrder $productionOrder)
    {
        //
    }

    public function complete(ProductionOrder $productionOrder)
    {
        if ($productionOrder->status !== 'pending') {
            return back()->withErrors(['status' => 'この製造指示は既に処理済みです。']);
        }

        DB::transaction(function () use ($productionOrder) {
            $product = $productionOrder->product()->with('parts')->first();

            foreach ($product->parts as $part) {
                $requiredQuantity = $part->pivot->quantity_required * $productionOrder->quantity;
                $currentStock = $this->calculateStock($part);

                if ($currentStock < $requiredQuantity) {
                    throw ValidationException::withMessages([
                        'status' => "部品「{$part->name}」の在庫が不足しています(必要数: {$requiredQuantity}, 現在庫: {$currentStock})。",
                    ]);
                }
            }

            foreach ($product->parts as $part) {
                $requiredQuantity = $part->pivot->quantity_required * $productionOrder->quantity;

                StockMovement::create([
                    'stockable_type' => $part->getMorphClass(),
                    'stockable_id' => $part->id,
                    'user_id' => auth()->id(),
                    'production_order_id' => $productionOrder->id,
                    'type' => 'out',
                    'quantity' => $requiredQuantity,
                    'memo' => "製造指示#{$productionOrder->id}による出庫",
                ]);
            }

            StockMovement::create([
                'stockable_type' => $product->getMorphClass(),
                'stockable_id' => $product->id,
                'user_id' => auth()->id(),
                'production_order_id' => $productionOrder->id,
                'type' => 'in',
                'quantity' => $productionOrder->quantity,
                'memo' => "製造指示#{$productionOrder->id}による入庫",
            ]);

            $productionOrder->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);
        });

        return redirect()->route('production-orders.index')->with('success', '製造指示を完了し、在庫を更新しました。');
    }

    private function calculateStock($stockable): int
    {
        $in = $stockable->stockMovements()->where('type', 'in')->sum('quantity');
        $out = $stockable->stockMovements()->where('type', 'out')->sum('quantity');

        return $in - $out;
    }
}
