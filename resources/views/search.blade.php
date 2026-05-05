@extends('layouts.app')

@section('title', 'Tìm kiếm - FashionGZ')

@section('content')
<div class="bg-surface flex flex-col min-h-screen">
    {{-- Hero Search Section --}}
    <section class="relative w-full h-[60vh] min-h-[500px] flex items-center justify-center px-4 sm:px-8 mt-[72px] z-30">
        {{-- Background Image with Overlay --}}
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1445205170230-053b83016050?q=80&w=2071&auto=format&fit=crop" alt="Fashion Search Background" class="w-full h-full object-cover opacity-90">
            <div class="absolute inset-0 bg-surface/70 mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-surface to-transparent"></div>
        </div>

        {{-- Search Content --}}
        <div class="relative z-10 w-full max-w-3xl flex flex-col gap-8 -mt-10">
            <div class="text-center">
                <h1 class="font-headline text-5xl sm:text-6xl font-bold text-on-surface mb-6 drop-shadow-sm">Khám phá phong cách</h1>
                <p class="font-body text-lg text-on-surface-variant font-medium">Tìm kiếm bộ sưu tập, sản phẩm hoặc xu hướng mới nhất.</p>
            </div>

            <form action="{{ route('products.index') }}" method="GET" class="relative z-20 w-full group">
                <div class="relative flex items-center transform transition-all duration-300 group-focus-within:-translate-y-1 group-focus-within:shadow-[0_20px_40px_rgba(27,28,28,0.1)] rounded-full">
                    <span class="material-symbols-outlined absolute left-8 text-3xl text-outline-variant transition-colors group-focus-within:text-primary z-10">search</span>
                    <input type="text" name="search" id="search-input" autocomplete="off" autofocus
                           class="w-full bg-white/95 backdrop-blur-md border-0 rounded-full py-6 pl-20 pr-36 text-xl font-body text-on-surface placeholder-outline-variant focus:ring-2 focus:ring-primary/20 transition-all shadow-lg"
                           placeholder="Bạn đang tìm gì?">
                    <button type="submit" class="absolute right-3 top-3 bottom-3 bg-primary text-on-primary px-8 rounded-full font-label text-sm uppercase tracking-wider hover:bg-primary-container hover:shadow-md transition-all duration-300">
                        Tìm Kiếm
                    </button>
                </div>

                {{-- Khu vực hiển thị gợi ý Realtime --}}
                <div id="suggestions-container" class="absolute top-full left-0 right-0 mt-4 bg-white rounded-2xl shadow-[0_20px_60px_rgba(0,0,0,0.15)] border border-stone-100 overflow-hidden hidden z-[9999]">
                    <div class="p-4 border-b border-stone-50 bg-stone-50/50 flex justify-between items-center">
                        <span class="font-label text-[10px] uppercase tracking-widest text-stone-400 font-bold">Sản phẩm gợi ý</span>
                        <div id="search-spinner" class="hidden w-4 h-4 border-2 border-accent-gold border-t-transparent rounded-full animate-spin"></div>
                    </div>
                    <ul id="suggestions-list" class="flex flex-col max-h-[50vh] overflow-y-auto">
                        <!-- Các gợi ý sẽ được đổ vào đây bằng JS -->
                    </ul>
                    <div id="no-results" class="hidden p-8 text-center text-stone-400 font-body text-sm italic">
                        Không tìm thấy sản phẩm nào phù hợp.
                    </div>
                    <button type="submit" class="w-full p-4 bg-stone-50 text-accent-gold font-label text-[10px] uppercase tracking-widest hover:bg-stone-100 transition-colors text-center border-t border-stone-100 font-bold">
                        Xem tất cả kết quả
                    </button>
                </div>
            </form>
        </div>
    </section>

    {{-- Popular Collections Section --}}
    <section class="w-full max-w-7xl mx-auto px-4 sm:px-8 pb-24 -mt-10 relative z-10">
        <h2 class="font-headline text-2xl font-bold text-luxury-dark mb-8 text-center scroll-reveal">Xu Hướng Nổi Bật</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
            {{-- Category Card 1 --}}
            <a href="{{ route('products.index', ['search' => 'Áo']) }}" class="group relative aspect-[4/5] rounded-xl overflow-hidden bg-stone-100 block scroll-reveal delay-100">
                <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=1780&auto=format&fit=crop" alt="Áo thun" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6 flex flex-col">
                    <span class="font-label text-[10px] uppercase tracking-widest text-white/70 mb-1 font-bold">Danh mục</span>
                    <span class="font-headline text-xl text-white font-semibold">Áo Nam/Nữ</span>
                </div>
            </a>

            {{-- Category Card 2 --}}
            <a href="{{ route('products.index', ['search' => 'Quần']) }}" class="group relative aspect-[4/5] rounded-xl overflow-hidden bg-stone-100 block scroll-reveal delay-200">
                <img src="https://images.unsplash.com/photo-1542272604-787c3835535d?q=80&w=1926&auto=format&fit=crop" alt="Quần Jean" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6 flex flex-col">
                    <span class="font-label text-[10px] uppercase tracking-widest text-white/70 mb-1 font-bold">Danh mục</span>
                    <span class="font-headline text-xl text-white font-semibold">Quần Thiết Kế</span>
                </div>
            </a>

            {{-- Category Card 3 --}}
            <a href="{{ route('products.index', ['search' => 'Đầm']) }}" class="group relative aspect-[4/5] rounded-xl overflow-hidden bg-stone-100 block scroll-reveal delay-300">
                <img src="https://images.unsplash.com/photo-1566174053879-31528523f8ae?q=80&w=800&q=80" alt="Váy Đầm" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6 flex flex-col">
                    <span class="font-label text-[10px] uppercase tracking-widest text-white/70 mb-1 font-bold">Mùa hè</span>
                    <span class="font-headline text-xl text-white font-semibold">Váy & Đầm</span>
                </div>
            </a>

            {{-- Category Card 4 --}}
            <a href="{{ route('products.index', ['search' => 'Phụ kiện']) }}" class="group relative aspect-[4/5] rounded-xl overflow-hidden bg-stone-100 block scroll-reveal delay-400">
                <img src="https://images.unsplash.com/photo-1611591437281-460bfbe1220a?q=80&w=2070&auto=format&fit=crop" alt="Phụ kiện" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6 flex flex-col">
                    <span class="font-label text-[10px] uppercase tracking-widest text-white/70 mb-1 font-bold">Hoàn thiện</span>
                    <span class="font-headline text-xl text-white font-semibold">Phụ Kiện</span>
                </div>
            </a>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('search-input');
        const container = document.getElementById('suggestions-container');
        const list = document.getElementById('suggestions-list');
        const spinner = document.getElementById('search-spinner');
        const noResults = document.getElementById('no-results');
        let timeout = null;

        input.addEventListener('input', function(e) {
            const query = e.target.value.trim();

            clearTimeout(timeout);

            if (query.length === 0) {
                container.classList.add('hidden');
                return;
            }

            spinner.classList.remove('hidden');
            container.classList.remove('hidden');

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
                                    <a href="${product.url}" class="flex items-center gap-4 p-4 hover:bg-stone-50 transition-colors border-b border-stone-50 last:border-b-0 group">
                                        <div class="w-12 h-16 bg-stone-100 rounded overflow-hidden flex-shrink-0">
                                            <img src="${product.image}" alt="${product.name}" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex flex-col flex-1">
                                            <span class="font-headline text-lg text-luxury-dark group-hover:text-accent-gold transition-colors">${product.name}</span>
                                            <span class="font-label text-[9px] uppercase tracking-widest text-stone-400 font-bold">${product.category}</span>
                                        </div>
                                        <span class="font-body text-sm font-bold text-luxury-dark">${product.price}</span>
                                    </a>
                                `;
                                list.appendChild(li);
                            });
                        }
                    })
                    .catch(err => {
                        console.error('Search suggestion error:', err);
                        spinner.classList.add('hidden');
                    });
            }, 300);
        });

        document.addEventListener('click', function(e) {
            if (!container.contains(e.target) && e.target !== input) {
                container.classList.add('hidden');
            }
        });

        input.addEventListener('focus', function() {
            if (input.value.trim().length > 0) {
                container.classList.remove('hidden');
            }
        });
    });
</script>
@endsection

