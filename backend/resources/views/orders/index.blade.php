{{-- Trang Đơn Hàng --}}
@extends('layouts.app')

@section('title', 'Đơn Hàng Của Tôi - Zest Outfit')

@section('content')
    <section class="max-w-7xl mx-auto px-4 sm:px-8 py-12">
        <div class="flex justify-between items-center mb-12">
            <div>
                <h1 class="font-headline text-4xl font-bold text-on-surface tracking-tight mb-2">Đơn Hàng Của Tôi</h1>
                <p class="font-body text-on-surface-variant">Theo dõi trạng thái đơn hàng của bạn.</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="font-label text-sm text-on-surface-variant uppercase tracking-wide border-b border-outline-variant hover:border-primary hover:text-primary transition-colors pb-1">
                    Đăng Xuất
                </button>
            </form>
        </div>

        {{-- Premium Success Notification --}}
        @if(session('success'))
            <div class="mb-12 bg-surface-container-lowest border border-tertiary/20 rounded-lg p-8 flex flex-col md:flex-row items-center gap-8 shadow-xl animate-fade-in relative overflow-hidden">
                <div class="absolute -right-12 -top-12 w-48 h-48 bg-tertiary/5 rounded-full blur-3xl"></div>
                <div class="flex-shrink-0 w-16 h-16 bg-tertiary/10 text-tertiary rounded-full flex items-center justify-center">
                    <span class="material-symbols-outlined text-4xl font-bold">check_circle</span>
                </div>
                <div class="flex-grow text-center md:text-left relative z-10">
                    <h2 class="font-headline text-2xl font-bold text-on-surface mb-2">Đặt Hàng Thành Công!</h2>
                    <p class="font-body text-on-surface-variant mb-4">Cảm ơn bạn đã tin tưởng Zest Outfit. Đơn hàng của bạn đang được chúng tôi xử lý cẩn thận.</p>
                    <div class="inline-flex items-center gap-2 bg-tertiary/10 text-tertiary px-4 py-1.5 rounded-full font-label text-[10px] uppercase tracking-widest font-bold">
                        {{ session('success') }}
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="font-label text-xs text-primary uppercase tracking-widest border-b border-primary hover:opacity-70 transition-opacity pb-1 font-bold">Tiếp Tục Mua Sắm</a>
                </div>
            </div>
        @endif

        @forelse($orders as $order)
            <div class="bg-surface-container-low rounded p-8 mb-8 border border-outline-variant/10">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 border-b border-outline-variant/20 pb-6">
                    <div>
                        <span class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant/60 block mb-1">Mã đơn hàng</span>
                        <h3 class="font-headline text-lg font-bold text-on-surface">{{ $order->code }}</h3>
                    </div>
                    <div class="text-left md:text-right">
                        <span class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant/60 block mb-1">Trạng thái</span>
                        <span class="px-3 py-1 rounded-sm font-label text-[10px] uppercase tracking-widest font-bold
                            {{ $order->status === 'hoàn thành' ? 'bg-tertiary/10 text-tertiary' : ($order->status === 'đã hủy' ? 'bg-error/10 text-error' : 'bg-primary/10 text-primary') }}">
                            {{ $order->status }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    {{-- Chi tiết sản phẩm --}}
                    <div class="lg:col-span-8 space-y-4">
                        @foreach($order->details as $detail)
                            <div class="flex items-center gap-4 py-2">
                                <div class="w-14 h-18 bg-surface-variant rounded overflow-hidden flex-shrink-0">
                                    <img src="{{ $detail->product->image ?? 'https://placehold.co/100x100/e5e2e1/56423e?text=SP' }}"
                                         alt="{{ $detail->product->name ?? 'Sản phẩm' }}" class="w-full h-full object-cover"/>
                                </div>
                                <div class="flex-grow">
                                    <p class="font-headline text-sm font-semibold text-on-surface">{{ $detail->product->name ?? 'Sản phẩm không tồn tại' }}</p>
                                    <p class="font-body text-xs text-on-surface-variant mt-1">
                                        {{ number_format($detail->price, 0, ',', '.') }}đ × {{ $detail->quanlity }}
                                    </p>
                                </div>
                                <span class="font-body text-sm font-medium text-on-surface">{{ number_format($detail->price * $detail->quanlity, 0, ',', '.') }}đ</span>
                            </div>
                        @endforeach
                    </div>

                    {{-- Thông tin giao hàng & Tổng tiền --}}
                    <div class="lg:col-span-4 bg-surface-container-lowest p-6 rounded border border-outline-variant/10">
                        <h4 class="font-headline text-sm font-bold text-on-surface mb-4 uppercase tracking-wider">Thông tin giao hàng</h4>
                        <div class="space-y-2 mb-6">
                            <p class="font-body text-xs text-on-surface"><span class="text-on-surface-variant">Người nhận:</span> {{ $order->first_name }} {{ $order->last_name }}</p>
                            <p class="font-body text-xs text-on-surface"><span class="text-on-surface-variant">ĐT:</span> {{ $order->phone }}</p>
                            <p class="font-body text-xs text-on-surface leading-normal"><span class="text-on-surface-variant">Địa chỉ:</span> {{ $order->address }}, {{ $order->city }}</p>
                        </div>
                        <div class="border-t border-outline-variant/20 pt-4 flex justify-between items-center">
                            <span class="font-headline text-base font-bold text-on-surface">Tổng thanh toán</span>
                            <span class="font-headline text-lg font-bold text-primary">{{ number_format($order->total_price ?? 0, 0, ',', '.') }}đ</span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-20">
                <span class="material-symbols-outlined text-6xl text-outline-variant mb-4">receipt_long</span>
                <p class="font-body text-on-surface-variant text-lg mb-8">Bạn chưa có đơn hàng nào.</p>
                <a href="{{ route('products.index') }}"
                   class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-br from-primary to-primary-container text-on-primary font-label text-sm uppercase tracking-wide rounded hover:opacity-90 transition-opacity">
                    Bắt Đầu Mua Sắm
                </a>
            </div>
        @endforelse
    </section>
@endsection
