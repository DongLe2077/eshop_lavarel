<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Helpers\VietnameseHelper;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Danh sách sản phẩm với tìm kiếm và sắp xếp.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Tìm kiếm thông minh (hỗ trợ tiếng Việt có dấu và không dấu)
        if ($request->filled('search')) {
            $search     = $request->input('search');
            $searchPlain = VietnameseHelper::removeDiacritics($search);
            $like        = "%{$search}%";
            $likePlain   = "%{$searchPlain}%";

            $query->where(function ($q) use ($like, $likePlain) {
                $q->where('name', 'like', $like)
                  ->orWhere('name', 'like', $likePlain)
                  ->orWhereHas('category', function ($catQuery) use ($like, $likePlain) {
                      $catQuery->where('name', 'like', $like)
                               ->orWhere('name', 'like', $likePlain);
                  });
            });

            // Ưu tiên tên trùng khớp chính xác hơn
            $query->orderByRaw('CASE WHEN name LIKE ? THEN 1 WHEN name LIKE ? THEN 2 ELSE 3 END', [$like, $likePlain]);
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
