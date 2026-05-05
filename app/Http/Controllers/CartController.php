<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Hiển thị giỏ hàng.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart', compact('cart', 'total'));
    }

    /**
     * Thêm sản phẩm vào giỏ hàng.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);
        $id = $product->id;

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $request->quantity;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $product->price,
                'quantity' => $request->quantity,
                'image' => $product->image,
            ];
        }

        session()->put('cart', $cart);

        if (auth()->check()) {
            $user = auth()->user();
            $user->cart_data = $cart;
            $user->save();
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã thêm "' . $product->name . '" vào giỏ hàng!',
                'cart_count' => count($cart)
            ]);
        }

        return redirect()->back()->with('success', 'Đã thêm "' . $product->name . '" vào giỏ hàng!');
    }

    /**
     * Cập nhật số lượng sản phẩm trong giỏ.
     */
    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        $id = $request->product_id;

        if (isset($cart[$id])) {
            if ($request->quantity <= 0) {
                unset($cart[$id]);
            } else {
                $cart[$id]['quantity'] = $request->quantity;
            }
        }

        session()->put('cart', $cart);

        if (auth()->check()) {
            $user = auth()->user();
            $user->cart_data = $cart;
            $user->save();
        }

        return redirect()->route('cart.index')->with('success', 'Đã cập nhật giỏ hàng!');
    }

    /**
     * Xóa sản phẩm khỏi giỏ.
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        session()->put('cart', $cart);

        if (auth()->check()) {
            $user = auth()->user();
            $user->cart_data = $cart;
            $user->save();
        }

        return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }
}
