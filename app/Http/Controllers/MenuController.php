<?php

namespace App\Http\Controllers;

use App\Models\Product;

class MenuController extends Controller
{
    public function index()
    {
        $products = Product::where('is_available', true)->get();
        return view('menu.index', compact('products'));
    }
}