<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductPartController extends Controller
{
    public function index(Product $product)
    {
        $product->load('parts');

        // まだこの商品に割り当てられていない部品だけを候補として渡す
        $assignedPartIds = $product->parts->pluck('id');
        $availableParts = Part::whereNotIn('id', $assignedPartIds)->get();

        return view('products.parts.index', compact('product', 'availableParts'));
    }

    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'part_id' => 'required|exists:parts,id',
            'quantity_required' => 'required|integer|min:1',
        ]);

        // 既に割り当て済みでないかチェック
        if ($product->parts()->where('part_id', $validated['part_id'])->exists()) {
            return back()->withErrors(['part_id' => 'この部品は既に割り当て済みです。']);
        }

        $product->parts()->attach($validated['part_id'], [
            'quantity_required' => $validated['quantity_required'],
        ]);

        return redirect()
            ->route('products.parts.index', $product)
            ->with('success', '部品を追加しました。');
    }

    public function update(Request $request, Product $product, Part $part)
    {
        $validated = $request->validate([
            'quantity_required' => 'required|integer|min:1',
        ]);

        $product->parts()->updateExistingPivot($part->id, [
            'quantity_required' => $validated['quantity_required'],
        ]);

        return redirect()
            ->route('products.parts.index', $product)
            ->with('success', '必要数を更新しました。');
    }

    public function destroy(Product $product, Part $part)
    {
        $product->parts()->detach($part->id);

        return redirect()
            ->route('products.parts.index', $product)
            ->with('success', '部品を削除しました。');
    }
}
