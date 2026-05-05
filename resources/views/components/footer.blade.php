{{-- Footer Component - Luxury Redesign --}}

{{-- Newsletter Section --}}
<section class="bg-luxury-dark py-20 px-8">
    <div class="max-w-3xl mx-auto text-center">
        <div class="flex items-center justify-center gap-3 mb-6">
            <div class="w-8 h-px bg-accent-gold/60"></div>
            <span class="font-label text-[10px] tracking-[0.4em] text-accent-gold uppercase font-bold">Stay Connected</span>
            <div class="w-8 h-px bg-accent-gold/60"></div>
        </div>
        <h3 class="font-headline text-3xl text-white font-bold mb-4 tracking-tight">Nhận Tin Bộ Sưu Tập Mới</h3>
        <p class="font-body text-white/40 text-sm mb-10">Đăng ký để nhận thông tin về bộ sưu tập mới nhất và ưu đãi đặc biệt.</p>
        <form class="flex items-center max-w-lg mx-auto" onsubmit="event.preventDefault(); this.querySelector('button').textContent='Đã đăng ký ✓';">
            <input type="email" placeholder="Nhập email của bạn" 
                   class="flex-1 bg-transparent border-b border-white/20 text-white px-0 py-3 text-sm focus:outline-none focus:border-accent-gold transition-colors placeholder-white/30 font-body"/>
            <button type="submit" class="ml-4 font-label text-[10px] uppercase tracking-[0.3em] text-accent-gold hover:text-white transition-colors font-bold whitespace-nowrap">
                Đăng Ký
            </button>
        </form>
    </div>
</section>

{{-- Trust Badges --}}
<div class="bg-luxury-dark border-t border-white/5 py-12 px-8">
    <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">
        <div class="flex flex-col items-center gap-3">
            <span class="material-symbols-outlined text-accent-gold text-3xl">local_shipping</span>
            <span class="font-label text-[10px] tracking-[0.3em] text-white/80 uppercase font-bold">Giao Hàng Miễn Phí</span>
            <span class="font-body text-white/30 text-xs">Đơn hàng từ 500.000đ</span>
        </div>
        <div class="flex flex-col items-center gap-3">
            <span class="material-symbols-outlined text-accent-gold text-3xl">verified</span>
            <span class="font-label text-[10px] tracking-[0.3em] text-white/80 uppercase font-bold">Chất Lượng Cao Cấp</span>
            <span class="font-body text-white/30 text-xs">100% chính hãng</span>
        </div>
        <div class="flex flex-col items-center gap-3">
            <span class="material-symbols-outlined text-accent-gold text-3xl">sync</span>
            <span class="font-label text-[10px] tracking-[0.3em] text-white/80 uppercase font-bold">Đổi Trả 30 Ngày</span>
            <span class="font-body text-white/30 text-xs">Không rắc rối</span>
        </div>
    </div>
</div>

{{-- Main Footer --}}
<footer aria-label="Site Footer" class="w-full py-16 px-8 bg-luxury-dark border-t border-white/5">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 max-w-7xl mx-auto">
        {{-- Brand --}}
        <div class="flex flex-col space-y-6 lg:col-span-1">
            <div class="flex items-center gap-2">
                <span class="font-headline font-bold text-xl text-white tracking-[-0.05em]">Fashion</span>
                <span class="font-headline font-light text-xl text-white tracking-[-0.05em]">GZ</span>
            </div>
            <p class="font-body text-sm text-white/30 leading-relaxed">
                Thời trang cao cấp cho những ai trân trọng sự tinh tế trong từng đường nét.
            </p>
        </div>

        {{-- Khám phá --}}
        <div class="flex flex-col space-y-4">
            <span class="font-label text-[10px] tracking-[0.3em] text-accent-gold uppercase font-bold mb-3">Khám phá</span>
            <a class="font-body text-sm text-white/40 hover:text-accent-gold transition-colors duration-300" href="{{ route('products.index') }}">Tất Cả Sản Phẩm</a>
            <a class="font-body text-sm text-white/40 hover:text-accent-gold transition-colors duration-300" href="{{ route('categories.index') }}">Danh Mục</a>
        </div>

        {{-- Hỗ trợ --}}
        <div class="flex flex-col space-y-4">
            <span class="font-label text-[10px] tracking-[0.3em] text-accent-gold uppercase font-bold mb-3">Hỗ trợ</span>
            <a class="font-body text-sm text-white/40 hover:text-accent-gold transition-colors duration-300" href="#">Vận Chuyển & Đổi Trả</a>
            <a class="font-body text-sm text-white/40 hover:text-accent-gold transition-colors duration-300" href="#">Chính Sách Bảo Mật</a>
        </div>

        {{-- Tài khoản --}}
        <div class="flex flex-col space-y-4">
            <span class="font-label text-[10px] tracking-[0.3em] text-accent-gold uppercase font-bold mb-3">Tài khoản</span>
            @auth
                <a class="font-body text-sm text-white/40 hover:text-accent-gold transition-colors duration-300" href="{{ route('orders.index') }}">Đơn Hàng Của Tôi</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="font-body text-sm text-white/40 hover:text-accent-gold transition-colors duration-300">Đăng Xuất</button>
                </form>
            @else
                <a class="font-body text-sm text-white/40 hover:text-accent-gold transition-colors duration-300" href="{{ route('login') }}">Đăng Nhập</a>
                <a class="font-body text-sm text-white/40 hover:text-accent-gold transition-colors duration-300" href="{{ route('register') }}">Đăng Ký</a>
            @endauth
        </div>
    </div>

    <div class="max-w-7xl mx-auto mt-16 pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-4">
        <span class="font-label text-[10px] text-white/20 uppercase tracking-[0.3em]">© {{ date('Y') }} FashionGZ. All rights reserved.</span>
        <div class="flex items-center gap-1">
            <span class="font-label text-[10px] text-white/20 uppercase tracking-[0.2em]">Crafted with</span>
            <span class="text-accent-gold text-sm">✦</span>
            <span class="font-label text-[10px] text-white/20 uppercase tracking-[0.2em]">for the modern canvas</span>
        </div>
    </div>
</footer>
