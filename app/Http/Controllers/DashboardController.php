<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\Product;
use App\Models\ProductionOrder;

class DashboardController extends Controller
{
    public function index()
    {
        $productCount = Product::count();
        $partCount = Part::count();
        $pendingOrderCount = ProductionOrder::where('status', 'pending')->count();

        $lowStockThreshold = 50;

        $lowStockParts = Part::all()->filter(function (Part $part) use ($lowStockThreshold) {
            return $part->currentStock() < $lowStockThreshold;
        });

        return view('dashboard', compact(
            'productCount',
            'partCount',
            'pendingOrderCount',
            'lowStockParts',
            'lowStockThreshold'
        ));
    }
}
