<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TourController extends Controller
{
    public function __construct()
    {
        //$this->middleware(['auth', 'admin']); // ensure admin
    }

    public function index(Request $request)
    {
        $query = Tour::query();

        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%')
                  ->orWhere('destination', 'like', '%' . $request->q . '%');
        }

        $tours = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('admin.tours.index', compact('tours'));
    }

    public function create()
    {
        return view('admin.tours.create');
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
            'thumbnail' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
            'is_featured' => 'sometimes|boolean',
        ]);

        // slug
        $data['slug'] = Tour::makeUniqueSlug($request->title);

        // thumbnail
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('tours', 'public');
            $data['thumbnail'] = $path;
        }

        $data['is_featured'] = $request->has('is_featured') ? (bool)$request->is_featured : false;

        Tour::create($data);

        return redirect()->route('admin.tours.index')->with('success', 'Tour được tạo thành công.');
    }

    public function show(Tour $tour)
    {
        return view('admin.tours.show', compact('tour'));
    }

    public function edit(Tour $tour)
    {
        return view('admin.tours.edit', compact('tour'));
    }

    public function update(Request $request, Tour $tour)
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
            'thumbnail' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
            'is_featured' => 'sometimes|boolean',
        ]);

        // update slug if title changed
        if ($tour->title !== $request->title) {
            $data['slug'] = Tour::makeUniqueSlug($request->title);
        }

        if ($request->hasFile('thumbnail')) {
            // delete old file if exists
            if ($tour->thumbnail && Storage::disk('public')->exists($tour->thumbnail)) {
                Storage::disk('public')->delete($tour->thumbnail);
            }
            $path = $request->file('thumbnail')->store('tours', 'public');
            $data['thumbnail'] = $path;
        }

        $data['is_featured'] = $request->has('is_featured') ? (bool)$request->is_featured : false;

        $tour->update($data);

        return redirect()->route('admin.tours.index')->with('success', 'Tour được cập nhật thành công.');
    }

    public function destroy(Tour $tour)
    {
        // delete thumbnail
        if ($tour->thumbnail && Storage::disk('public')->exists($tour->thumbnail)) {
            Storage::disk('public')->delete($tour->thumbnail);
        }
        $tour->delete();

        return redirect()->route('admin.tours.index')->with('success', 'Tour đã bị xóa.');
    }
}