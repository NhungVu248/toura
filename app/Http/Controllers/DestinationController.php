<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DestinationController extends Controller
{
    public function index(Request $request)
    {
        $query = Tour::query()
            ->where('status', 'active');

        /*
        |--------------------------------------------------------------------------
        | Search theo tên tour
        |--------------------------------------------------------------------------
        */
        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        /*
        |--------------------------------------------------------------------------
        | Filter theo destination
        |--------------------------------------------------------------------------
        */
        if ($request->filled('destination')) {
            $query->where('destination', $request->destination);
        }

        /*
        |--------------------------------------------------------------------------
        | Filter theo domain
        |--------------------------------------------------------------------------
        */
        if ($request->filled('domain')) {
            $query->where('domain', $request->domain);
        }
        
        /*
        |--------------------------------------------------------------------------
        | Filter theo giá
        |--------------------------------------------------------------------------
        */
        if ($request->filled('min_price')) {
            $query->where('price_adult', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price_adult', '<=', $request->max_price);
        }

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */
        switch ($request->get('sort')) {

            case 'price_asc':
                $query->orderBy('price_adult', 'asc');
                break;

            case 'price_desc':
                $query->orderBy('price_adult', 'desc');
                break;

            case 'featured':
                $query->orderBy('is_featured', 'desc');
                break;

            default:
                $query->orderBy('created_at', 'desc');
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */
        $tours = $query->paginate(9)
            ->appends($request->query());

        /*
        |--------------------------------------------------------------------------
        | Data cho filter
        |--------------------------------------------------------------------------
        */
        $destinations = Tour::select('destination')
            ->distinct()
            ->pluck('destination');

        $domains = Tour::select('domain')
            ->distinct()
            ->pluck('domain');
        /*
|--------------------------------------------------------------------------
| Điểm đến phổ biến
|--------------------------------------------------------------------------
*/

        $topDest = Tour::where('status','active')
            ->select('destination', DB::raw('COUNT(*) as cnt'))
            ->groupBy('destination')
            ->orderByDesc('cnt')
            ->limit(4)
            ->get();

        $popularDestinations = collect();

        foreach ($topDest as $d) {

            $rep = Tour::where('status','active')
                ->where('destination', $d->destination)
                ->orderByDesc('is_featured')
                ->orderByDesc('rating_avg')
                ->first();

            $popularDestinations->push([
                'destination' => $d->destination,
                'thumbnail'   => $rep ? $rep->thumbnail : null,
                'url'         => route('destination.index', [
                    'destination' => $d->destination
                ]),
                'slug'        => Str::slug($d->destination),
            ]);
        }
        /*
        |--------------------------------------------------------------------------
        | Reviews (Social Proof Section)
        |--------------------------------------------------------------------------
        */
        $reviews = Review::where('approved', 1)
            ->with('user')
            ->latest()
            ->take(6)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Rating thống kê
        |--------------------------------------------------------------------------
        */
        $ratingAvg = Review::where('approved',1)->avg('rating');
        $reviewCount = Review::where('approved',1)->count();

        return view('destination.index', compact(
            'tours',
            'destinations',
            'popularDestinations',
            'domains',
            'reviews',
            'ratingAvg',
            'reviewCount'
        ));
    }
}