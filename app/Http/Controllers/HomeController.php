<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        $featuredProducts = Product::orderBy('view', 'desc')->take(5)->get();

        $categories = Category::withCount('products')->get();

        return view('home', compact('products', 'categories', 'featuredProducts'));
    }
}
