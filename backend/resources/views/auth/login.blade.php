{{-- Trang Đăng Nhập - Trích xuất từ Stitch UI "login.html" --}}
@extends('layouts.app')

@section('title', 'Đăng Nhập - Zest Outfit')

@section('content')
    <main class="min-h-[calc(100vh)] -mt-[88px] flex flex-col lg:flex-row">
        <!-- Left Side Image -->
        <div class="hidden lg:block lg:w-1/2 relative overflow-hidden bg-surface-container-high">
            <img alt="Thời trang cao cấp" class="w-full h-full object-cover opacity-90 mix-blend-multiply" src="https://images.unsplash.com/photo-1445205170230-053b83016050?q=80&w=2071&auto=format&fit=crop"/>
            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
        </div>

        <!-- Right Side Form -->
        <div class="flex-grow lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-24 relative bg-surface">
            <div class="relative z-10 w-full max-w-md">
                <div class="mb-12">
                    <a class="inline-block" href="{{ route('home') }}">
                        <span class="text-3xl font-bold tracking-tighter text-on-surface font-headline uppercase">Zest Outfit</span>
                    </a>
                    <p class="mt-3 text-on-surface-variant font-body text-sm tracking-wide">Enter your personal canvas.</p>
                </div>
                
                <div class="mb-10">
                    <h1 class="text-4xl font-headline font-bold text-on-surface tracking-tight">Đăng Nhập</h1>
                </div>

                @if(session('error'))
                    <div class="bg-error-container text-on-error-container px-4 py-3 rounded font-body text-sm mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('login') }}" class="space-y-8" method="POST">
                    @csrf
                    <div class="space-y-2 relative group">
                        <label class="block text-xs font-label uppercase tracking-widest text-on-surface-variant mb-2 group-focus-within:text-primary transition-colors" for="email">Email / Username</label>
                        <div class="relative">
                            <input class="w-full bg-transparent border-0 border-b border-outline-variant/60 px-0 py-3 text-on-surface font-body text-base focus:ring-0 focus:border-primary transition-colors placeholder:text-outline-variant/40" 
                                   id="email" name="email" value="{{ old('email') }}" placeholder="Nhập email hoặc tên người dùng" required="" type="text" autofocus/>
                        </div>
                        @error('email')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2 relative group">
                        <div class="flex justify-between items-end mb-2">
                            <label class="block text-xs font-label uppercase tracking-widest text-on-surface-variant group-focus-within:text-primary transition-colors" for="password">Mật khẩu</label>
                            <a class="text-xs font-label text-primary hover:text-primary-container transition-all duration-300 uppercase tracking-widest relative after:content-[''] after:absolute after:w-full after:scale-x-0 after:h-[1px] after:bottom-0 after:left-0 after:bg-primary after:origin-bottom-right after:transition-transform hover:after:scale-x-100 hover:after:origin-bottom-left" href="#">Quên mật khẩu?</a>
                        </div>
                        <div class="relative">
                            <input class="w-full bg-transparent border-0 border-b border-outline-variant/60 px-0 py-3 text-on-surface font-body text-base focus:ring-0 focus:border-primary transition-colors placeholder:text-outline-variant/40" 
                                   id="password" name="password" placeholder="••••••••" required="" type="password"/>
                        </div>
                        @error('password')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-6">
                        <button class="w-full bg-primary text-on-primary py-4 px-8 font-label text-sm uppercase tracking-widest hover:bg-primary-container hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-3" type="submit">
                            ĐĂNG NHẬP
                            <span class="material-symbols-outlined text-[18px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </button>
                    </div>
                </form>

                <div class="mt-12">
                    <p class="text-sm font-body text-on-surface-variant">
                        Bạn chưa có tài khoản? 
                        <a class="text-primary hover:text-primary-container font-semibold transition-all duration-300 ml-1 relative after:content-[''] after:absolute after:w-full after:scale-x-100 after:h-[1px] after:bottom-0 after:left-0 after:bg-primary/30 after:transition-transform hover:after:bg-primary" href="{{ route('register') }}">Đăng ký ngay</a>
                    </p>
                </div>

                <div class="mt-16">
                    <p class="text-xs font-label text-on-surface-variant uppercase tracking-widest opacity-50">
                        © 2024 ZEST OUTFIT
                    </p>
                </div>
            </div>
        </div>
    </main>
@endsection
