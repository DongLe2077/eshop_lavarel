@extends('layouts.admin')

@section('title', 'Thêm Danh mục Mới')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Thêm Danh mục Mới</h1>
        <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Trở về
        </a>
    </div>

    <form action="{{ route('admin.categories.store') }}" method="POST" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
        @csrf

        <div class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Tên danh mục *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">Mô tả</label>
                <textarea name="description" id="description" rows="4"
                          class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end">
            <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-100">
                <i class="fas fa-save mr-2"></i> Lưu Danh mục
            </button>
        </div>
    </form>
</div>
@endsection
