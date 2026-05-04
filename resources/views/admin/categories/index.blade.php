@extends('layouts.admin')

@section('title', 'Quản lý Danh mục')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div class="flex space-x-3"></div>
    <a href="{{ route('admin.categories.create') }}" class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-100 flex items-center">
        <i class="fas fa-plus mr-2"></i> Thêm danh mục
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-slate-50/50 border-b border-slate-100">
                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider w-16">ID</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Tên Danh Mục</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Mô tả</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-right">Thao tác</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @foreach($categories as $category)
            <tr class="hover:bg-slate-50/50 transition-colors group">
                <td class="px-6 py-4 text-slate-500">#{{ $category->id }}</td>
                <td class="px-6 py-4 font-semibold text-slate-800">{{ $category->name }}</td>
                <td class="px-6 py-4 text-slate-500">{{ $category->description ?? 'Không có mô tả' }}</td>
                <td class="px-6 py-4 text-right">
                    <div class="flex justify-end space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
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
</div>
@endsection
