{{-- Trang Danh Mục - Trích xuất từ Stitch UI "category.html" --}}
@extends('layouts.app')

@section('title', 'Danh Mục - FashionGZ')

@section('content')
    <section class="py-12 px-4 sm:px-8 max-w-7xl mx-auto">
        <div class="mb-16">
            <h1 class="font-headline text-[3.5rem] leading-[1.1] tracking-[-0.02em] text-on-surface mb-4">Danh Mục</h1>
            <p class="font-body text-on-surface-variant">Khám phá các bộ sưu tập được tuyển chọn dành cho bạn.</p>
        </div>

        @php
            $categoryImages = [
                'Áo' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800&q=80',
                'Quần' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?w=800&q=80',
                'Váy & Đầm' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=800&q=80',
                'Phụ Kiện' => 'https://images.unsplash.com/photo-1576053139778-7e32f2ae3cfd?w=800&q=80',
                'Giày Dép' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=800&q=80',
                'Túi Xách' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?w=800&q=80',
            ];
            $defaultImage = 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800&q=80';
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($categories as $category)
                @php
                    $bgImage = $categoryImages[$category->name] ?? $defaultImage;
                @endphp
                <a href="{{ route('categories.show', $category->id) }}"
                   class="group relative bg-neutral-900 rounded-lg overflow-hidden min-h-[450px] flex flex-col justify-end p-8 hover:shadow-[0_20px_50px_rgba(0,0,0,0.3)] transition-all duration-700">
                    
                    {{-- Background Image with dynamic overlay --}}
                    <div class="absolute inset-0 z-0">
                        <img src="{{ $bgImage }}" alt="{{ $category->name }}" 
                             class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110 opacity-70 group-hover:opacity-90"/>
                        <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-neutral-950/20 to-transparent opacity-80 group-hover:opacity-60 transition-opacity duration-500"></div>
                    </div>

                    <div class="relative z-10 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                        <span class="font-label text-[10px] tracking-[0.3em] text-primary-fixed-dim uppercase mb-4 block font-bold">Bộ sưu tập</span>
                        <h2 class="font-headline text-3xl font-extrabold text-white mb-2 tracking-tight">{{ $category->name }}</h2>
                        <p class="font-body text-xs text-white/60 tracking-widest uppercase mb-6">{{ $category->products_count }} sản phẩm hiện có</p>
                        
                        <div class="flex items-center text-white font-label text-[10px] uppercase tracking-[0.2em] font-bold">
                            <span class="border-b border-white/30 pb-1 group-hover:border-white transition-colors duration-300">Khám phá ngay</span>
                            <span class="material-symbols-outlined ml-2 text-sm transform group-hover:translate-x-2 transition-transform duration-300">arrow_forward</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-20">
                    <span class="material-symbols-outlined text-6xl text-outline-variant mb-4">category</span>
                    <p class="font-body text-on-surface-variant text-lg">Chưa có danh mục nào.</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection

