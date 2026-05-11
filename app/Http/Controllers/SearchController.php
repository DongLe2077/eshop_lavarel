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
        $like = "%{$keyword}%";

        $query->where(function ($q) use ($like) {
            $q->whereRaw('name COLLATE utf8mb4_general_ci LIKE ?', [$like])
              ->orWhereHas('category', function ($catQuery) use ($like) {
                  $catQuery->whereRaw('name COLLATE utf8mb4_general_ci LIKE ?', [$like]);
              })
              ->orWhereRaw('description COLLATE utf8mb4_general_ci LIKE ?', [$like]);
        });

        // Lấy 6 kết quả tốt nhất làm gợi ý
        $products = $query->take(6)->get()->map(function ($product) {
            return [
                'id'       => $product->slug,
                'name'     => $product->name,
                'price'    => $product->formatted_price,
                'image'    => $product->image_url,
                'category' => $product->category->name ?? 'Khác',
                'url'      => route('products.show', $product)
            ];
        });

        return response()->json($products);
    }
}
