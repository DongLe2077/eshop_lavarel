<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        // Tìm user theo email
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();
            
            // Khôi phục giỏ hàng
            $sessionCart = session()->get('cart', []);
            $dbCart = $user->cart_data ?? [];
            
            // Gộp giỏ hàng hiện tại với giỏ hàng trong DB
            foreach ($dbCart as $id => $item) {
                if (isset($sessionCart[$id])) {
                    $sessionCart[$id]['quantity'] += $item['quantity'];
                } else {
                    $sessionCart[$id] = $item;
                }
            }
            session()->put('cart', $sessionCart);
            
            // Lưu lại DB nếu có merge
            if (!empty($sessionCart)) {
                $user->cart_data = $sessionCart;
                $user->save();
            }
            
            // Phân quyền chuyển hướng
            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('home'));
        }

        return back()->with('error', 'Email hoặc mật khẩu không đúng.')->withInput();
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = new User();
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'customer';
        $user->save();

        Auth::login($user);

        // Lưu giỏ hàng hiện tại vào DB cho user mới (nếu có)
        $sessionCart = session()->get('cart', []);
        if (!empty($sessionCart)) {
            $user->cart_data = $sessionCart;
            $user->save();
        }

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
