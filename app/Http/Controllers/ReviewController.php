<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function store(Request $request, $tourId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        $tour = Tour::findOrFail($tourId);

        // Không cho review trùng
        $existingReview = Review::where('tour_id', $tourId)
                                ->where('user_id', auth()->id())
                                ->first();

        if ($existingReview) {
            return back()->with('error', 'Bạn đã đánh giá tour này rồi.');
        }

        DB::transaction(function () use ($request, $tour) {

            Review::create([
                'tour_id' => $tour->id,
                'user_id' => auth()->id(),
                'rating' => $request->rating,
                'comment' => $request->comment,
                'approved' => true, // nếu muốn admin duyệt thì set false
            ]);

            // Recalculate rating
            $agg = Review::where('tour_id', $tour->id)
                        ->where('approved', true)
                        ->selectRaw('AVG(rating) as avg, COUNT(*) as cnt')
                        ->first();

            $tour->rating_avg = round($agg->avg ?? 0, 2);
            $tour->rating_count = $agg->cnt ?? 0;
            $tour->save();
        });

        return back()->with('success', 'Cảm ơn bạn đã đánh giá!');
    }
}