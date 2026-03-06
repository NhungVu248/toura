<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client\User;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;
class AdminDashboardController extends Controller
{
    public function index()
    {
        $summary = [
            'totalUsers' => User::count(),
            'totalAdmin' => User::where('role','admin')->count(),
            'totalClient' => User::where('role','user')->count(),
            'newUsersThisMonth' =>
                User::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];
        // 2. Thống kê Doanh thu các tháng trong năm nay từ bảng Bookings
        $revenueData = Booking::paid() 
            ->selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
            ->whereYear('created_at', now()->year) 
            ->groupBy('month')
            ->pluck('total', 'month') 
            ->toArray();

        $labels = [];
        $values = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = 'Tháng ' . $i;
            $values[] = (float)($revenueData[$i] ?? 0); 
        }

        $chartData = [
            'labels' => $labels,
            'values' => $values,
        ];

        return view('admin.dashboard', compact('summary', 'chartData'));
    }
}