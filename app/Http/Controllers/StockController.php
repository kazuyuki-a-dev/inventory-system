<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\Product;

class StockController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'supplier'])->get();
        $parts = Part::with('supplier')->get();

        return view('stocks.index', compact('products', 'parts'));
    }
}
