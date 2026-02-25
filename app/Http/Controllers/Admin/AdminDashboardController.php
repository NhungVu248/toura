<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client\User;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ===== SUMMARY USER =====
        $summary = [
            'totalUsers' => User::count(),
            'totalAdmin' => User::where('role', 'admin')->count(),
            'totalClient' => User::where('role', 'user')->count(),
            'newUsersThisMonth' => User::whereMonth('created_at', now()->month)->count(),
        ];

        // ===== USER ĐĂNG KÝ GẦN ĐÂY =====
        $latestUsers = User::latest()
            ->limit(5)
            ->get();

        // ===== USER ĐĂNG KÝ THEO THÁNG =====
        $userPerMonth = User::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'month');

        return view('admin.dashboard', compact(
            'summary',
            'latestUsers',
            'userPerMonth'
        ));
    }
}