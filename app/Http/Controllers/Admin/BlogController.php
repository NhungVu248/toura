<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{

    public function index()
    {
        $blogs = Blog::latest()->paginate(10);

        return view('admin.blogs.index', compact('blogs'));
    }


    public function create()
    {
        return view('admin.blogs.create');
    }


    public function store(Request $request)
    {

        $data = $request->validate([
            'title' => 'required|max:255',
            'thumbnail' => 'nullable|image',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'status' => 'nullable'
        ]);

        $data['slug'] = Str::slug($data['title']);

        if($request->hasFile('thumbnail'))
        {
            $data['thumbnail'] = $request->file('thumbnail')
                ->store('blogs','public');
        }

        $data['status'] = $request->has('status');

        Blog::create($data);

        return redirect()
            ->route('admin.blogs.index')
            ->with('success','Blog created successfully');
    }



    public function edit($id)
    {
        $blog = Blog::findOrFail($id);

        return view('admin.blogs.edit', compact('blog'));
    }



    public function update(Request $request, $id)
    {

        $blog = Blog::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|max:255',
            'thumbnail' => 'nullable|image',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'status' => 'nullable'
        ]);

        if($blog->title != $request->title)
        {
            $data['slug'] = Str::slug($data['title']);
        }

        if($request->hasFile('thumbnail'))
        {
            if($blog->thumbnail)
            {
                Storage::disk('public')->delete($blog->thumbnail);
            }

            $data['thumbnail'] = $request->file('thumbnail')
                ->store('blogs','public');
        }

        $data['status'] = $request->has('status');

        $blog->update($data);

        return redirect()
            ->route('admin.blogs.index')
            ->with('success','Blog updated successfully');
    }



    public function destroy($id)
    {

        $blog = Blog::findOrFail($id);

        if($blog->thumbnail)
        {
            Storage::disk('public')->delete($blog->thumbnail);
        }

        $blog->delete();

        return back()->with('success','Blog deleted');
    }
}