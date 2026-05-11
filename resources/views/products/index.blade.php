{{-- Trang Danh Sách Sản Phẩm - Trích xuất từ Stitch UI "search.html" --}}
@extends('layouts.app')

@section('title', 'Sản Phẩm - FashionGZ')

@section('content')
    <section class="py-12 px-4 sm:px-8 max-w-7xl mx-auto w-full flex flex-col gap-16">
        {{-- Search Header --}}
        <div class="flex flex-col gap-4 max-w-3xl">
            <h1 class="font-headline text-[3.5rem] leading-[1.1] tracking-[-0.02em] text-on-surface">
                @if(request('search'))
                    Kết quả cho "{{ request('search') }}"
                @elseif(isset($category))
                    {{ $category->name }}
                @else
                    Tất Cả Sản Phẩm
                @endif
            </h1>
            <p class="text-sm text-on-surface-variant max-w-xl leading-relaxed">
                Hiển thị {{ $products->total() }} sản phẩm.
            </p>
        </div>

        {{-- Search & Filter Bar --}}
        <section class="py-4 -mx-4 sm:-mx-8 px-4 sm:px-8 flex flex-col md:flex-row justify-between items-center gap-4 bg-surface-container-low relative">
            <form method="GET" action="{{ route('products.index') }}" class="flex items-center gap-4 flex-1">
                <div class="flex items-center relative flex-1 max-w-md" id="search-wrapper">
                    <input class="bg-transparent border-b border-outline-variant focus:border-primary focus:outline-none focus:ring-0 text-sm py-1 px-2 w-full transition-colors text-on-surface placeholder-on-surface-variant"
                           name="search" id="product-search-input" autocomplete="off" placeholder="Tìm kiếm sản phẩm..." type="text" value="{{ request('search') }}"/>
                    <button type="submit" class="absolute right-0 text-on-surface-variant hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[1.25rem]">search</span>
                    </button>

                    {{-- Khu vực hiển thị gợi ý Realtime --}}
                    <div id="product-suggestions-container" class="absolute top-full left-0 right-0 mt-2 bg-white rounded shadow-[0_10px_40px_rgba(0,0,0,0.08)] border border-surface-variant overflow-hidden hidden transform transition-all duration-300 origin-top opacity-0 scale-y-95 max-h-[70vh] overflow-y-auto">
                        <div class="p-3 border-b border-surface-variant bg-surface-container-lowest flex justify-between items-center">
                            <span class="font-label text-[10px] uppercase tracking-widest text-outline">Gợi ý sản phẩm</span>
                            <div id="product-search-spinner" class="hidden w-3 h-3 border-2 border-primary border-t-transparent rounded-full animate-spin"></div>
                        </div>
                        <ul id="product-suggestions-list" class="flex flex-col">
                            <!-- JS fill -->
                        </ul>
                        <div id="product-no-results" class="hidden p-4 text-center text-on-surface-variant font-body text-xs">
                            Không tìm thấy kết quả.
                        </div>
                    </div>
                </div>
            </form>
            <div class="flex items-center gap-2">
                <label class="sr-only" for="sort">Sắp xếp</label>
                <form method="GET" action="{{ route('products.index') }}">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <select name="sort" id="sort" onchange="this.form.submit()"
                            class="bg-transparent border-none text-xs font-label uppercase tracking-widest text-on-surface focus:ring-0 cursor-pointer hover:text-primary transition-colors">
                        <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Mới nhất</option>
                        <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Giá: Thấp → Cao</option>
                        <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Giá: Cao → Thấp</option>
                        <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Phổ biến nhất</option>
                    </select>
                </form>
            </div>
        </section>

        {{-- Product Grid --}}
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-14">
            @forelse($products as $product)
                <article class="group scroll-reveal">
                    <a href="{{ route('products.show', $product) }}" class="relative block aspect-[3/4] overflow-hidden bg-surface-container mb-6">
                        <img alt="{{ $product->name }}"
                             class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105"
                             src="{{ $product->image_url }}"/>
                        
                        {{-- Badges --}}
                        @if($product->quanlity <= 5 && $product->quanlity > 0)
                            <span class="absolute top-4 left-4 bg-luxury-dark text-white text-[10px] font-label px-3 py-1 uppercase tracking-widest z-10">Limited</span>
                        @elseif($product->quanlity == 0)
                            <span class="absolute top-4 left-4 bg-outline-variant text-on-surface-variant text-[10px] font-label px-3 py-1 uppercase tracking-widest z-10">Sold Out</span>
                        @endif
                        
                        {{-- Hover Overlay --}}
                        <div class="absolute inset-0 bg-luxury-dark/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        {{-- Quick Add to Cart --}}
                        <div class="absolute bottom-0 left-0 right-0 p-5 translate-y-full group-hover:translate-y-0 transition-transform duration-500 z-20">
                            @if($product->quanlity > 0)
                                <form action="{{ route('cart.add') }}" method="POST" onclick="event.stopPropagation();">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" onclick="event.preventDefault(); event.stopPropagation(); this.closest('form').submit();" class="w-full bg-white text-luxury-dark py-3 text-[10px] font-label uppercase tracking-[0.2em] hover:bg-luxury-dark hover:text-white transition-all duration-300 shadow-xl">
                                        Thêm vào giỏ
                                    </button>
                                </form>
                            @endif
                        </div>
                    </a>
                    <div class="text-center">
                        <p class="font-label text-[10px] uppercase tracking-[0.3em] text-on-surface-variant mb-2">{{ $product->category->name ?? 'Chưa phân loại' }}</p>
                        <h3 class="font-headline text-lg text-on-surface mb-2 group-hover:text-accent-gold transition-colors duration-300">
                            <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                        </h3>
                        <p class="font-body text-sm font-medium text-on-surface-variant tracking-wide">{{ $product->formatted_price }}</p>
                    </div>
                </article>
            @empty
                <div class="col-span-full text-center py-20">
                    <span class="material-symbols-outlined text-6xl text-outline-variant mb-4">search_off</span>
                    <p class="font-body text-on-surface-variant text-lg">Không tìm thấy sản phẩm nào.</p>
                </div>
            @endforelse
        </section>

        {{-- Pagination --}}
        @if($products->hasPages())
            <div class="flex justify-center mt-8">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @endif
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('product-search-input');
            const container = document.getElementById('product-suggestions-container');
            const list = document.getElementById('product-suggestions-list');
            const spinner = document.getElementById('product-search-spinner');
            const noResults = document.getElementById('product-no-results');
            const wrapper = document.getElementById('search-wrapper');
            let timeout = null;

            if(!input) return;

            input.addEventListener('input', function(e) {
                const query = e.target.value.trim();
                clearTimeout(timeout);

                if (query.length === 0) {
                    hideSuggestions();
                    return;
                }

                spinner.classList.remove('hidden');
                showSuggestions();

                timeout = setTimeout(() => {
                    fetch(`{{ route('search.suggest') }}?q=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            spinner.classList.add('hidden');
                            list.innerHTML = '';

                            if (data.length === 0) {
                                noResults.classList.remove('hidden');
                            } else {
                                noResults.classList.add('hidden');
                                data.forEach(product => {
                                    const li = document.createElement('li');
                                    li.innerHTML = `
                                        <a href="${product.url}" class="flex items-center gap-3 p-3 hover:bg-surface-container-high transition-colors border-b border-surface-variant last:border-b-0 group">
                                            <div class="w-10 h-12 bg-surface-variant rounded overflow-hidden flex-shrink-0">
                                                <img src="${product.image}" alt="${product.name}" class="w-full h-full object-cover">
                                            </div>
                                            <div class="flex flex-col flex-1">
                                                <span class="font-headline text-sm font-semibold text-on-surface group-hover:text-primary transition-colors line-clamp-1">${product.name}</span>
                                                <span class="font-label text-[10px] uppercase text-outline line-clamp-1">${product.category}</span>
                                            </div>
                                            <span class="font-body text-xs font-semibold text-on-surface whitespace-nowrap">${product.price}</span>
                                        </a>
                                    `;
                                    list.appendChild(li);
                                });
                            }
                        });
                }, 300);
            });

            document.addEventListener('click', function(e) {
                if (!wrapper.contains(e.target)) {
                    hideSuggestions();
                }
            });

            input.addEventListener('focus', function() {
                if (input.value.trim().length > 0) {
                    showSuggestions();
                }
            });

            function showSuggestions() {
                container.classList.remove('hidden');
                setTimeout(() => {
                    container.classList.remove('opacity-0', 'scale-y-95');
                    container.classList.add('opacity-100', 'scale-y-100');
                }, 10);
            }

            function hideSuggestions() {
                container.classList.add('opacity-0', 'scale-y-95');
                container.classList.remove('opacity-100', 'scale-y-100');
                setTimeout(() => {
                    container.classList.add('hidden');
                }, 300);
            }
        });
    </script>
@endsection

