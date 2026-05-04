<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Hiển thị danh sách đơn hàng của người dùng.
     */
    /**
     * Hiển thị danh sách đơn hàng của người dùng.
     */
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with(['details.product'])
            ->orderBy('id', 'desc')
            ->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * Hiển thị trang thanh toán.
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('checkout', compact('cart', 'total'));
    }

    /**
     * Tạo đơn hàng mới từ giỏ hàng.
     */
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Tạo đơn hàng
        $order = new Order();
        $order->code = 'ORD-' . strtoupper(Str::random(8));
        $order->status = 'đang xử lý';
        $order->user_id = auth()->id();
        
        // Thông tin giao hàng
        $order->first_name = $request->first_name;
        $order->last_name = $request->last_name;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->address = $request->address;
        $order->city = $request->city;
        $order->zip = $request->zip;
        $order->total_price = $total;
        
        $order->save();

        // Tạo chi tiết đơn hàng
        foreach ($cart as $productId => $item) {
            $detail = new OrderDetail();
            $detail->order_id = $order->id;
            $detail->product_id = $productId;
            $detail->quanlity = $item['quantity'];
            $detail->price = $item['price'];
            $detail->save();

            // Cập nhật số lượng tồn kho và lượt xem (quanlity)
            $product = \App\Models\Product::find($productId);
            if ($product) {
                $product->quanlity -= $item['quantity'];
                $product->save();
            }
        }

        // Xóa giỏ hàng
        session()->forget('cart');

        return redirect()->route('orders.index')->with('success', 'Đặt hàng thành công! Mã đơn: ' . $order->code);
    }
}
