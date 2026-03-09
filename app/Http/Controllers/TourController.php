<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\Request;
use App\Models\TourImage;
use App\Models\Blog;
use App\Models\Booking;
use Illuminate\Support\Facades\Storage;

class TourController extends Controller
{
    // public listing (show only active tours)
    public function index(Request $request)
{
    $query = Tour::where('status', 'active');

    /*
    |--------------------------------
    | Keyword search
    |--------------------------------
    */

    if ($request->filled('q')) {
        $query->where('title', 'like', '%' . $request->q . '%');
    }

    /*
    |--------------------------------
    | Destination filter
    |--------------------------------
    */

    if ($request->filled('destination')) {
        $query->where('destination', $request->destination);
    }

    /*
    |--------------------------------
    | Domain filter
    |--------------------------------
    */

    if ($request->filled('domain')) {
        $query->where('domain', $request->domain);
    }

    /*
    |--------------------------------
    | Price filter
    |--------------------------------
    */

    if ($request->filled('min_price')) {
        $query->where('price_adult', '>=', $request->min_price);
    }

    if ($request->filled('max_price')) {
        $query->where('price_adult', '<=', $request->max_price);
    }

    /*
    |--------------------------------
    | Sorting
    |--------------------------------
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
            $query->orderBy('is_featured', 'desc')
                  ->orderBy('created_at', 'desc');
    }

    /*
    |--------------------------------
    | Pagination
    |--------------------------------
    */

    $tours = $query->paginate(12)
                   ->appends($request->query());

    /*
    |--------------------------------
    | Data for filters
    |--------------------------------
    */

    $destinations = Tour::select('destination')
        ->distinct()
        ->pluck('destination');

    $domains = Tour::select('domain')
        ->distinct()
        ->pluck('domain');
    // BLOG DU LỊCH
        $blogs = Blog::latest()
                ->take(3)
                ->get();

    /*
|--------------------------------
| Top booked tours
|--------------------------------
*/

$topTours = Tour::withCount('bookings')
            ->where('status','active')
            ->orderBy('bookings_count','desc')
            ->take(4)
            ->get();
    return view('tours.index', compact(
        'tours',
        'destinations',
        'domains',
        'blogs',
        'topTours'
    ));
}
    // show detail (route model binding by slug)
            public function show(Tour $tour)
        {
            // Giữ nguyên logic cũ
            if ($tour->status !== 'active') {
                abort(404);
            }
            $tour->load([
                'images',
                'approvedReviews.user'
            ]);
            $related = Tour::where('id', '!=', $tour->id)
                        ->where('status', 'active')
                        ->where(function($q) use ($tour) {
                            $q->where('destination', $tour->destination)
                            ->orWhere('is_featured', true);
                        })
                        ->limit(4)
                        ->get();
            $reviews = $tour->approvedReviews()
                            ->with('user')
                            ->latest()
                            ->paginate(5);

            return view('tours.show', compact('tour', 'related', 'reviews'));
        }
                public function store(Request $request)
            {
                $data = $request->validate([
                    'title' => 'required|string|max:255',
                    'destination' => 'required|string|max:255',
                    'departure_location' => 'required|string|max:255',
                    'duration' => 'required|integer|min:1',
                    'short_description' => 'required|string|max:500',
                    'description' => 'required|string',
                    'price_adult' => 'required|numeric|min:0',
                    'price_child' => 'nullable|numeric|min:0',
                    'images.*' => 'nullable|image|max:2048', // validate multiple images
                    'status' => 'required|in:active,inactive',
                ]);

                $data['slug'] = \App\Models\Tour::makeUniqueSlug($request->title);

                $tour = \App\Models\Tour::create($data);

                /*
                |--------------------------------------------------------------------------
                | Upload Multiple Images
                |--------------------------------------------------------------------------
                */

                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $index => $image) {

                        $path = $image->store('tours', 'public');

                        $tour->images()->create([
                            'path' => $path,
                            'is_primary' => $index === 0, // ảnh đầu tiên là primary
                            'sort_order' => $index,
                        ]);
                    }
                }

                return redirect()->route('admin.tours.index')
                                ->with('success', 'Tour created successfully.');
            }
        public function update(Request $request, \App\Models\Tour $tour)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure_location' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'price_adult' => 'required|numeric|min:0',
            'price_child' => 'nullable|numeric|min:0',
            'images.*' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        if ($tour->title !== $request->title) {
            $data['slug'] = \App\Models\Tour::makeUniqueSlug($request->title);
        }

        $tour->update($data);

        /*
        |--------------------------------------------------------------------------
        | Nếu upload ảnh mới → xóa ảnh cũ và lưu lại
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('images')) {

            // XÓA ẢNH CŨ TRONG STORAGE
            foreach ($tour->images as $oldImage) {
                if (Storage::disk('public')->exists($oldImage->path)) {
                    Storage::disk('public')->delete($oldImage->path);
                }
            }

            // XÓA RECORD DB
            $tour->images()->delete();

            // LƯU ẢNH MỚI
            foreach ($request->file('images') as $index => $image) {

                $path = $image->store('tours', 'public');

                $tour->images()->create([
                    'path' => $path,
                    'is_primary' => $index === 0,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.tours.index')
                        ->with('success', 'Tour updated successfully.');
    }
}