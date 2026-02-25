<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client\User;
use Illuminate\Support\Facades\DB;

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

        return view('admin.dashboard', compact('summary'));
    }
}