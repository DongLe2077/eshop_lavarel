@extends('layouts.admin')

@section('title', 'Sửa Sản Phẩm: ' . $product->name)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Chỉnh Sửa Sản Phẩm</h1>
        <a href="{{ route('admin.products.index') }}" class="px-4 py-2 text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Trở về
        </a>
    </div>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Cột trái --}}
            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Tên sản phẩm *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                           class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-semibold text-slate-700 mb-2">Danh mục *</label>
                    <select name="category_id" id="category_id" required
                            class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none appearance-none bg-white">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="price" class="block text-sm font-semibold text-slate-700 mb-2">Giá (VNĐ) *</label>
                    <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" required min="0"
                           class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none">
                    @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="quanlity" class="block text-sm font-semibold text-slate-700 mb-2">Số lượng tồn kho</label>
                    <input type="number" name="quanlity" id="quanlity" value="{{ old('quanlity', $product->quanlity) }}" min="0"
                           class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none">
                    @error('quanlity') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Cột phải --}}
            <div class="space-y-6">
                <div>
                    <label for="image" class="block text-sm font-semibold text-slate-700 mb-2">Đường dẫn ảnh (URL)</label>
                    <div class="flex gap-4">
                        @if($product->image)
                            <div class="w-16 h-16 bg-slate-100 rounded-lg overflow-hidden border border-slate-200 flex-shrink-0">
                                <img src="{{ $product->image }}" alt="Preview" class="w-full h-full object-cover">
                            </div>
                        @endif
                        <div class="flex-grow">
                            <input type="text" name="image" id="image" value="{{ old('image', $product->image) }}"
                                   class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none">
                        </div>
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">Mô tả sản phẩm</label>
                    <textarea name="description" id="description" rows="7"
                              class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none">{{ old('description', $product->description) }}</textarea>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end">
            <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-100">
                <i class="fas fa-save mr-2"></i> Cập Nhật
            </button>
        </div>
    </form>
</div>
@endsection

