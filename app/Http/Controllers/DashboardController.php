<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\CategoryPost;

class DashboardController extends Controller
{

    /**
     * Show index
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::all()->count();
        $categories = CategoryPost::all()->count();
        return view('dashboard', compact('posts', 'categories'));
    }
}
