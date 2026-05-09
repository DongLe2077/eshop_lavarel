<!DOCTYPE html>
<html class="light" lang="vi">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'FashionGZ - Thời trang cao cấp')</title>
    <meta name="description" content="@yield('meta_description', 'FashionGZ - Thời trang cao cấp, phong cách cá tính và hiện đại.')">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts: Playfair Display (Serif) & Inter (Sans) -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet"/>
    <!-- Swiper.js Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />

    <style>
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined';
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            vertical-align: middle;
            line-height: 1;
        }
        .material-symbols-outlined.fill {
            font-variation-settings: 'FILL' 1;
        }

        /* Hiệu ứng lướt xuống (Scroll Reveal) */
        .scroll-reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s cubic-bezier(0.5, 0, 0, 1);
        }
        .scroll-reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        /* Thay đổi thời gian delay nếu cần */
        .delay-100 { transition-delay: 100ms; }
        .delay-200 { transition-delay: 200ms; }
        .delay-300 { transition-delay: 300ms; }
        .delay-400 { transition-delay: 400ms; }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface text-on-surface font-body antialiased min-h-screen selection:bg-primary-container selection:text-on-primary-container overflow-x-hidden">
    
    <div id="page-wrapper">
        {{-- Navbar --}}
        @if(!request()->is('login') && !request()->is('register'))
            <x-navbar />
        @endif

        {{-- Main Content --}}
        <main class="flex-grow {{ (!request()->is('login') && !request()->is('register')) ? 'pt-[88px]' : '' }}">
            @yield('content')
        </main>

        {{-- Footer --}}
        @if(!request()->is('login') && !request()->is('register'))
            <x-footer />
        @endif
    </div>

    {{-- Global Toast --}}
    <div id="global-toast" class="toast-notification">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-accent-gold">check_circle</span>
            <span id="toast-message">Đã thêm vào giỏ hàng</span>
        </div>
    </div>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Page Entrance
            const wrapper = document.getElementById('page-wrapper');
            setTimeout(() => {
                wrapper.classList.add('loaded');
            }, 100);

            const header = document.getElementById('main-header');
            let lastScrollY = window.scrollY;
            
            window.addEventListener('scroll', () => {
                const currentScrollY = window.scrollY;
                
                // Background & Blur Logic
                if (currentScrollY > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }

                // Show/Hide on Scroll Direction
                if (currentScrollY > lastScrollY && currentScrollY > 200) {
                    // Scrolling Down - Hide Header
                    header.classList.add('header-hidden');
                } else {
                    // Scrolling Up or at the top - Show Header
                    header.classList.remove('header-hidden');
                }
                
                lastScrollY = currentScrollY;
            });

            // Intersection Observer for scroll reveal
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.scroll-reveal').forEach(el => observer.observe(el));

            // Magnetic Buttons Effect
            const magneticButtons = document.querySelectorAll('.btn-luxury, .magnetic-link');
            magneticButtons.forEach(btn => {
                btn.addEventListener('mousemove', (e) => {
                    const rect = btn.getBoundingClientRect();
                    const x = e.clientX - rect.left - rect.width / 2;
                    const y = e.clientY - rect.top - rect.height / 2;
                    
                    btn.style.transform = `translate(${x * 0.3}px, ${y * 0.5}px) scale(1.02)`;
                });
                
                btn.addEventListener('mouseleave', () => {
                    btn.style.transform = '';
                });
            });
        });

        // Global Toast Utility
        function showToast(message, type = 'success') {
            const toast = document.getElementById('global-toast');
            const msgEl = document.getElementById('toast-message');
            msgEl.innerText = message;
            
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        // Global AJAX Add to Cart
        async function addToCart(productId, quantity = 1) {
            try {
                const response = await fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    showToast(data.message);
                    
                    // Update cart count badge if it exists
                    const cartCountEl = document.querySelector('.cart-count-badge');
                    if (cartCountEl) {
                        cartCountEl.innerText = data.cart_count;
                        cartCountEl.classList.remove('hidden');
                        cartCountEl.classList.add('cart-bounce');
                        setTimeout(() => cartCountEl.classList.remove('cart-bounce'), 500);
                    }
                }
            } catch (error) {
                console.error('Error adding to cart:', error);
                showToast('Có lỗi xảy ra, vui lòng thử lại', 'error');
            }
        }

        // Mua ngay (Thêm vào giỏ và chuyển hướng thanh toán)
        async function buyNow(productId, quantity = 1) {
            try {
                const response = await fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    window.location.href = '{{ route('checkout') }}';
                }
            } catch (error) {
                console.error('Error buying now:', error);
                showToast('Có lỗi xảy ra, vui lòng thử lại', 'error');
            }
        }
    </script>
    @stack('scripts')
</body>
</html>

