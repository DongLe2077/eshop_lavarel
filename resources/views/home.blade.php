{{-- Trang Chủ - Editorial Mosaic Redesign --}}
@extends('layouts.app')

@section('title', 'FashionGZ - Thời trang cao cấp')

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

    {{-- Hero Slider Section: Split Screen 50/50 --}}
    <section class="relative w-full h-[750px] md:h-[850px] bg-white overflow-hidden border-b border-stone-100">
        <div class="swiper heroSwiper w-full h-full">
            <div class="swiper-wrapper">
                @forelse($featuredProducts as $fProduct)
                    <div class="swiper-slide w-full h-full flex flex-col md:flex-row">
                        {{-- Left Side: Minimalist Text Content --}}
                        <div class="w-full md:w-1/2 h-1/2 md:h-full flex items-center justify-center p-10 lg:p-24 bg-[#FBF9F6]">
                            <div class="max-w-xl w-full flex flex-col justify-center">
                                <span class="font-label text-[11px] tracking-[0.4em] text-stone-500 uppercase font-bold mb-6 flex items-center gap-4">
                                    <span class="w-8 h-px bg-stone-400"></span>
                                    Mới Nhất / {{ $fProduct->category->name ?? 'Collection' }}
                                </span>
                                
                                <h1 class="font-headline text-5xl md:text-7xl lg:text-[5.5rem] leading-[0.95] text-luxury-dark font-black mb-8 tracking-tighter">
                                    {{ $fProduct->name }}
                                </h1>
                                
                                <p class="font-body text-lg md:text-xl text-stone-500 font-light mb-12 italic border-l-2 border-accent-gold pl-6 opacity-80">
                                    Sự kết hợp hoàn hảo giữa phong cách đương đại và chất lượng thủ công tuyệt mỹ. Khẳng định đẳng cấp cá nhân.
                                </p>
                                
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-8 mt-auto">
                                    <span class="font-headline text-3xl md:text-4xl text-luxury-dark font-bold">
                                        {{ $fProduct->formatted_price }}
                                    </span>
                                    <a class="btn-luxury !bg-luxury-dark !text-white hover:!bg-accent-gold !py-4 !px-8 flex items-center justify-center gap-3 transition-colors shadow-xl" href="{{ route('products.show', $fProduct) }}">
                                        <span class="font-bold tracking-widest text-xs uppercase">Xem Chi Tiết</span>
                                        <span class="material-symbols-outlined text-sm">trending_flat</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Right Side: Full Bleed Image --}}
                        <div class="w-full md:w-1/2 h-1/2 md:h-full relative overflow-hidden group">
                            <img alt="{{ $fProduct->name }}" 
                                 class="w-full h-full object-cover object-center transition-transform duration-[15s] ease-out group-hover:scale-110"
                                 src="{{ $fProduct->image ?: 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=1920&q=80' }}"/>
                            
                            {{-- Overlay for contrast --}}
                            <div class="absolute inset-0 bg-luxury-dark/5 group-hover:bg-transparent transition-colors duration-700"></div>
                        </div>
                    </div>
                @empty
                    <div class="swiper-slide flex items-center justify-center bg-[#FBF9F6] w-full h-full">
                        <h2 class="text-luxury-dark font-headline text-5xl italic tracking-tighter">FashionGZ</h2>
                    </div>
                @endforelse
            </div>
            
            {{-- Navigation Buttons (Minimalist style, placed bottom left of right section) --}}
            <div class="absolute bottom-6 right-6 md:right-auto md:left-[50%] md:bottom-12 z-20 flex gap-4 md:-translate-x-1/2">
                <div class="hero-prev w-12 h-12 md:w-16 md:h-16 bg-white/90 backdrop-blur-md border border-stone-100 rounded-full flex items-center justify-center text-luxury-dark hover:bg-luxury-dark hover:text-white hover:border-luxury-dark transition-all duration-300 cursor-pointer shadow-[0_10px_30px_rgba(0,0,0,0.1)]">
                    <span class="material-symbols-outlined md:text-2xl">arrow_back</span>
                </div>
                <div class="hero-next w-12 h-12 md:w-16 md:h-16 bg-white/90 backdrop-blur-md border border-stone-100 rounded-full flex items-center justify-center text-luxury-dark hover:bg-luxury-dark hover:text-white hover:border-luxury-dark transition-all duration-300 cursor-pointer shadow-[0_10px_30px_rgba(0,0,0,0.1)]">
                    <span class="material-symbols-outlined md:text-2xl">arrow_forward</span>
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

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 md:gap-6 auto-rows-[300px] md:auto-rows-[350px]">
            @forelse($products->take(5) as $index => $product)
                @php
                    // Bento Box Layout Logic
                    $span = 'md:col-span-1 md:row-span-1';
                    if ($index == 0) {
                        $span = 'md:col-span-2 md:row-span-2'; // Thẻ lớn nhất ở bên trái
                    }
                @endphp
                
                <div class="{{ $span }} group relative rounded-[2rem] overflow-hidden bg-stone-100 border border-stone-200/50 hover:shadow-2xl transition-all duration-500 flex flex-col">
                    <img src="{{ $product->image ?: 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=800&q=80' }}" alt="{{ $product->name }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" />
                    
                    {{-- Overlay Gradient --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-luxury-dark/90 via-luxury-dark/20 to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                    
                    {{-- Content --}}
                    <div class="relative flex-1 flex flex-col justify-end p-6 md:p-8 z-10">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-4">
                            <div class="flex-1">
                                <span class="inline-block px-3 py-1 mb-3 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-white font-label text-[10px] tracking-widest uppercase">
                                    Mới Nhất
                                </span>
                                <h3 class="font-headline text-white text-xl md:text-3xl font-extrabold leading-tight mb-1 line-clamp-2 drop-shadow-lg">
                                    {{ $product->name }}
                                </h3>
                            </div>
                            <div class="text-left sm:text-right shrink-0 flex items-center justify-between sm:block">
                                <span class="font-headline text-accent-gold text-lg md:text-2xl font-bold block sm:mb-3 drop-shadow-md">
                                    {{ $product->formatted_price ?? number_format($product->price, 0, ',', '.') . 'đ' }}
                                </span>
                                <a href="{{ route('products.show', $product) }}" class="inline-flex items-center justify-center w-10 h-10 md:w-12 md:h-12 rounded-full bg-white text-luxury-dark hover:bg-accent-gold hover:text-white transition-colors duration-300">
                                    <span class="material-symbols-outlined text-sm md:text-base">arrow_outward</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="md:col-span-4 text-center py-20 bg-stone-50 rounded-[2rem]">
                    <p class="font-body text-on-surface-variant text-lg">Đang cập nhật bộ sưu tập mới...</p>
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

