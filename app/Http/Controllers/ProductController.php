<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Danh sách sản phẩm với tìm kiếm và sắp xếp.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Tìm kiếm thông minh
        if ($request->filled('search')) {
            $search = $request->input('search');
            
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('category', function ($catQuery) use ($search) {
                      $catQuery->where('name', 'like', "%{$search}%");
                  });
            });

            // Ưu tiên kết quả trùng khớp tên sản phẩm hơn (đưa lên đầu)
            $query->orderByRaw("CASE WHEN name LIKE ? THEN 1 ELSE 2 END", ["%{$search}%"]);
        }

        // Sắp xếp
        switch ($request->input('sort')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('view', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        $products = $query->paginate(12);

        return view('products.index', compact('products'));
    }

    /**
     * Chi tiết sản phẩm.
     */
    public function show(Product $product)
    {
        $product->load('category');

        // Tăng lượt xem
        $product->increment('view');

        // Sản phẩm liên quan (cùng danh mục)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Sản phẩm theo danh mục.
     */
    public function byCategory($id, Request $request)
    {
        $category = Category::findOrFail($id);

        $query = Product::with('category')
            ->where('category_id', $id);

        // Sắp xếp
        switch ($request->input('sort')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('view', 'desc');
                break;
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        $products = $query->paginate(12);

        return view('products.index', compact('products', 'category'));
    }
}
