<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\Product;
use App\Models\StockMovement;

class StockController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'customer'])->get();
        $parts = Part::with('supplier')->get();

        return view('stocks.index', compact('products', 'parts'));
    }

    public function movements()
    {
        $movements = StockMovement::with(['stockable', 'user'])->latest()->paginate(20);

        return view('stocks.movements', compact('movements'));
    }
}
