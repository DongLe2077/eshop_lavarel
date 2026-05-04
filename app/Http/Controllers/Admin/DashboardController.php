<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Thống kê cơ bản
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalUsers = User::count();
        $totalRevenue = Order::sum('total_price');

        // Tính toán mục tiêu (Giả lập mục tiêu dựa trên quy mô hiện tại)
        $revenueTarget = 10000000; // 10 triệu
        $userTarget = 10;
        $productTarget = 100;

        $stats = [
            'total_products' => $totalProducts,
            'total_orders' => $totalOrders,
            'total_users' => $totalUsers,
            'total_revenue' => $totalRevenue,
            
            // Tiến độ mục tiêu (%)
            'revenue_progress' => min(100, round(($totalRevenue / $revenueTarget) * 100)),
            'user_progress' => min(100, round(($totalUsers / $userTarget) * 100)),
            'product_progress' => min(100, round(($totalProducts / $productTarget) * 100)),
            
            // Trends (Giả lập xu hướng so với tháng trước - hoặc tính thật nếu có created_at)
            'revenue_trend' => '+18%',
            'order_trend' => '+5%',
            'product_trend' => '+12%',
            'user_trend' => '-2%',
        ];

        $recent_orders = Order::orderBy('id', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_orders'));
    }
}
