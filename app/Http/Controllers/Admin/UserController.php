<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
        $this->authorizePermission('manage users');
        $users = User::orderBy('id', 'asc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $this->authorizePermission('manage users');
        $allPermissions = $this->getAllPermissions();
        return view('admin.users.create', compact('allPermissions'));
    }

    /**
     * Redirect show sang edit (vì không có trang show riêng).
     */
    public function show(User $user)
    {
        return redirect()->route('admin.users.edit', $user->id);
    }

    public function store(Request $request)
    {
        $this->authorizePermission('manage users');
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,customer',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Đồng bộ vai trò và permissions Spatie
        try {
            $user->syncRoles($request->role);

            // Nếu là admin thì gán toàn bộ permission, nếu không thì gán theo checkbox
            if ($request->role === 'admin') {
                $user->syncPermissions(Permission::all());
            } else {
                $user->syncPermissions($request->permissions ?? []);
            }
        } catch (\Exception $e) {
            // Bảng permission chưa được migrate, bỏ qua
        }

        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được tạo thành công.');
    }

    public function edit(User $user)
    {
        $this->authorizePermission('manage users');
        $allPermissions = $this->getAllPermissions();
        $userPermissions = [];

        try {
            $userPermissions = $user->getDirectPermissions()->pluck('name')->toArray();
        } catch (\Exception $e) {
            // Bảng permission chưa được migrate
        }

        return view('admin.users.edit', compact('user', 'allPermissions', 'userPermissions'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorizePermission('manage users');
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,customer',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // Đồng bộ vai trò và permissions Spatie
        try {
            $user->syncRoles($request->role);

            if ($request->role === 'admin') {
                $user->syncPermissions(Permission::all());
            } else {
                $user->syncPermissions($request->permissions ?? []);
            }
        } catch (\Exception $e) {
            // Bảng permission chưa được migrate, bỏ qua
        }

        return redirect()->route('admin.users.index')->with('success', 'Thông tin người dùng đã được cập nhật.');
    }

    public function destroy(User $user)
    {
        $this->authorizePermission('manage users');
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Bạn không thể tự xóa chính mình.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được xóa.');
    }

    /**
     * Lấy tất cả permissions, nhóm theo module.
     */
    private function getAllPermissions(): array
    {
        try {
            $permissions = Permission::all()->pluck('name')->toArray();
        } catch (\Exception $e) {
            $permissions = [];
        }

        // Nhóm permissions theo module
        $grouped = [
            'Sản phẩm' => [],
            'Danh mục' => [],
            'Đơn hàng' => [],
            'Phân tích' => [],
            'Người dùng' => [],
        ];

        $moduleMap = [
            'products' => 'Sản phẩm',
            'categories' => 'Danh mục',
            'orders' => 'Đơn hàng',
            'analytics' => 'Phân tích',
            'users' => 'Người dùng',
            'roles' => 'Người dùng',
        ];

        foreach ($permissions as $perm) {
            $matched = false;
            foreach ($moduleMap as $keyword => $group) {
                if (str_contains($perm, $keyword)) {
                    $grouped[$group][] = $perm;
                    $matched = true;
                    break;
                }
            }
            if (!$matched) {
                $grouped['Khác'][] = $perm;
            }
        }

        // Xóa nhóm rỗng
        return array_filter($grouped, fn($perms) => !empty($perms));
    }

    /**
     * Kiểm tra permission - admin toàn quyền, user khác cần permission cụ thể.
     */
    private function authorizePermission(string $permission): void
    {
        $user = auth()->user();
        if ($user->role === 'admin') return;

        try {
            if (!$user->hasPermissionTo($permission)) {
                abort(403, 'Bạn không có quyền thực hiện hành động này.');
            }
        } catch (\Exception $e) {
            abort(403, 'Bạn không có quyền thực hiện hành động này.');
        }
    }
}
