@extends('layouts.admin')

@section('title', 'Tổng quan hệ thống')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Thống kê -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                <i class="fas fa-box fa-lg"></i>
            </div>
            <span class="text-xs font-bold text-emerald-500 bg-emerald-50 px-2 py-1 rounded-lg">+12%</span>
        </div>
        <div class="text-slate-400 text-sm font-medium">Tổng sản phẩm</div>
        <div class="text-2xl font-bold text-slate-800">{{ $stats['total_products'] }}</div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600">
                <i class="fas fa-shopping-cart fa-lg"></i>
            </div>
            <span class="text-xs font-bold text-emerald-500 bg-emerald-50 px-2 py-1 rounded-lg">+5%</span>
        </div>
        <div class="text-slate-400 text-sm font-medium">Đơn hàng mới</div>
        <div class="text-2xl font-bold text-slate-800">{{ $stats['total_orders'] }}</div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center text-orange-600">
                <i class="fas fa-users fa-lg"></i>
            </div>
            <span class="text-xs font-bold text-red-500 bg-red-50 px-2 py-1 rounded-lg">-2%</span>
        </div>
        <div class="text-slate-400 text-sm font-medium">Người dùng</div>
        <div class="text-2xl font-bold text-slate-800">{{ $stats['total_users'] }}</div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600">
                <i class="fas fa-dollar-sign fa-lg"></i>
            </div>
            <span class="text-xs font-bold text-emerald-500 bg-emerald-50 px-2 py-1 rounded-lg">+18%</span>
        </div>
        <div class="text-slate-400 text-sm font-medium">Doanh thu</div>
        <div class="text-2xl font-bold text-slate-800">{{ number_format($stats['total_revenue'], 0, ',', '.') }}đ</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Đơn hàng gần đây -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-bold text-slate-800">Đơn hàng gần đây</h3>
            <a href="#" class="text-sm text-blue-600 font-medium hover:underline">Xem tất cả</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 text-xs font-bold text-slate-400 uppercase tracking-wider">
                        <th class="px-6 py-4">Mã đơn</th>
                        <th class="px-6 py-4">Khách hàng</th>
                        <th class="px-6 py-4">Tổng tiền</th>
                        <th class="px-6 py-4 text-right">Trạng thái</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($recent_orders as $order)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-blue-600">{{ $order->code }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $order->first_name }} {{ $order->last_name }}</td>
                        <td class="px-6 py-4 font-semibold text-slate-800">{{ number_format($order->total_price, 0, ',', '.') }}đ</td>
                        <td class="px-6 py-4 text-right">
                            <span class="px-3 py-1 rounded-full text-xs font-medium 
                                {{ $order->status === 'đang xử lý' ? 'bg-orange-50 text-orange-600' : 'bg-emerald-50 text-emerald-600' }}">
                                {{ $order->status }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Biểu đồ/Thanh tiến trình (Giả lập) -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h3 class="font-bold text-slate-800 mb-6">Mục tiêu tháng</h3>
        <div class="space-y-6">
            <div>
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-slate-500">Doanh số bán hàng</span>
                    <span class="font-bold">75%</span>
                </div>
                <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-blue-500" style="width: 75%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-slate-500">Khách hàng mới</span>
                    <span class="font-bold">45%</span>
                </div>
                <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-purple-500" style="width: 45%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-slate-500">Sản phẩm đã bán</span>
                    <span class="font-bold">90%</span>
                </div>
                <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-emerald-500" style="width: 90%"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

