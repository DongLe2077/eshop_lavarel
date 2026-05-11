@extends('layouts.admin')

@section('title', 'Thêm Người dùng')

@section('content')
<div class="max-w-3xl mt-8">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Họ và tên</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none" placeholder="Nhập họ tên...">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none" placeholder="Nhập email...">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Mật khẩu</label>
                    <input type="password" name="password" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none" placeholder="Nhập mật khẩu ít nhất 6 ký tự...">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Vai trò</label>
                    <select name="role" id="roleSelect" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none appearance-none bg-no-repeat bg-[right_1rem_center] bg-[length:1em_1em]" style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23666%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.4-12.8z%22/%3E%3C/svg%3E');">
                        <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Khách hàng (Customer)</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Quản trị viên (Admin)</option>
                    </select>
                    @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Phân quyền chi tiết --}}
                <div id="permissionsSection" class="border-t border-slate-100 pt-6">
                    <div class="flex items-center justify-between mb-4">
                        <label class="block text-sm font-bold text-slate-700">
                            <i class="fas fa-shield-alt text-blue-500 mr-2"></i>Phân quyền chi tiết
                        </label>
                        <span id="adminBadge" class="hidden px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-semibold">
                            <i class="fas fa-crown mr-1"></i>Admin có toàn quyền
                        </span>
                    </div>

                    <div id="permissionsGrid" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($allPermissions as $group => $permissions)
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                            <h4 class="text-sm font-bold text-slate-600 mb-3 flex items-center">
                                @switch($group)
                                    @case('Sản phẩm')
                                        <i class="fas fa-box text-blue-500 mr-2"></i>
                                        @break
                                    @case('Danh mục')
                                        <i class="fas fa-tags text-green-500 mr-2"></i>
                                        @break
                                    @case('Đơn hàng')
                                        <i class="fas fa-shopping-cart text-orange-500 mr-2"></i>
                                        @break
                                    @case('Phân tích')
                                        <i class="fas fa-chart-pie text-purple-500 mr-2"></i>
                                        @break
                                    @case('Người dùng')
                                        <i class="fas fa-users text-red-500 mr-2"></i>
                                        @break
                                    @default
                                        <i class="fas fa-cog text-slate-500 mr-2"></i>
                                @endswitch
                                {{ $group }}
                            </h4>
                            <div class="space-y-2">
                                @foreach($permissions as $perm)
                                <label class="flex items-center space-x-3 cursor-pointer group permission-checkbox-label">
                                    <input type="checkbox" name="permissions[]" value="{{ $perm }}"
                                        {{ in_array($perm, old('permissions', [])) ? 'checked' : '' }}
                                        class="permission-checkbox w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500 transition-all">
                                    <span class="text-sm text-slate-600 group-hover:text-slate-800 transition-colors">
                                        @switch($perm)
                                            @case('view products') Xem sản phẩm @break
                                            @case('create products') Thêm sản phẩm @break
                                            @case('edit products') Sửa sản phẩm @break
                                            @case('delete products') Xóa sản phẩm @break
                                            @case('view categories') Xem danh mục @break
                                            @case('create categories') Thêm danh mục @break
                                            @case('edit categories') Sửa danh mục @break
                                            @case('delete categories') Xóa danh mục @break
                                            @case('view orders') Xem đơn hàng @break
                                            @case('manage orders') Quản lý đơn hàng @break
                                            @case('view analytics') Xem phân tích @break
                                            @case('manage users') Quản lý người dùng @break
                                            @case('manage roles') Quản lý phân quyền @break
                                            @default {{ $perm }}
                                        @endswitch
                                    </span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center space-x-4 pt-4">
                    <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/25">
                        Lưu người dùng
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="px-8 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition-all">
                        Hủy bỏ
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const roleSelect = document.getElementById('roleSelect');
    const permissionsGrid = document.getElementById('permissionsGrid');
    const adminBadge = document.getElementById('adminBadge');
    const checkboxes = document.querySelectorAll('.permission-checkbox');

    function togglePermissions() {
        const isAdmin = roleSelect.value === 'admin';
        if (isAdmin) {
            permissionsGrid.style.opacity = '0.5';
            permissionsGrid.style.pointerEvents = 'none';
            adminBadge.classList.remove('hidden');
            checkboxes.forEach(cb => cb.checked = true);
        } else {
            permissionsGrid.style.opacity = '1';
            permissionsGrid.style.pointerEvents = 'auto';
            adminBadge.classList.add('hidden');
        }
    }

    roleSelect.addEventListener('change', togglePermissions);
    togglePermissions(); // Khởi tạo trạng thái ban đầu
</script>
@endsection
