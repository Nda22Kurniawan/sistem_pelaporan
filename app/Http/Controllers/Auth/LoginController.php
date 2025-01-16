<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class LoginController extends Controller
{
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    protected function validateLogin(Request $request)
    {
        return Validator::make($request->all(), [
            'nrp' => 'required|string',
            'password' => 'required|string',
        ], [
            'nrp.required' => 'NRP wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);
    }

    public function login(Request $request)
    {
        $validator = $this->validateLogin($request);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->only('nrp', 'remember'));
        }

        // Check if user exists and is active
        $user = User::where('nrp', $request->nrp)->first();
        
        if (!$user) {
            return back()
                ->withInput($request->only('nrp', 'remember'))
                ->withErrors(['nrp' => 'NRP tidak ditemukan.']);
        }

        if (!$user->is_active) {
            return back()
                ->withInput($request->only('nrp', 'remember'))
                ->withErrors(['nrp' => 'Akun Anda tidak aktif. Silahkan hubungi admin.']);
        }

        // Attempt to log the user in
        $credentials = $request->only('nrp', 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended($this->redirectTo)
                           ->with('success', 'Selamat datang, ' . $user->name);
        }

        // If unsuccessful, redirect back with an error message
        return back()
            ->withInput($request->only('nrp', 'remember'))
            ->withErrors(['nrp' => 'Kredensial yang Anda berikan tidak cocok dengan data kami.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
                        ->with('success', 'Anda telah berhasil logout.');
    }
}