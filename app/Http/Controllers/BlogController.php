<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::where('status', 1);

        // SEARCH BLOG
        if ($request->filled('q')) {
            $keyword = $request->q;

            $query->where(function($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('excerpt', 'like', "%{$keyword}%")
                  ->orWhere('content', 'like', "%{$keyword}%");
            });
        }

        $blogs = $query->latest()
                       ->paginate(9)
                       ->appends($request->query());

        return view('blogs.index', compact('blogs'));
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)
                    ->where('status', 1)
                    ->firstOrFail();

        return view('blogs.show', compact('blog'));
    }
}