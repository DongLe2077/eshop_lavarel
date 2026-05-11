<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Helpers\VietnameseHelper;
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
        $keywordPlain = mb_strtolower(VietnameseHelper::removeDiacritics($keyword));
        $like         = "%{$keyword}%";
        $likePlain    = "%{$keywordPlain}%";

        $query->where(function ($q) use ($like, $likePlain) {
            $q->where('name', 'like', $like)
              ->orWhere('search_name', 'like', $likePlain)
              ->orWhereHas('category', function ($catQuery) use ($like, $likePlain) {
                  $catQuery->where('name', 'like', $like)
                           ->orWhere('search_name', 'like', $likePlain);
              });
        });

        // Lấy 6 kết quả tốt nhất
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
