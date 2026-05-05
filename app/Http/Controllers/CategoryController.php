<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Hiển thị tất cả danh mục.
     */
    public function index()
    {
        $categories = Category::withCount('products')->get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Hiển thị sản phẩm theo danh mục (chuyển hướng tới ProductController).
     */
    public function show($id, Request $request)
    {
        return app(ProductController::class)->byCategory($id, $request);
    }
}
