<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $this->authorizePermission('view categories');
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $this->authorizePermission('create categories');
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $this->authorizePermission('create categories');
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|string'
        ]);

        Category::create($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Thêm danh mục thành công!');
    }

    public function edit($id)
    {
        $this->authorizePermission('edit categories');
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizePermission('edit categories');
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|string'
        ]);

        $category->update($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroy($id)
    {
        $this->authorizePermission('delete categories');
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Xóa danh mục thành công!');
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
