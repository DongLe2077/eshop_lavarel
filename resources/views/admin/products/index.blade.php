@extends('layouts.admin')

@section('title', 'Quản lý Sản phẩm')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div class="flex space-x-3">
        <button id="bulk-delete-btn" class="hidden px-4 py-2 bg-red-500 text-white rounded-xl hover:bg-red-600 transition-all shadow-lg shadow-red-100 items-center">
            <i class="fas fa-trash mr-2"></i> Xóa đã chọn (<span id="selected-count">0</span>)
        </button>
    </div>
    <a href="{{ route('admin.products.create') }}" class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-100 flex items-center">
        <i class="fas fa-plus mr-2"></i> Thêm sản phẩm
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-slate-50/50 border-b border-slate-100">
                <th class="px-6 py-4 w-12">
                    <input type="checkbox" id="select-all" class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500">
                </th>
                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Sản phẩm</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Danh mục</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Giá</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Tồn kho</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-right">Thao tác</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @foreach($products as $product)
            <tr class="hover:bg-slate-50/50 transition-colors group">
                <td class="px-6 py-4">
                    <input type="checkbox" name="ids[]" value="{{ $product->id }}" class="product-checkbox w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500">
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-lg bg-slate-100 mr-3 flex-shrink-0 overflow-hidden border border-slate-200">
                            <img src="{{ $product->image }}" alt="" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <div class="font-semibold text-slate-800">{{ $product->name }}</div>
                            <div class="text-xs text-slate-400">ID: #{{ $product->id }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-medium">
                        {{ $product->category->name ?? 'Không rõ' }}
                    </span>
                </td>
                <td class="px-6 py-4 font-medium text-slate-700">
                    {{ number_format($product->price, 0, ',', '.') }}đ
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center text-slate-600">
                        <i class="fas fa-cubes mr-2 text-slate-300"></i>
                        {{ $product->quanlity }}
                    </div>
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex justify-end space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <a href="{{ route('admin.products.edit', $product) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
        {{ $products->links() }}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('.product-checkbox');
        const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
        const selectedCount = document.getElementById('selected-count');

        function updateUI() {
            const checked = document.querySelectorAll('.product-checkbox:checked');
            if (checked.length > 0) {
                bulkDeleteBtn.classList.remove('hidden');
                bulkDeleteBtn.classList.add('flex');
                selectedCount.textContent = checked.length;
            } else {
                bulkDeleteBtn.classList.add('hidden');
                bulkDeleteBtn.classList.remove('flex');
            }
        }

        selectAll.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
            updateUI();
        });

        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateUI);
        });

        bulkDeleteBtn.addEventListener('click', function() {
            if (!confirm('Bạn có chắc chắn muốn xóa các sản phẩm đã chọn?')) return;

            const ids = Array.from(document.querySelectorAll('.product-checkbox:checked')).map(cb => cb.value);
            
            fetch("{{ route('admin.products.bulkDelete') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ ids: ids })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.error);
                }
            });
        });
    });
</script>
@endsection
