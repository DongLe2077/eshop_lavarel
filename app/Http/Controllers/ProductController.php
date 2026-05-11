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

        // Tìm kiếm thông minh (không phân biệt dấu tiếng Việt)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $like = "%{$search}%";

            $query->where(function ($q) use ($like) {
                $q->whereRaw('name COLLATE utf8mb4_general_ci LIKE ?', [$like])
                  ->orWhereHas('category', function ($catQuery) use ($like) {
                      $catQuery->whereRaw('name COLLATE utf8mb4_general_ci LIKE ?', [$like]);
                  })
                  ->orWhereRaw('description COLLATE utf8mb4_general_ci LIKE ?', [$like]);
            });

            // Ưu tiên kết quả tên trùng khớp trực tiếp hơn
            $query->orderByRaw('CASE WHEN name COLLATE utf8mb4_general_ci LIKE ? THEN 1 ELSE 2 END', [$like]);
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
