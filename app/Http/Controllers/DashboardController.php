<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\Blog;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        // TOUR NỔI BẬT
        $featuredTours = Tour::where('status','active')
                            ->where('is_featured',1)
                            ->take(6)
                            ->get();


        // ĐIỂM ĐẾN PHỔ BIẾN
        $popularDestinations = Tour::select('destination','thumbnail')
                ->where('status','active')
                ->groupBy('destination','thumbnail')
                ->take(4)
                ->get();


        // BLOG DU LỊCH
        $blogs = Blog::latest()
                ->take(3)
                ->get();


        return view('dashboard',[
            'featuredTours'=>$featuredTours,
            'popularDestinations'=>$popularDestinations,
            'blogs'=>$blogs
        ]);
    }
}