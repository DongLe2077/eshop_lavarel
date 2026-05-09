<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Hiển thị trang tìm kiếm riêng biệt.
     */
    public function index()
    {
        return view('search');
    }

    /**
     * API trả về gợi ý tìm kiếm realtime (JSON).
     */
    public function suggest(Request $request)
    {
        $keyword = $request->input('q');

        if (empty(trim($keyword))) {
            return response()->json([]);
        }

        $query = Product::with('category');

        $query->where(function ($q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
              ->orWhereHas('category', function ($catQuery) use ($keyword) {
                  $catQuery->where('name', 'like', "%{$keyword}%");
              });
        });

        // Lấy 5 kết quả tốt nhất làm gợi ý
        $products = $query->take(5)->get()->map(function ($product) {
            return [
                'id' => $product->slug,
                'name' => $product->name,
                'price' => $product->formatted_price,
                'image' => $product->image ?: 'https://placehold.co/100x100/e5e2e1/56423e?text=No+Img',
                'category' => $product->category->name ?? 'Khác',
                'url' => route('products.show', $product)
            ];
        });

        return response()->json($products);
    }
}
