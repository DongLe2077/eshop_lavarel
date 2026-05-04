{{-- Product Card Component - Editorial Luxury Style --}}
@props(['product', 'featured' => false])

<div class="group relative {{ $featured ? 'md:col-span-6' : 'md:col-span-3' }} scroll-reveal hover-lift">
    <div class="relative overflow-hidden bg-stone-50 aspect-[3/4]">
        {{-- Main Image --}}
        <a href="{{ route('products.show', $product) }}" class="block w-full h-full">
            <img alt="{{ $product->name }}"
                 class="w-full h-full object-cover grayscale-[0.2] group-hover:grayscale-0 group-hover:scale-110 transition-all duration-1000 ease-out"
                 src="{{ $product->image ?: 'https://placehold.co/600x800/e5e2e1/56423e?text=' . urlencode($product->name) }}"/>
        </a>
        
        {{-- Floating Badges --}}
        <div class="absolute top-4 left-4 z-20 flex flex-col gap-2">
            @if($product->quanlity <= 5 && $product->quanlity > 0)
                <span class="bg-luxury-dark text-white text-[9px] font-label px-2 py-0.5 uppercase tracking-widest">Limited</span>
            @endif
        </div>

        {{-- Luxury Hover Actions --}}
        <div class="absolute inset-x-0 bottom-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-500 z-30 bg-white/90 backdrop-blur-sm">
            @if($product->quanlity > 0)
                <button type="button" 
                        onclick="addToCart({{ $product->id }})" 
                        class="w-full text-luxury-dark py-2 text-[10px] font-label uppercase tracking-[0.2em] hover:text-accent-gold transition-colors font-bold">
                    Thêm vào giỏ +
                </button>
            @endif
        </div>
    </div>

    {{-- Product Info - Minimalist --}}
    <div class="mt-5 space-y-1">
        <div class="flex justify-between items-baseline gap-4">
            <h3 class="font-headline text-sm font-bold text-luxury-dark hover:text-accent-gold transition-colors truncate">
                <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
            </h3>
            <span class="font-body text-xs text-on-surface-variant whitespace-nowrap">{{ $product->formatted_price }}</span>
        </div>
        <p class="font-label text-[9px] uppercase tracking-[0.2em] text-on-surface-variant/60">{{ $product->category->name ?? 'Collection' }}</p>
    </div>
</div>
