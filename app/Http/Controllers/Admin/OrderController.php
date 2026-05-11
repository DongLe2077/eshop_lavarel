<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $this->authorizePermission('view orders');
        $orders = Order::with('user')->orderBy('id', 'desc')->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorizePermission('manage orders');
        $order = Order::findOrFail($id);
        
        $request->validate([
            'status' => 'required|string|in:pending,processing,completed,canceled',
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorizePermission('manage orders');
        $order = Order::findOrFail($id);
        $order->details()->delete();
        $order->delete();

        return redirect()->back()->with('success', 'Đã xóa đơn hàng thành công!');
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
