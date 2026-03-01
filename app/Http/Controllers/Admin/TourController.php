<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\TourImage;
use App\Models\TourSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TourController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth', 'admin']);
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
    // Chuẩn hóa dữ liệu giá nếu nhập dạng có ký tự
    $request->merge([
        'price_adult' => preg_replace('/[^0-9.]/', '', $request->price_adult),
        'price_child' => preg_replace('/[^0-9.]/', '', $request->price_child),
    ]);

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'destination' => 'required|string|max:255',
        'departure_location' => 'required|string|max:255',
        'duration' => 'required|integer|min:1',
        'short_description' => 'required|string|max:500',
        'description' => 'required|string',
        'price_adult' => 'required|numeric|min:0',
        'price_child' => 'nullable|numeric|min:0',
        'thumbnail' => 'nullable|image|max:4096',
        'images.*' => 'nullable|image|max:4096',
        'status' => 'required|in:active,inactive',
        'is_featured' => 'nullable',
    ]);

    DB::beginTransaction();

    try {

        // Tạo slug
        $validated['slug'] = Tour::makeUniqueSlug($validated['title']);

        // Thumbnail
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')
                ->store('tours', 'public');
        }

        // Checkbox
        $validated['is_featured'] = $request->has('is_featured');

        // Tạo tour
        $tour = Tour::create($validated);

        /*
        |--------------------------------------------------------------------------
        | Upload gallery images
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('tours', 'public');

                $tour->images()->create([
                    'path' => $path,
                    'is_primary' => $index === 0,
                    'sort_order' => $index,
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Lịch khởi hành (optional)
        |--------------------------------------------------------------------------
        */
        $schedules = $request->input('schedules', []);

        if (is_array($schedules)) {

            foreach ($schedules as $sched) {

                // Nếu không có ngày thì bỏ qua
                if (empty($sched['departure_date'])) {
                    continue;
                }

                $seatsTotal = !empty($sched['seats_total'])
                    ? (int) $sched['seats_total']
                    : 30;

                $tour->schedules()->create([
                    'departure_date' => $sched['departure_date'],
                    'departure_time' => $sched['departure_time'] ?? null,
                    'seats_total' => $seatsTotal,
                    'seats_available' => $seatsTotal,
                    'price_override' => !empty($sched['price_override'])
                        ? preg_replace('/[^0-9.]/', '', $sched['price_override'])
                        : null,
                    'status' => $sched['status'] ?? 'open',
                ]);
            }
        }

        DB::commit();

        return redirect()
            ->route('admin.tours.index')
            ->with('success', 'Tour được tạo thành công.');

    } catch (\Exception $e) {

        DB::rollBack();

        Log::error('Tour Store Error: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);

        return back()
            ->withInput()
            ->with('error', 'Có lỗi khi tạo tour. Kiểm tra log để biết chi tiết.');
    }
}

    public function show(Tour $tour)
    {
        return view('admin.tours.show', compact('tour'));
    }

    public function edit($id)
    {
        // use id to avoid slug binding conflicts in admin routes
        $tour = Tour::findOrFail($id);
        // eager load schedules and images for the edit view
        $tour->load(['schedules', 'images']);
        return view('admin.tours.edit', compact('tour'));
    }

    public function update(Request $request, $id)
    {
        $tour = Tour::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure_location' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'short_description' => 'required|string|max:500',
            'price_adult' => str_replace('.', '', $request->price_adult),
    'price_child' => str_replace('.', '', $request->price_child),
            'price_child' => 'nullable|numeric|min:0',
            'thumbnail' => 'nullable|image|max:4096',
            'images.*' => 'nullable|image|max:4096',
            'status' => 'required|in:active,inactive',
            'is_featured' => 'nullable|boolean',
        ]);

        $schedules = $request->input('schedules', []);

        DB::beginTransaction();
        try {
            // update slug if title changed
            if ($tour->title !== $request->title) {
                $data['slug'] = Tour::makeUniqueSlug($request->title);
            }

            // thumbnail replacement
            if ($request->hasFile('thumbnail')) {
                if ($tour->thumbnail && Storage::disk('public')->exists($tour->thumbnail)) {
                    Storage::disk('public')->delete($tour->thumbnail);
                }
                $path = $request->file('thumbnail')->store('tours', 'public');
                $data['thumbnail'] = $path;
            }

            $data['is_featured'] = $request->has('is_featured') ? (bool)$request->is_featured : false;

            $tour->update($data);

            // If new gallery images uploaded, delete old ones and save new ones
            if ($request->hasFile('images')) {
                // delete files
                foreach ($tour->images as $oldImage) {
                    if ($oldImage->path && Storage::disk('public')->exists($oldImage->path)) {
                        Storage::disk('public')->delete($oldImage->path);
                    }
                }
                // delete records
                $tour->images()->delete();

                // save new images
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('tours', 'public');

                    $tour->images()->create([
                        'path' => $path,
                        'is_primary' => $index === 0,
                        'sort_order' => $index,
                    ]);
                }
            }

            // schedules: update existing or create new
            if (!empty($schedules) && is_array($schedules)) {
                foreach ($schedules as $sched) {
                    // update existing schedule
                    if (!empty($sched['id'])) {
                        $sch = $tour->schedules()->where('id', $sched['id'])->first();
                        if ($sch) {
                            $seatsTotal = isset($sched['seats_total']) ? (int)$sched['seats_total'] : $sch->seats_total;
                            $sch->update([
                                'departure_date' => $sched['departure_date'] ?? $sch->departure_date,
                                'departure_time' => $sched['departure_time'] ?? $sch->departure_time,
                                'seats_total' => $seatsTotal,
                                'price_override' => $sched['price_override'] ?? $sch->price_override,
                                'status' => $sched['status'] ?? $sch->status,
                            ]);
                            // ensure seats_available not greater than seats_total
                            if ($sch->seats_available > $seatsTotal) {
                                $sch->seats_available = $seatsTotal;
                                $sch->save();
                            }
                        }
                    } else {
                        // create new schedule if departure_date present
                        if (!empty($sched['departure_date'])) {
                            $seatsTotal = isset($sched['seats_total']) ? (int)$sched['seats_total'] : 30;
                            $tour->schedules()->create([
                                'departure_date' => $sched['departure_date'],
                                'departure_time' => $sched['departure_time'] ?? null,
                                'seats_total' => $seatsTotal,
                                'seats_available' => $seatsTotal,
                                'price_override' => $sched['price_override'] ?? null,
                                'status' => $sched['status'] ?? 'open',
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.tours.index')->with('success', 'Tour được cập nhật thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Admin Tour update error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->withInput()->with('error', 'Có lỗi khi cập nhật tour. Kiểm tra log (storage/logs/laravel.log).');
        }
    }

    public function destroy(Tour $tour)
    {
        // delete thumbnail
        if ($tour->thumbnail && Storage::disk('public')->exists($tour->thumbnail)) {
            Storage::disk('public')->delete($tour->thumbnail);
        }
        // delete gallery files
        foreach ($tour->images as $img) {
            if ($img->path && Storage::disk('public')->exists($img->path)) {
                Storage::disk('public')->delete($img->path);
            }
        }
        $tour->delete();
        return redirect()->route('admin.tours.index')->with('success', 'Tour đã bị xóa.');
    }
}