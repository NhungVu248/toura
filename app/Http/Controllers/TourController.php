<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    // public listing (show only active tours)
    public function index(Request $request)
    {
        $query = Tour::where('status', 'active');

        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        if ($request->filled('destination')) {
            $query->where('destination', $request->destination);
        }

        $tours = $query->orderBy('is_featured', 'desc')
                       ->orderBy('created_at', 'desc')
                       ->paginate(12);

        return view('tours.index', compact('tours'));
    }

    // show detail (route model binding by slug)
    public function show(Tour $tour)
    {
        if ($tour->status !== 'active') {
            abort(404);
        }

        // simple "related" suggestion: same destination or featured
        $related = Tour::where('id', '!=', $tour->id)
                    ->where('status', 'active')
                    ->where(function($q) use ($tour) {
                        $q->where('destination', $tour->destination)
                          ->orWhere('is_featured', true);
                    })
                    ->limit(4)
                    ->get();

        return view('tours.show', compact('tour', 'related'));
    }
    
}