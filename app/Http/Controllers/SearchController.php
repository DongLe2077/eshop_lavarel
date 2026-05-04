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

        $keywords = explode(' ', $keyword);
        $query = Product::with('category');

        $query->where(function ($q) use ($keywords, $keyword) {
            foreach ($keywords as $word) {
                if (trim($word) == '') continue;
                $q->where(function ($sub) use ($word) {
                    $sub->where('name', 'like', "%{$word}%")
                        ->orWhere('description', 'like', "%{$word}%")
                        ->orWhereHas('category', function ($catQuery) use ($word) {
                            $catQuery->where('name', 'like', "%{$word}%");
                        });
                });
            }
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
