{{-- Trang Đăng Ký - Trích xuất từ Stitch UI "register.html" --}}
@extends('layouts.app')

@section('title', 'Đăng Ký - Zest Outfit')

@section('content')
    <main class="min-h-[calc(100vh)] -mt-[88px] flex flex-col md:flex-row">
        <!-- Left Image Canvas -->
        <div class="hidden md:flex w-full md:w-5/12 lg:w-1/2 relative bg-surface-variant overflow-hidden">
            <img alt="Bộ sưu tập thời trang" class="absolute inset-0 w-full h-full object-cover opacity-90 grayscale-[20%] sepia-[10%] mix-blend-multiply" src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=2070&auto=format&fit=crop"/>
            <div class="absolute inset-0 bg-gradient-to-t from-surface-variant/80 via-transparent to-transparent"></div>
            <div class="absolute inset-0 bg-surface mix-blend-overlay opacity-30"></div>
        </div>

        <!-- Right Form Canvas -->
        <div class="w-full md:w-7/12 lg:w-1/2 flex flex-col min-h-[calc(100vh)] relative bg-surface">
            <!-- Transactional "Back" / Simple Nav -->
            <nav class="absolute top-0 left-0 w-full p-8 flex justify-between items-center z-10 pt-28">
                <a class="font-headline font-bold text-xl tracking-tighter text-on-surface hover:opacity-70 transition-opacity" href="{{ route('home') }}">
                    ZEST OUTFIT
                </a>
                <a class="flex items-center gap-2 text-sm font-label font-medium text-on-surface-variant hover:text-primary transition-colors group" href="{{ route('home') }}">
                    <span class="material-symbols-outlined text-[20px] group-hover:-translate-x-1 transition-transform">arrow_left_alt</span>
                    Trở về Trang chủ
                </a>
            </nav>

            <!-- Form Container -->
            <div class="flex-grow flex flex-col justify-center px-8 sm:px-16 lg:px-24 xl:px-32 py-32 mt-10">
                <div class="max-w-md w-full mx-auto md:mx-0">
                    <header class="mb-12">
                        <h1 class="font-headline text-[2.5rem] md:text-[3rem] leading-none font-bold tracking-tight text-on-surface mb-4">
                            Tham gia <br/> Zest Outfit.
                        </h1>
                        <p class="font-body text-base text-on-surface-variant leading-relaxed pr-8">
                            Tạo tài khoản để quản lý đơn hàng và truy cập các bộ sưu tập giới hạn độc quyền.
                        </p>
                    </header>

                    <form action="{{ route('register') }}" class="space-y-8" method="POST">
                        @csrf
                        <!-- Input Field: Email -->
                        <div class="relative group">
                            <input class="peer w-full bg-transparent border-0 border-b border-outline-variant text-on-surface font-body text-base px-0 py-3 focus:ring-0 focus:border-primary transition-colors placeholder-transparent" 
                                   id="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required="" type="email" autofocus/>
                            <label class="absolute left-0 top-3 text-on-surface-variant font-label text-sm uppercase tracking-widest transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:top-3 peer-placeholder-shown:normal-case peer-placeholder-shown:tracking-normal peer-focus:-top-5 peer-focus:text-[0.65rem] peer-focus:text-primary peer-focus:uppercase peer-focus:tracking-widest" for="email">
                                Địa chỉ Email
                            </label>
                            @error('email')
                                <p class="text-error text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Input Field: Password -->
                        <div class="relative group">
                            <input class="peer w-full bg-transparent border-0 border-b border-outline-variant text-on-surface font-body text-base px-0 py-3 focus:ring-0 focus:border-primary transition-colors placeholder-transparent" 
                                   id="password" name="password" placeholder="Password" required="" type="password"/>
                            <label class="absolute left-0 top-3 text-on-surface-variant font-label text-sm uppercase tracking-widest transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:top-3 peer-placeholder-shown:normal-case peer-placeholder-shown:tracking-normal peer-focus:-top-5 peer-focus:text-[0.65rem] peer-focus:text-primary peer-focus:uppercase peer-focus:tracking-widest" for="password">
                                Mật khẩu
                            </label>
                            @error('password')
                                <p class="text-error text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Input Field: Password Confirmation -->
                        <div class="relative group">
                            <input class="peer w-full bg-transparent border-0 border-b border-outline-variant text-on-surface font-body text-base px-0 py-3 focus:ring-0 focus:border-primary transition-colors placeholder-transparent" 
                                   id="password_confirmation" name="password_confirmation" placeholder="Xác nhận mật khẩu" required="" type="password"/>
                            <label class="absolute left-0 top-3 text-on-surface-variant font-label text-sm uppercase tracking-widest transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:top-3 peer-placeholder-shown:normal-case peer-placeholder-shown:tracking-normal peer-focus:-top-5 peer-focus:text-[0.65rem] peer-focus:text-primary peer-focus:uppercase peer-focus:tracking-widest" for="password_confirmation">
                                Xác nhận mật khẩu
                            </label>
                        </div>

                        <!-- Actions -->
                        <div class="pt-6 flex flex-col gap-6">
                            <button class="w-full bg-gradient-to-br from-primary to-primary-container text-on-primary font-label text-sm uppercase tracking-widest py-4 rounded-DEFAULT hover:opacity-90 transition-all duration-300 shadow-[0_24px_48px_rgba(27,28,28,0.06)] flex justify-center items-center gap-3 group" type="submit">
                                TẠO TÀI KHOẢN
                                <span class="material-symbols-outlined text-[18px] group-hover:translate-x-1 transition-transform">east</span>
                            </button>
                            <div class="text-center">
                                <span class="font-body text-sm text-on-surface-variant">Đã có tài khoản?</span>
                                <a class="font-label text-sm font-semibold text-on-surface underline underline-offset-4 decoration-outline-variant hover:decoration-primary transition-colors ml-2" href="{{ route('login') }}">
                                    Đăng Nhập
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Transactional Footer -->
            <div class="p-8 text-center md:text-left mt-auto">
                <p class="font-body text-xs text-outline-variant">
                    Bằng việc tạo tài khoản, bạn đồng ý với <a class="underline hover:text-on-surface transition-colors" href="#">Điều khoản dịch vụ</a> và <a class="underline hover:text-on-surface transition-colors" href="#">Chính sách bảo mật</a>.
                </p>
            </div>
        </div>
    </main>
@endsection
