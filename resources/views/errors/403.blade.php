@extends('layouts.admin')

@section('title', 'Không có quyền truy cập')

@section('content')
<div class="flex items-center justify-center min-h-[60vh]">
    <div class="text-center">
        <div class="w-24 h-24 mx-auto mb-6 bg-red-100 rounded-full flex items-center justify-center">
            <i class="fas fa-lock text-red-500 text-4xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-slate-800 mb-2">403 - Không có quyền truy cập</h2>
        <p class="text-slate-500 mb-6 max-w-md">
            {{ $exception->getMessage() ?: 'Bạn không có quyền thực hiện hành động này. Vui lòng liên hệ quản trị viên để được cấp quyền.' }}
        </p>
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/25">
            <i class="fas fa-arrow-left mr-2"></i>
            Về trang Tổng quan
        </a>
    </div>
</div>
@endsection
