<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\StockMovement;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PartController extends Controller
{
    public function index()
    {
        $parts = Part::with('supplier')
            ->when(request('search'), fn ($q, $search) => $q->where(
                fn ($q2) => $q2->where('name', 'like', "%{$search}%")->orWhere('sku', 'like', "%{$search}%")
            ))
            ->latest()->paginate(10);
        return view('parts.index', compact('parts'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        return view('parts.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'sku' => 'required|string|max:255|unique:parts,sku',
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'low_stock_threshold' => 'nullable|integer|min:0',
        ]);

        $validated['low_stock_threshold'] = $validated['low_stock_threshold'] ?? 50;

        Part::create($validated);

        return redirect()->route('parts.index')->with('success', '部品を登録しました。');
    }

    public function show(Part $part)
    {
        //
    }

    public function edit(Part $part)
    {
        $suppliers = Supplier::all();
        return view('parts.edit', compact('part', 'suppliers'));
    }

    public function update(Request $request, Part $part)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'sku' => 'required|string|max:255|unique:parts,sku,' . $part->id,
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'low_stock_threshold' => 'nullable|integer|min:0',
        ]);

        $validated['low_stock_threshold'] = $validated['low_stock_threshold'] ?? 50;

        $part->update($validated);

        return redirect()->route('parts.index')->with('success', '部品を更新しました。');
    }

    public function destroy(Part $part)
    {
        $part->delete();

        return redirect()->route('parts.index')->with('success', '部品を削除しました。');
    }

    public function stockInForm(Part $part)
    {
        return view('parts.stock-in', compact('part'));
    }

    public function stockIn(Request $request, Part $part)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'memo' => 'nullable|string|max:255',
        ]);

        StockMovement::create([
            'stockable_type' => $part->getMorphClass(),
            'stockable_id' => $part->id,
            'user_id' => auth()->id(),
            'type' => 'in',
            'quantity' => $validated['quantity'],
            'memo' => $validated['memo'] ?: '手動入庫登録',
        ]);

        return redirect()->route('parts.index')->with('success', '在庫を追加しました。');
    }
}
