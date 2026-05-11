<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $this->authorizePermission('view products');
        $products = Product::with('category')->orderBy('id', 'desc')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $this->authorizePermission('create products');
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->authorizePermission('create products');
        $request->validate([
            'name' => 'required|max:256',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $data = $request->except('image_file');

        // Nếu không upload file, giữ URL ảnh cũ (nếu có)
        $product = Product::create($data);

        // Upload ảnh qua MediaLibrary nếu có file
        if ($request->hasFile('image_file')) {
            $product->addMediaFromRequest('image_file')
                ->toMediaCollection('products');
        }

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function edit(Product $product)
    {
        $this->authorizePermission('edit products');
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorizePermission('edit products');
        $request->validate([
            'name' => 'required|max:256',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $data = $request->except('image_file');
        $product->update($data);

        // Upload ảnh mới nếu có (singleFile() sẽ tự xóa ảnh cũ)
        if ($request->hasFile('image_file')) {
            $product->addMediaFromRequest('image_file')
                ->toMediaCollection('products');
        }

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function destroy(Product $product)
    {
        $this->authorizePermission('delete products');
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công!');
    }

    public function bulkDelete(Request $request)
    {
        $this->authorizePermission('delete products');
        $ids = $request->ids;
        if (!empty($ids)) {
            Product::whereIn('id', $ids)->delete();
            return response()->json(['success' => 'Đã xóa ' . count($ids) . ' sản phẩm.']);
        }
        return response()->json(['error' => 'Vui lòng chọn sản phẩm cần xóa.'], 400);
    }

    /**
     * Kiểm tra permission - admin toàn quyền, user khác cần permission cụ thể.
     */
    private function authorizePermission(string $permission): void
    {
        $user = auth()->user();
        if ($user->role === 'admin') return; // Admin cũ toàn quyền

        try {
            if (!$user->hasPermissionTo($permission)) {
                abort(403, 'Bạn không có quyền thực hiện hành động này.');
            }
        } catch (\Exception $e) {
            abort(403, 'Bạn không có quyền thực hiện hành động này.');
        }
    }
}
