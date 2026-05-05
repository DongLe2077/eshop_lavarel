{{-- Trang Chủ - Editorial Mosaic Redesign --}}
@extends('layouts.app')

@section('title', 'Zest Outfit - Thời trang cao cấp')

@section('content')
    {{-- Categories Mapping --}}
    @php
        $categoryImages = [
            'Áo' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800&q=80',
            'Quần' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?w=800&q=80',
            'Váy & Đầm' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=800&q=80',
            'Phụ Kiện' => 'https://images.unsplash.com/photo-1576053139778-7e32f2ae3cfd?w=800&q=80',
            'Giày Dép' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=800&q=80',
            'Túi Xách' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?w=800&q=80',
        ];
        $defaultCatImage = 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800&q=80';
    @endphp

    {{-- Hero Slider Section --}}
    <section class="relative w-full h-[800px] bg-luxury-dark overflow-hidden">
        <div class="swiper heroSwiper w-full h-full">
            <div class="swiper-wrapper">
                @forelse($featuredProducts as $fProduct)
                    <div class="swiper-slide relative">
                        <div class="absolute inset-0">
                            <img alt="{{ $fProduct->name }}"
                                 class="w-full h-full object-cover object-center opacity-70 transition-transform duration-[15s] scale-110"
                                 src="{{ $fProduct->image ?: 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=1920&q=80' }}"/>
                            <div class="absolute inset-0 bg-gradient-to-r from-luxury-dark/60 via-transparent to-transparent"></div>
                        </div>

                        <div class="relative z-10 max-w-7xl mx-auto px-8 h-full flex items-center">
                            <div class="max-w-3xl">
                                <span class="font-label text-[10px] tracking-[0.5em] text-accent-gold uppercase block mb-6 animate-fade-in font-bold drop-shadow-md">L'EXCELLENCE</span>
                                <h1 class="font-headline text-[5rem] md:text-[7rem] leading-[0.85] tracking-[-0.05em] text-white font-extrabold mb-10 drop-shadow-2xl">
                                    {{ $fProduct->name }}
                                </h1>
                                <div class="flex items-center gap-10">
                                    <a class="btn-luxury group" href="{{ route('products.show', $fProduct) }}">
                                        <span class="flex items-center gap-2">Xem Chi Tiết <span class="material-symbols-outlined text-sm">arrow_outward</span></span>
                                    </a>
                                    <div class="h-px w-20 bg-white/20"></div>
                                    <span class="font-headline text-2xl text-white/60 italic">{{ $fProduct->formatted_price }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="swiper-slide relative bg-luxury-dark flex items-center justify-center">
                        <h2 class="text-white font-headline text-5xl italic tracking-tighter">ZEST OUTFIT</h2>
                    </div>
                @endforelse
            </div>
            <div class="swiper-pagination !bottom-12 !left-8 !text-left !w-auto"></div>
            
            {{-- Navigation Buttons --}}
            <div class="absolute bottom-12 right-8 lg:right-12 z-20 flex gap-4">
                <div class="hero-prev w-12 h-12 rounded-full border border-white/20 flex items-center justify-center text-white hover:bg-white hover:text-luxury-dark transition-all cursor-pointer">
                    <span class="material-symbols-outlined text-xl">chevron_left</span>
                </div>
                <div class="hero-next w-12 h-12 rounded-full border border-white/20 flex items-center justify-center text-white hover:bg-white hover:text-luxury-dark transition-all cursor-pointer">
                    <span class="material-symbols-outlined text-xl">chevron_right</span>
                </div>
            </div>
        </div>
    </section>

    {{-- New Arrivals: Mosaic Editorial Grid --}}
    <section class="py-32 px-8 max-w-7xl mx-auto bg-white">
        <div class="flex flex-col md:flex-row justify-between items-baseline mb-24">
            <div>
                <h2 class="font-headline text-6xl font-extrabold text-luxury-dark tracking-tighter mb-4">Mới Nhất</h2>
                <p class="font-body text-on-surface-variant text-lg italic opacity-60">Những thiết kế thiết yếu cho mùa mới.</p>
            </div>
            <a class="font-label text-[10px] text-luxury-dark uppercase tracking-[0.4em] border-b border-accent-gold pb-2 hover:text-accent-gold transition-all"
               href="{{ route('products.index') }}">Xem Tất Cả Sản Phẩm</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-x-12 gap-y-24">
            @forelse($products as $index => $product)
                @php
                    // Create an asymmetric rhythm
                    $span = 'md:col-span-4';
                    if ($index % 5 == 0) $span = 'md:col-span-7';
                    if ($index % 5 == 1) $span = 'md:col-span-5';
                    if ($index % 5 == 2) $span = 'md:col-span-4';
                    if ($index % 5 == 3) $span = 'md:col-span-4';
                    if ($index % 5 == 4) $span = 'md:col-span-4';
                    
                    // Add vertical offset to some items
                    $marginTop = ($index % 2 != 0) ? 'md:mt-24' : '';
                @endphp
                
                <div class="{{ $span }} {{ $marginTop }}">
                    <x-product-card :product="$product" :featured="$index % 5 == 0" />
                </div>
            @empty
                <div class="md:col-span-12 text-center py-20">
                    <p class="font-body text-on-surface-variant text-lg">Sắp ra mắt...</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- Categories: Clean Grid --}}
    @if($categories->count() > 0)
    <section class="py-32 px-8 max-w-7xl mx-auto border-t border-stone-100">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center mb-24">
            <h2 class="font-headline text-5xl font-extrabold text-luxury-dark tracking-tighter leading-[0.9]">Khám Phá<br>Bộ Sưu Tập</h2>
            <p class="font-body text-on-surface-variant text-base opacity-60 max-w-md">Tìm kiếm phong cách hoàn hảo của bạn qua các dòng sản phẩm cao cấp và phụ kiện đa dạng.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach($categories->take(6) as $category)
                @php $bgImage = $categoryImages[$category->name] ?? $defaultCatImage; @endphp
                <a href="{{ route('categories.show', $category->id) }}"
                   class="group block relative aspect-[4/5] overflow-hidden bg-stone-100">
                    <img src="{{ $bgImage }}" alt="{{ $category->name }}" 
                         class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105 opacity-80 group-hover:opacity-100"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-luxury-dark/60 via-transparent to-transparent"></div>
                    <div class="absolute bottom-8 left-8 text-white">
                        <h3 class="font-headline text-2xl font-bold mb-1">{{ $category->name }}</h3>
                        <p class="font-label text-[9px] uppercase tracking-widest opacity-60">{{ $category->products_count }} SẢN PHẨM</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
    @endif
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Swiper('.heroSwiper', {
            loop: true,
            speed: 1500,
            autoplay: { delay: 6000, disableOnInteraction: false },
            pagination: { 
                el: '.swiper-pagination', 
                clickable: true,
                renderBullet: function (index, className) {
                    return '<span class="' + className + ' !bg-white/30 !w-8 !h-px !rounded-none hover:!bg-white transition-all"></span>';
                }
            },
            navigation: {
                nextEl: '.hero-next',
                prevEl: '.hero-prev',
            },
            effect: 'fade',
            fadeEffect: { crossFade: true },
        });
    });
</script>
@endpush
