<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PartController extends Controller
{
    public function index()
    {
        $parts = Part::with('supplier')->latest()->paginate(10);
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
        ]);

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
        ]);

        $part->update($validated);

        return redirect()->route('parts.index')->with('success', '部品を更新しました。');
    }

    public function destroy(Part $part)
    {
        $part->delete();

        return redirect()->route('parts.index')->with('success', '部品を削除しました。');
    }
}
