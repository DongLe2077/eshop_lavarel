<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FashionGZ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .glass-panel {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .sidebar-item:hover {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }
        .active-sidebar-item {
            background: #3b82f6;
            color: white;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-slate-200 flex flex-col z-20">
            <div class="p-6 flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white">
                    <i class="fas fa-shopping-bag fa-lg"></i>
                </div>
                <span class="text-xl font-bold tracking-tight">FashionGZ Admin</span>
            </div>

            <nav class="flex-1 px-4 space-y-1 overflow-y-auto mt-4">
                {{-- Dashboard - luôn hiển thị cho ai có quyền vào admin --}}
                <a href="{{ route('admin.dashboard') }}" class="sidebar-item flex items-center px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'active-sidebar-item' : '' }}">
                    <i class="fas fa-chart-line w-6"></i>
                    <span class="font-medium">Tổng quan</span>
                </a>

                {{-- Danh mục - cần permission view categories --}}
                @if(auth()->user()->role === 'admin' || auth()->user()->can('view categories'))
                <a href="{{ route('admin.categories.index') }}" class="sidebar-item flex items-center px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.categories.*') ? 'active-sidebar-item' : '' }}">
                    <i class="fas fa-tags w-6"></i>
                    <span class="font-medium">Danh mục</span>
                </a>
                @endif

                {{-- Sản phẩm - cần permission view products --}}
                @if(auth()->user()->role === 'admin' || auth()->user()->can('view products'))
                <a href="{{ route('admin.products.index') }}" class="sidebar-item flex items-center px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.products.*') ? 'active-sidebar-item' : '' }}">
                    <i class="fas fa-box w-6"></i>
                    <span class="font-medium">Sản phẩm</span>
                </a>
                @endif

                {{-- Đơn hàng - cần permission view orders --}}
                @if(auth()->user()->role === 'admin' || auth()->user()->can('view orders'))
                <a href="{{ route('admin.orders.index') }}" class="sidebar-item flex items-center px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.orders.*') ? 'active-sidebar-item' : '' }}">
                    <i class="fas fa-shopping-cart w-6"></i>
                    <span class="font-medium">Đơn hàng</span>
                </a>
                @endif

                {{-- Người dùng - cần permission manage users --}}
                @if(auth()->user()->role === 'admin' || auth()->user()->can('manage users'))
                <a href="{{ route('admin.users.index') }}" class="sidebar-item flex items-center px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.users.*') ? 'active-sidebar-item' : '' }}">
                    <i class="fas fa-users w-6"></i>
                    <span class="font-medium">Người dùng</span>
                </a>
                @endif

                {{-- Phân tích - cần permission view analytics --}}
                @if(auth()->user()->role === 'admin' || auth()->user()->can('view analytics'))
                <a href="{{ route('admin.analytics') }}" class="sidebar-item flex items-center px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.analytics') ? 'active-sidebar-item' : '' }}">
                    <i class="fas fa-chart-pie w-6"></i>
                    <span class="font-medium">Phân tích dữ liệu</span>
                </a>
                @endif
            </nav>

            <div class="p-4 border-t border-slate-100">
                <div class="px-4 py-2 mb-2">
                    <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</p>
                    @if(auth()->user()->role === 'admin')
                        <span class="text-xs text-purple-500 font-semibold"><i class="fas fa-crown mr-1"></i>Admin</span>
                    @else
                        @php
                            try { $permCount = auth()->user()->getDirectPermissions()->count(); } catch (\Exception $e) { $permCount = 0; }
                        @endphp
                        <span class="text-xs text-blue-500 font-semibold"><i class="fas fa-shield-alt mr-1"></i>{{ $permCount }} quyền</span>
                    @endif
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-3 rounded-xl text-red-500 hover:bg-red-50 transition-all font-medium">
                        <i class="fas fa-sign-out-alt w-6"></i>
                        <span>Đăng xuất</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Header -->
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-8 z-10">
                <div class="flex items-center space-x-4">
                    <button class="lg:hidden text-slate-500"><i class="fas fa-bars"></i></button>
                    <h2 class="text-lg font-semibold text-slate-800">@yield('title', 'Dashboard')</h2>
                    @yield('header_actions')
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                        <i class="far fa-bell text-slate-400 text-xl cursor-pointer"></i>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-slate-200 overflow-hidden border border-slate-300">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=random" alt="Avatar">
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto p-8">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center">
                        <i class="fas fa-check-circle mr-3"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl flex items-center">
                        <i class="fas fa-exclamation-circle mr-3"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
    @yield('scripts')
</body>
</html>
