@extends('layouts.admin')

@section('title', 'Quản lý Đơn hàng')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mt-8">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-slate-50/50 border-b border-slate-100">
                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider w-16">ID</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Mã đơn</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Khách hàng</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Trạng thái</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Tổng tiền</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-right">Thao tác</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($orders as $order)
            <tr class="hover:bg-slate-50/50 transition-colors group">
                <td class="px-6 py-4 text-slate-500 font-medium">#{{ $order->id }}</td>
                <td class="px-6 py-4 text-slate-700 font-bold">{{ $order->code ?? 'N/A' }}</td>
                <td class="px-6 py-4">
                    <div class="font-semibold text-slate-800">{{ $order->user->name ?? $order->user->email ?? 'Guest' }}</div>
                    <div class="text-xs text-slate-400">{{ $order->phone ?? '' }}</div>
                </td>
                <td class="px-6 py-4">
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('PATCH')
                        <select name="status" onchange="this.form.submit()" 
                            class="px-3 py-1 rounded-full text-xs font-medium cursor-pointer border-none focus:ring-2 focus:ring-blue-500 transition-all
                            {{ $order->status == 'pending' ? 'bg-yellow-50 text-yellow-600' : '' }}
                            {{ $order->status == 'processing' ? 'bg-blue-50 text-blue-600' : '' }}
                            {{ $order->status == 'completed' ? 'bg-green-50 text-green-600' : '' }}
                            {{ $order->status == 'canceled' ? 'bg-red-50 text-red-600' : '' }}
                            {{ !in_array($order->status, ['pending', 'processing', 'completed', 'canceled']) ? 'bg-slate-100 text-slate-600' : '' }}">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </form>
                </td>
                <td class="px-6 py-4 font-medium text-slate-700">
                    {{ number_format($order->total_price ?? 0, 0, ',', '.') }}đ
                </td>

                <td class="px-6 py-4 text-right">
                    <div class="flex justify-end space-x-2 transition-opacity">
                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-slate-500">Chưa có đơn hàng nào.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
        {{ $orders->links() }}
    </div>
</div>
@endsection
