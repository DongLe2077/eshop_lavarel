{{-- Trang Chi Tiết Sản Phẩm - Luxury Redesign --}}
@extends('layouts.app')

@section('title', $product->name . ' - FashionGZ')

@section('content')
    <section class="bg-white min-h-screen">
        <div class="max-w-7xl mx-auto px-8 py-12">
            {{-- Breadcrumb --}}
            <nav class="mb-12 flex items-center gap-2 font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant/60">
                <a href="{{ route('home') }}" class="hover:text-accent-gold transition-colors">Trang chủ</a>
                <span class="text-[8px] opacity-40">/</span>
                <a href="{{ route('products.index') }}" class="hover:text-accent-gold transition-colors">Sản phẩm</a>
                <span class="text-[8px] opacity-40">/</span>
                <span class="text-luxury-dark">{{ $product->name }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
                {{-- Left Side: Image Gallery --}}
                <div class="lg:col-span-7 space-y-8">
                    <div class="relative aspect-[3/4] overflow-hidden bg-stone-50 scroll-reveal" id="main-image-container">
                        <img alt="{{ $product->name }}"
                             id="main-product-image"
                             class="w-full h-full object-cover object-center hover:scale-110 transition-transform duration-[1.5s] ease-out cursor-zoom-in"
                             src="{{ $product->image ?: 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=1200&q=80' }}"
                             onclick="openLightbox(0)"/>
                        
                        {{-- Zoom Hint --}}
                        <div class="absolute bottom-6 left-6 flex items-center gap-2 text-white/60 bg-black/20 backdrop-blur-md px-3 py-1.5 rounded-full pointer-events-none">
                            <span class="material-symbols-outlined text-sm">zoom_in</span>
                            <span class="font-label text-[9px] uppercase tracking-widest">Click to expand</span>
                        </div>
                    </div>
                    
                    {{-- Secondary Images (Gallery) --}}
                    @if($product->images->count() > 0)
                        <div class="grid grid-cols-4 gap-4">
                            {{-- Add original image as first thumbnail --}}
                            <div class="aspect-[3/4] bg-stone-50 overflow-hidden cursor-pointer border-2 border-accent-gold thumbnail-item" 
                                 onclick="swapMainImage('{{ $product->image }}', this, 0)">
                                <img src="{{ $product->image }}" class="w-full h-full object-cover opacity-80 hover:opacity-100 transition-opacity">
                            </div>
                            
                            @foreach($product->images as $index => $gImage)
                                <div class="aspect-[3/4] bg-stone-50 overflow-hidden cursor-pointer border-2 border-transparent hover:border-stone-200 transition-all thumbnail-item"
                                     onclick="swapMainImage('{{ $gImage->image_path }}', this, {{ $index + 1 }})">
                                     <img src="{{ $gImage->image_path }}" class="w-full h-full object-cover opacity-80 hover:opacity-100 transition-opacity">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Right Side: Sticky Product Info --}}
                <div class="lg:col-span-5 lg:sticky lg:top-32 space-y-12">
                    <div class="scroll-reveal">
                        <span class="font-label text-[10px] tracking-[0.4em] text-accent-gold uppercase block mb-6 font-bold">
                            {{ $product->category->name ?? 'Collection' }}
                        </span>
                        <h1 class="font-headline text-5xl font-bold text-luxury-dark leading-tight mb-4 tracking-tighter">
                            {{ $product->name }}
                        </h1>
                        <p class="font-body text-2xl text-on-surface-variant font-light tracking-wide italic">
                            {{ $product->formatted_price }}
                        </p>
                    </div>

                    <div class="space-y-6 scroll-reveal delay-100">
                        <div class="h-px w-20 bg-accent-gold"></div>
                        <p class="font-body text-on-surface-variant text-base leading-relaxed opacity-80">
                            {{ $product->description ?: 'Một thiết kế vượt thời gian, kết hợp giữa kỹ nghệ may mặc thủ công và chất liệu vải cao cấp. Hoàn hảo cho phong cách Minimalist hiện đại.' }}
                        </p>
                    </div>

                    {{-- Actions --}}
                    <div class="space-y-8 scroll-reveal delay-200">
                        @if($product->quanlity > 0)
                            <div class="space-y-8">
                                {{-- Quantity & Meta --}}
                                <div class="flex items-center justify-between border-y border-stone-100 py-6">
                                    <div class="flex items-center gap-6">
                                        <span class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant font-bold">Số lượng</span>
                                        <div class="flex items-center gap-4">
                                            <button type="button" onclick="this.nextElementSibling.stepDown()" class="text-luxury-dark hover:text-accent-gold transition-colors font-bold">−</button>
                                            <input type="number" name="quantity" id="product-qty" value="1" min="1" max="{{ $product->quanlity }}" class="w-12 text-center bg-transparent border-none focus:ring-0 font-body text-sm font-bold">
                                            <button type="button" onclick="this.previousElementSibling.stepUp()" class="text-luxury-dark hover:text-accent-gold transition-colors font-bold">+</button>
                                        </div>
                                    </div>
                                    <span class="font-label text-[9px] uppercase tracking-widest text-accent-gold bg-accent-gold/5 px-3 py-1 rounded-full font-bold">
                                        {{ $product->quanlity }} Có sẵn
                                    </span>
                                </div>

                                <div class="flex items-center gap-4">
                                    <button type="button" 
                                            onclick="addToCart({{ $product->id }}, document.getElementById('product-qty').value)"
                                            class="btn-luxury flex-1 flex items-center justify-center gap-2 !bg-transparent border-2 border-accent-gold !text-accent-gold hover:!bg-accent-gold hover:!text-white transition-colors duration-300">
                                        <span class="material-symbols-outlined text-sm">shopping_cart</span>
                                        <span>Giỏ Hàng</span>
                                    </button>
                                    
                                    <button type="button" 
                                            onclick="buyNow({{ $product->id }}, document.getElementById('product-qty').value)"
                                            class="btn-luxury flex-1 flex items-center justify-center gap-2">
                                        <span>Mua Ngay</span>
                                        <span class="material-symbols-outlined text-sm">bolt</span>
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="w-full py-5 bg-stone-50 text-stone-400 font-label text-[10px] uppercase tracking-[0.3em] text-center border border-stone-100 font-bold">
                                Sản phẩm đã hết hàng
                            </div>
                        @endif
                        
                        {{-- Secondary Actions --}}
                        <div class="flex justify-center gap-12 pt-4">
                            <button class="flex items-center gap-2 group">
                                <span class="material-symbols-outlined text-lg text-stone-400 group-hover:text-accent-gold transition-colors">favorite</span>
                                <span class="font-label text-[9px] uppercase tracking-widest text-stone-400 group-hover:text-luxury-dark transition-colors font-bold">Yêu thích</span>
                            </button>
                            <button class="flex items-center gap-2 group">
                                <span class="material-symbols-outlined text-lg text-stone-400 group-hover:text-accent-gold transition-colors">share</span>
                                <span class="font-label text-[9px] uppercase tracking-widest text-stone-400 group-hover:text-luxury-dark transition-colors font-bold">Chia sẻ</span>
                            </button>
                        </div>
                    </div>

                    {{-- Product Tabs --}}
                    <div class="pt-8 scroll-reveal delay-300">
                        <div class="border-t border-stone-100">
                            <details class="group py-6" open>
                                <summary class="flex justify-between items-center cursor-pointer list-none">
                                    <span class="font-label text-[10px] uppercase tracking-widest text-luxury-dark font-bold">Chi tiết sản phẩm</span>
                                    <span class="material-symbols-outlined text-stone-400 transition-transform group-open:rotate-180">expand_more</span>
                                </summary>
                                <div class="mt-6 font-body text-sm text-on-surface-variant leading-relaxed opacity-70">
                                    <ul class="space-y-2">
                                        <li>• 100% Cotton hữu cơ nhập khẩu.</li>
                                        <li>• Đường may tỉ mỉ, độ bền cao.</li>
                                        <li>• Thiết kế Unstructured tạo sự thoải mái.</li>
                                        <li>• Sản xuất giới hạn tại Việt Nam.</li>
                                    </ul>
                                </div>
                            </details>
                            <details class="group py-6 border-t border-stone-100">
                                <summary class="flex justify-between items-center cursor-pointer list-none">
                                    <span class="font-label text-[10px] uppercase tracking-widest text-luxury-dark font-bold">Vận chuyển & Đổi trả</span>
                                    <span class="material-symbols-outlined text-stone-400 transition-transform group-open:rotate-180">expand_more</span>
                                </summary>
                                <div class="mt-6 font-body text-sm text-on-surface-variant leading-relaxed opacity-70">
                                    Giao hàng miễn phí cho đơn hàng trên 1.000.000đ. Chính sách đổi trả trong vòng 30 ngày kể từ khi nhận hàng.
                                </div>
                            </details>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Related Products --}}
            @if($relatedProducts->count() > 0)
                <section class="mt-48 pt-24 border-t border-stone-100">
                    <div class="flex flex-col md:flex-row justify-between items-end mb-20 gap-6">
                        <div>
                            <h2 class="font-headline text-5xl font-extrabold text-luxury-dark tracking-tighter mb-4">Bạn cũng sẽ thích</h2>
                            <p class="font-body text-on-surface-variant text-lg italic opacity-60">Gợi ý sản phẩm phù hợp phong cách.</p>
                        </div>
                        <a class="font-label text-[10px] text-luxury-dark uppercase tracking-[0.4em] border-b border-accent-gold pb-2 hover:text-accent-gold transition-all font-bold"
                           href="{{ route('products.index') }}">Xem Toàn Bộ</a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-x-12 gap-y-24">
                        @foreach($relatedProducts->take(4) as $related)
                            <x-product-card :product="$related" :featured="false" />
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </section>

    {{-- Lightbox Modal --}}
    <div id="lightbox" class="fixed inset-0 z-[100] bg-black/95 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-500 flex flex-col items-center justify-center p-4 lg:p-12">
        <button onclick="closeLightbox()" class="absolute top-8 right-8 text-white/50 hover:text-white transition-colors">
            <span class="material-symbols-outlined text-4xl">close</span>
        </button>
        
        <div class="relative w-full h-full flex items-center justify-center">
            <button onclick="prevLightbox()" class="absolute left-0 lg:left-8 text-white/30 hover:text-white transition-all">
                <span class="material-symbols-outlined text-6xl">chevron_left</span>
            </button>
            
            <img id="lightbox-image" src="" class="max-w-full max-h-full object-contain select-none shadow-2xl">
            
            <button onclick="nextLightbox()" class="absolute right-0 lg:right-8 text-white/30 hover:text-white transition-all">
                <span class="material-symbols-outlined text-6xl">chevron_right</span>
            </button>
        </div>

        {{-- Lightbox Caption --}}
        <div class="mt-8 text-center">
            <p class="font-headline text-white text-xl tracking-widest uppercase">{{ $product->name }}</p>
            <p id="lightbox-counter" class="font-label text-white/40 text-[10px] mt-2 uppercase tracking-[0.3em]"></p>
        </div>
    </div>

    <script>
        const galleryImages = [
            '{{ $product->image }}',
            @foreach($product->images as $gImage)
                '{{ $gImage->image_path }}',
            @endforeach
        ];
        
        let currentImageIndex = 0;

        function swapMainImage(src, element, index) {
            const mainImg = document.getElementById('main-product-image');
            
            // Fade out
            mainImg.style.opacity = '0';
            
            setTimeout(() => {
                mainImg.src = src;
                currentImageIndex = index;
                mainImg.style.opacity = '1';
            }, 300);

            // Update thumbnails
            document.querySelectorAll('.thumbnail-item').forEach(item => {
                item.classList.remove('border-accent-gold');
                item.classList.add('border-transparent');
            });
            element.classList.remove('border-transparent');
            element.classList.add('border-accent-gold');
        }

        function openLightbox(index) {
            currentImageIndex = index;
            updateLightbox();
            const lightbox = document.getElementById('lightbox');
            lightbox.classList.remove('opacity-0', 'pointer-events-none');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            const lightbox = document.getElementById('lightbox');
            lightbox.classList.add('opacity-0', 'pointer-events-none');
            document.body.style.overflow = '';
        }

        function updateLightbox() {
            const img = document.getElementById('lightbox-image');
            img.src = galleryImages[currentImageIndex];
            document.getElementById('lightbox-counter').innerText = `IMAGE ${currentImageIndex + 1} OF ${galleryImages.length}`;
        }

        function nextLightbox() {
            currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
            updateLightbox();
        }

        function prevLightbox() {
            currentImageIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
            updateLightbox();
        }

        // Close on ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowRight' && !document.getElementById('lightbox').classList.contains('opacity-0')) nextLightbox();
            if (e.key === 'ArrowLeft' && !document.getElementById('lightbox').classList.contains('opacity-0')) prevLightbox();
        });
    </script>
@endsection

