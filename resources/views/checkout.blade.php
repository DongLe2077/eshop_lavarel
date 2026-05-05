@extends('layouts.app')

@section('title', 'Thanh Toán - Zest Outfit')

@section('content')
<main class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-12 grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-24">
    <!-- Cột trái: Form Thông tin -->
    <div class="lg:col-span-7 space-y-12">
        <nav aria-label="Progress" class="mb-12">
            <ol class="flex items-center space-x-2 text-sm font-label uppercase tracking-widest">
                <li><span class="text-primary font-semibold">Thông tin</span></li>
                <li><span class="material-symbols-outlined text-outline-variant text-sm px-2">chevron_right</span></li>
                <li><span class="text-on-surface-variant">Thanh toán</span></li>
                <li><span class="material-symbols-outlined text-outline-variant text-sm px-2">chevron_right</span></li>
                <li><span class="text-on-surface-variant">Hoàn tất</span></li>
            </ol>
        </nav>

        <section class="space-y-8 bg-surface-container-lowest p-8 rounded-lg shadow-sm">
            <h2 class="font-headline text-2xl text-on-surface tracking-tight">Thông tin liên hệ</h2>
            <form id="checkout-form" action="{{ route('orders.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block font-label text-xs uppercase tracking-widest text-on-surface-variant mb-2 font-semibold">Địa chỉ Email</label>
                    <input type="email" name="email" id="email" required value="{{ auth()->user()->email ?? '' }}"
                           placeholder="ví dụ: email@gmail.com"
                           class="block w-full px-4 py-3 bg-surface-container-lowest border border-outline-variant/50 rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all text-on-surface"/>
                </div>

                <h2 class="font-headline text-2xl text-on-surface tracking-tight pt-4">Địa chỉ giao hàng</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="first_name" class="block font-label text-xs uppercase tracking-widest text-on-surface-variant mb-2 font-semibold">Họ</label>
                        <input type="text" name="first_name" id="first_name" required placeholder="Họ của bạn"
                               class="block w-full px-4 py-3 bg-surface-container-lowest border border-outline-variant/50 rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all text-on-surface"/>
                    </div>
                    <div>
                        <label for="last_name" class="block font-label text-xs uppercase tracking-widest text-on-surface-variant mb-2 font-semibold">Tên</label>
                        <input type="text" name="last_name" id="last_name" required placeholder="Tên của bạn"
                               class="block w-full px-4 py-3 bg-surface-container-lowest border border-outline-variant/50 rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all text-on-surface"/>
                    </div>
                </div>

                <div>
                    <label for="phone" class="block font-label text-xs uppercase tracking-widest text-on-surface-variant mb-2 font-semibold">Số điện thoại</label>
                    <input type="text" name="phone" id="phone" required placeholder="Số điện thoại liên hệ"
                           class="block w-full px-4 py-3 bg-surface-container-lowest border border-outline-variant/50 rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all text-on-surface"/>
                </div>

                <div>
                    <label for="address" class="block font-label text-xs uppercase tracking-widest text-on-surface-variant mb-2 font-semibold">Địa chỉ chi tiết</label>
                    <input type="text" name="address" id="address" required placeholder="Số nhà, tên đường, phường/xã..."
                           class="block w-full px-4 py-3 bg-surface-container-lowest border border-outline-variant/50 rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all text-on-surface"/>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="city" class="block font-label text-xs uppercase tracking-widest text-on-surface-variant mb-2 font-semibold">Thành phố</label>
                        <input type="text" name="city" id="city" required placeholder="Tỉnh / Thành phố"
                               class="block w-full px-4 py-3 bg-surface-container-lowest border border-outline-variant/50 rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all text-on-surface"/>
                    </div>
                    <div>
                        <label for="zip" class="block font-label text-xs uppercase tracking-widest text-on-surface-variant mb-2 font-semibold">Mã bưu điện (Zip)</label>
                        <input type="text" name="zip" id="zip" placeholder="Mã bưu chính (không bắt buộc)"
                               class="block w-full px-4 py-3 bg-surface-container-lowest border border-outline-variant/50 rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all text-on-surface"/>
                    </div>
                </div>

                <div class="pt-8">
                    <button type="submit" class="w-full md:w-auto px-12 py-4 bg-gradient-to-br from-primary to-primary-container text-on-primary font-label uppercase tracking-widest text-sm rounded shadow-lg hover:opacity-90 transition-opacity">
                        Hoàn tất đặt hàng
                    </button>
                </div>
            </form>
        </section>
    </div>

    <!-- Cột phải: Tóm tắt đơn hàng -->
    <div class="lg:col-span-5">
        <div class="sticky top-28 bg-surface-container-low p-8 rounded-lg border border-outline-variant/10">
            <h2 class="font-headline text-xl text-on-surface tracking-tight mb-8">Tóm tắt đơn hàng</h2>
            
            <div class="space-y-6 mb-8 max-h-[400px] overflow-y-auto pr-2">
                @foreach($cart as $id => $item)
                <div class="flex items-center gap-4">
                    <div class="relative w-16 h-20 bg-surface-variant rounded overflow-hidden flex-shrink-0">
                        <img src="{{ $item['image'] }}" class="w-full h-full object-cover">
                        <span class="absolute -top-1 -right-1 bg-primary text-on-primary w-5 h-5 flex items-center justify-center rounded-full text-[10px] font-bold">{{ $item['quantity'] }}</span>
                    </div>
                    <div class="flex-grow">
                        <h3 class="font-headline text-sm text-on-surface">{{ $item['name'] }}</h3>
                        <p class="text-xs text-on-surface-variant mt-1">{{ number_format($item['price'], 0, ',', '.') }}đ</p>
                    </div>
                    <div class="text-right">
                        <p class="font-body text-sm font-medium text-on-surface">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ</p>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="space-y-4 pt-6 border-t border-outline-variant/20">
                <div class="flex justify-between items-center text-on-surface-variant text-sm">
                    <p>Tạm tính</p>
                    <p>{{ number_format($total, 0, ',', '.') }}đ</p>
                </div>
                <div class="flex justify-between items-center text-on-surface-variant text-sm">
                    <p>Phí vận chuyển</p>
                    <p class="uppercase tracking-widest text-[10px]">Miễn phí</p>
                </div>
                <div class="flex justify-between items-center pt-6 text-on-surface font-headline text-xl font-bold">
                    <p>Tổng cộng</p>
                    <p>{{ number_format($total, 0, ',', '.') }}đ</p>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form[action="{{ route('orders.store') }}"]');
        const submitBtn = form.querySelector('button[type="submit"]');

        form.addEventListener('submit', function() {
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <span class="flex items-center justify-center gap-3">
                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Đang xử lý đơn hàng...
                </span>
            `;
            submitBtn.classList.add('opacity-80', 'cursor-not-allowed');
        });
    });
</script>
@endpush
