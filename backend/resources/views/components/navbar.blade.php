{{-- Navbar Component - Luxury Redesign --}}
<header id="main-header" class="fixed top-0 w-full z-50 bg-transparent transition-all duration-500">
    <nav aria-label="Main Navigation" class="flex justify-between items-center px-8 lg:px-12 py-5 max-w-full mx-auto transition-all duration-500">
        {{-- Brand Logo --}}
        <div class="flex-shrink-0">
            <a aria-label="Zest Outfit Home" class="flex items-center gap-3" href="{{ route('home') }}">
                <span class="text-2xl font-bold tracking-[-0.05em] text-neutral-900 font-headline">Zest</span>
                <span class="text-2xl font-light tracking-[-0.05em] text-neutral-900 font-headline">Outfit</span>
            </a>
        </div>

        {{-- Navigation Links (Desktop) --}}
        <div class="hidden md:flex flex-1 justify-center space-x-10">
            <a class="font-label text-[11px] uppercase tracking-[0.15em] {{ request()->routeIs('home') ? 'text-accent-gold font-bold' : 'text-neutral-600 hover:text-accent-gold transition-colors duration-300' }}"
               href="{{ route('home') }}">Trang Chủ</a>
            <a class="font-label text-[11px] uppercase tracking-[0.15em] {{ request()->routeIs('products.*') ? 'text-accent-gold font-bold' : 'text-neutral-600 hover:text-accent-gold transition-colors duration-300' }}"
               href="{{ route('products.index') }}">Sản Phẩm</a>
            <a class="font-label text-[11px] uppercase tracking-[0.15em] {{ request()->routeIs('categories.*') ? 'text-accent-gold font-bold' : 'text-neutral-600 hover:text-accent-gold transition-colors duration-300' }}"
               href="{{ route('categories.index') }}">Danh Mục</a>
        </div>

        {{-- Trailing Icon Actions --}}
        <div class="flex items-center space-x-5 text-neutral-700">
            <a href="{{ route('search.index') }}" aria-label="Tìm kiếm" class="hover:text-accent-gold transition-colors duration-300">
                <span class="material-symbols-outlined text-[22px]">search</span>
            </a>
            @auth
                <a href="{{ route('orders.index') }}" aria-label="Đơn hàng" class="hover:text-accent-gold transition-colors duration-300">
                    <span class="material-symbols-outlined text-[22px]">person</span>
                </a>
            @else
                <a href="{{ route('login') }}" aria-label="Đăng nhập" class="hover:text-accent-gold transition-colors duration-300">
                    <span class="material-symbols-outlined text-[22px]">person</span>
                </a>
            @endauth
            <a href="{{ route('cart.index') }}" aria-label="Giỏ hàng" class="hover:text-accent-gold transition-colors duration-300 relative">
                <span class="material-symbols-outlined text-[22px]">shopping_cart</span>
                <span class="cart-count-badge absolute -top-1.5 -right-1.5 w-4 h-4 rounded-full bg-accent-gold text-luxury-dark text-[9px] flex items-center justify-center font-bold {{ (session('cart') && count(session('cart')) > 0) ? '' : 'hidden' }}">
                    {{ session('cart') ? count(session('cart')) : 0 }}
                </span>
            </a>
            @auth
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" aria-label="Đăng xuất" class="hover:text-accent-gold transition-colors duration-300 mt-1 focus:outline-none">
                        <span class="material-symbols-outlined text-[22px]">logout</span>
                    </button>
                </form>
            @endauth
        </div>

        {{-- Mobile Menu Button --}}
        <button class="md:hidden text-neutral-900" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
            <span class="material-symbols-outlined text-2xl">menu</span>
        </button>
    </nav>

    {{-- Mobile Menu --}}
    <div id="mobile-menu" class="hidden md:hidden bg-white/95 backdrop-blur-xl border-t border-neutral-100 px-8 py-6 space-y-5">
        <a class="block font-label text-[11px] uppercase tracking-[0.15em] text-neutral-700 hover:text-accent-gold transition-colors" href="{{ route('home') }}">Trang Chủ</a>
        <a class="block font-label text-[11px] uppercase tracking-[0.15em] text-neutral-700 hover:text-accent-gold transition-colors" href="{{ route('products.index') }}">Sản Phẩm</a>
        <a class="block font-label text-[11px] uppercase tracking-[0.15em] text-neutral-700 hover:text-accent-gold transition-colors" href="{{ route('categories.index') }}">Danh Mục</a>
        <a class="block font-label text-[11px] uppercase tracking-[0.15em] text-neutral-700 hover:text-accent-gold transition-colors" href="{{ route('cart.index') }}">Giỏ Hàng</a>
        @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block font-label text-[11px] uppercase tracking-[0.15em] text-neutral-700 hover:text-accent-gold transition-colors">Đăng Xuất</button>
            </form>
        @else
            <a class="block font-label text-[11px] uppercase tracking-[0.15em] text-neutral-700 hover:text-accent-gold transition-colors" href="{{ route('login') }}">Đăng Nhập</a>
        @endauth
    </div>
</header>
