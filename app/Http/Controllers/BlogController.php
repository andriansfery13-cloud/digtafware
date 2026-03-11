<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the blog posts.
     */
    public function index()
    {
        $blogs = Blog::where('status', 'published')
            ->with('author')
            ->latest()
            ->paginate(9);

        return view('blogs.index', compact('blogs'));
    }

    /**
     * Display the specified blog post.
     */
    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->where('status', 'published')
            ->with('author')
            ->firstOrFail();

        return view('blogs.show', compact('blog'));
    }
}
