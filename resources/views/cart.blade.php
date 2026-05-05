{{-- Trang Giỏ Hàng - Trích xuất từ Stitch UI "cart.html" --}}
@extends('layouts.app')

@section('title', 'Giỏ Hàng - FashionGZ')

@section('content')
    <section class="max-w-7xl mx-auto px-4 sm:px-8 py-12">
        <h1 class="font-headline text-[3.5rem] leading-[1.1] tracking-[-0.02em] text-on-surface mb-4">Giỏ Hàng</h1>
        <p class="text-sm text-on-surface-variant mb-12">{{ count($cart) }} sản phẩm trong giỏ hàng của bạn.</p>

        @if(session('success'))
            <div class="bg-tertiary/10 text-tertiary px-4 py-3 rounded font-body text-sm mb-8">
                {{ session('success') }}
            </div>
        @endif

        @if(count($cart) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-16">
                {{-- Cart Items --}}
                <div class="lg:col-span-2 flex flex-col gap-8">
                    @foreach($cart as $id => $item)
                        <div class="flex gap-6 pb-8 border-b border-outline-variant/30">
                            {{-- Product Image --}}
                            <a href="{{ route('products.show', $item['slug'] ?? $id) }}" class="w-32 h-40 bg-surface-variant rounded overflow-hidden flex-shrink-0">
                                <img src="{{ $item['image'] ?: 'https://placehold.co/200x250/e5e2e1/56423e?text=SP' }}" alt="{{ $item['name'] }}"
                                     class="w-full h-full object-cover"/>
                            </a>

                            {{-- Product Details --}}
                            <div class="flex flex-col justify-between flex-grow">
                                <div>
                                    <a href="{{ route('products.show', $item['slug'] ?? $id) }}">
                                        <h3 class="font-headline text-lg font-semibold text-on-surface mb-1 hover:text-primary transition-colors">{{ $item['name'] }}</h3>
                                    </a>
                                    <p class="font-body text-sm text-on-surface-variant">{{ number_format($item['price'], 0, ',', '.') }}đ</p>
                                </div>

                                <div class="flex items-center justify-between mt-4">
                                    {{-- Quantity Control --}}
                                    <form action="{{ route('cart.update') }}" method="POST" class="flex items-center border border-outline-variant rounded">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $id }}">
                                        <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}"
                                                class="px-3 py-1 text-on-surface-variant hover:text-primary transition-colors {{ $item['quantity'] <= 1 ? 'opacity-50' : '' }}">−</button>
                                        <span class="w-10 text-center text-on-surface font-body text-sm">{{ $item['quantity'] }}</span>
                                        <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}"
                                                class="px-3 py-1 text-on-surface-variant hover:text-primary transition-colors">+</button>
                                    </form>

                                    {{-- Remove --}}
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-on-surface-variant hover:text-error transition-colors">
                                            <span class="material-symbols-outlined text-xl">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            {{-- Line Total --}}
                            <div class="flex-shrink-0 text-right">
                                <p class="font-headline text-lg font-semibold text-on-surface">
                                    {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Order Summary --}}
                <div class="lg:col-span-1">
                    <div class="bg-surface-container-low rounded p-8 sticky top-24">
                        <h2 class="font-headline text-xl font-bold text-on-surface mb-8">Tóm Tắt Đơn Hàng</h2>

                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between text-sm">
                                <span class="font-body text-on-surface-variant">Tạm tính</span>
                                <span class="font-body text-on-surface">{{ number_format($total, 0, ',', '.') }}đ</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="font-body text-on-surface-variant">Phí vận chuyển</span>
                                <span class="font-body text-on-surface">Miễn phí</span>
                            </div>
                            <div class="border-t border-outline-variant/30 pt-4 flex justify-between">
                                <span class="font-headline text-lg font-bold text-on-surface">Tổng cộng</span>
                                <span class="font-headline text-lg font-bold text-primary">{{ number_format($total, 0, ',', '.') }}đ</span>
                            </div>
                        </div>

                        @auth
                            <a href="{{ route('checkout') }}"
                               class="block w-full py-4 bg-gradient-to-br from-primary to-primary-container text-on-primary font-label text-sm uppercase tracking-wide rounded hover:opacity-90 transition-opacity shadow-[0px_8px_16px_rgba(155,63,43,0.2)] text-center">
                                Tiến Tới Thanh Toán
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="block w-full py-4 bg-gradient-to-br from-primary to-primary-container text-on-primary font-label text-sm uppercase tracking-wide rounded hover:opacity-90 transition-opacity shadow-[0px_8px_16px_rgba(155,63,43,0.2)] text-center">
                                Đăng Nhập Để Đặt Hàng
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-20">
                <span class="material-symbols-outlined text-6xl text-outline-variant mb-4">shopping_cart</span>
                <p class="font-body text-on-surface-variant text-lg mb-8">Giỏ hàng của bạn đang trống.</p>
                <a href="{{ route('products.index') }}"
                   class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-br from-primary to-primary-container text-on-primary font-label text-sm uppercase tracking-wide rounded hover:opacity-90 transition-opacity">
                    Tiếp Tục Mua Sắm
                </a>
            </div>
        @endif
    </section>
@endsection

