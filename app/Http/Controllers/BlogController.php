<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        
        $blogs = Blog::where('status', 1)->latest()->paginate(9);
        
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