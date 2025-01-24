<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SuratPerintah;
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
        $data = [
            'totalUsers' => User::count(),
            'activeUsers' => User::where('is_active', true)->count(),
            'totalSprin' => SuratPerintah::count(),
            'totalLaporan' => 0, // Sesuaikan dengan model Laporan jika ada
            'latestSprin' => SuratPerintah::latest()
                ->take(5)
                ->get(), // Hapus select dengan alias
            'latestUsers' => User::latest()
                ->take(8)
                ->get()
        ];
    
        return view('dashboard', $data);
    }
}