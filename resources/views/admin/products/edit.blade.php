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

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
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
                {{-- Ảnh hiện tại --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Ảnh hiện tại</label>
                    <div class="w-32 h-32 bg-slate-100 rounded-xl overflow-hidden border border-slate-200">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    </div>
                </div>

                {{-- Upload ảnh mới --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Thay ảnh mới</label>
                    <div id="dropzone" class="relative border-2 border-dashed border-slate-300 rounded-xl p-6 text-center hover:border-blue-400 transition-colors cursor-pointer bg-slate-50">
                        <input type="file" name="image_file" id="image_file" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div id="upload-placeholder">
                            <i class="fas fa-cloud-upload-alt text-3xl text-slate-400 mb-2"></i>
                            <p class="text-sm text-slate-500">Kéo thả ảnh vào đây hoặc <span class="text-blue-500 font-semibold">chọn file</span></p>
                            <p class="text-xs text-slate-400 mt-1">JPEG, PNG, WebP — Tối đa 5MB</p>
                        </div>
                        <img id="image-preview" class="hidden mx-auto max-h-48 rounded-lg object-contain" alt="Preview">
                    </div>
                    @error('image_file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Hoặc dán URL --}}
                <div>
                    <label for="image" class="block text-sm font-semibold text-slate-700 mb-2">Hoặc dán URL ảnh</label>
                    <input type="text" name="image" id="image" value="{{ old('image', $product->image) }}"
                           class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none">
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">Mô tả sản phẩm</label>
                    <textarea name="description" id="description" rows="5"
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

<script>
document.getElementById('image_file').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(ev) {
            document.getElementById('image-preview').src = ev.target.result;
            document.getElementById('image-preview').classList.remove('hidden');
            document.getElementById('upload-placeholder').classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
