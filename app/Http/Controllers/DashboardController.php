<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        
        // Tambahkan data lain yang diperlukan untuk dashboard
        
        return view('dashboard', compact('user', 'totalUsers', 'activeUsers'));
    }
}