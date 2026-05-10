@extends('layouts.admin')

@section('title', 'Quản lý Người dùng')
@section('header_actions')
    <a href="{{ route('admin.users.create') }}" class="ml-4 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors flex items-center">
        <i class="fas fa-plus mr-2"></i>
        Thêm người dùng
    </a>
@endsection

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mt-8">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-slate-50/50 border-b border-slate-100">
                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider w-16">ID</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Tên hiển thị</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Email / Username</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Vai trò</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-right">Thao tác</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($users as $user)
            <tr class="hover:bg-slate-50/50 transition-colors group">
                <td class="px-6 py-4 text-slate-500 font-medium">
                    #{{ $users->total() - ($users->currentPage() - 1) * $users->perPage() - $loop->index }}
                </td>
                <td class="px-6 py-4 font-semibold text-slate-800">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-slate-200 mr-3 flex items-center justify-center text-slate-500 font-bold text-xs">
                            {{ strtoupper(substr($user->name ?? $user->email, 0, 1)) }}
                        </div>
                        {{ $user->name ?? 'Người dùng' }}
                    </div>
                </td>
                <td class="px-6 py-4 text-slate-600">
                    {{ $user->email }}
                </td>
                <td class="px-6 py-4">
                    @if($user->role == 'admin')
                        <span class="px-3 py-1 bg-purple-50 text-purple-600 rounded-full text-xs font-medium">Admin</span>
                    @else
                        <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-xs font-medium">Customer</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex justify-end space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" {{ $user->id == auth()->id() ? 'disabled' : '' }}>
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-slate-500">Chưa có người dùng nào.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
        {{ $users->links() }}
    </div>
</div>
@endsection

