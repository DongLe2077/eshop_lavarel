<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();

            // Kiểm tra quyền: Spatie trước, fallback về cột role cũ
            try {
                // Admin toàn quyền HOẶC user có ít nhất 1 permission admin
                if ($user->hasRole('admin') || $user->role === 'admin') {
                    return $next($request);
                }

                // Cho phép user có bất kỳ permission nào trong nhóm admin truy cập admin panel
                $adminPermissions = [
                    'view products', 'create products', 'edit products', 'delete products',
                    'view categories', 'create categories', 'edit categories', 'delete categories',
                    'view orders', 'manage orders',
                    'view analytics',
                    'manage users', 'manage roles',
                ];

                if ($user->hasAnyPermission($adminPermissions)) {
                    return $next($request);
                }
            } catch (\Exception $e) {
                // Nếu bảng permission chưa tồn tại, dùng cột role cũ
                if ($user->role === 'admin') {
                    return $next($request);
                }
            }

            // Đã đăng nhập nhưng không phải admin và không có permission
            return redirect()->route('home')->with('error', 'Bạn không có quyền truy cập vào khu vực này.');
        }

        // Chưa đăng nhập → về trang login
        return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
    }
}
