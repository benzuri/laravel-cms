<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\CategoryPost;
use App\Models\Setting;

class PostController extends Controller
{
    public $pagination;

    public function __construct()
    {
        $setting = Setting::where('key', 'pagination')->first();
        $this->pagination = $setting && is_int(intval($setting->value)) ? intval($setting->value) : 6;
    }
    
    /**
     * Show index
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::where('published', 1)->paginate($this->pagination);

        return view('welcome', compact('posts'));
    }

    /**
     * Show detail
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($slug)
    {
        $item = Post::where('slug', $slug)->where('published', 1)->first();
        abort_unless($item, 404);

        $post = Post::findOrFail($item->id);
        
        return view('detail', compact('post'));
    }

    /**
     * Search by title
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchByTitle(Request $request)
    {
        $search = $request->input('q');
        abort_unless($search, 404);

        $posts = Post::where('published', 1)->where(function ($query) use ($search) {
            $query->where('title', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%");
        })->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')
            ->paginate($this->pagination);

        return view('welcome', ['posts' => $posts]);
    }

    /**
     * Search by category
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showByCategory($categorySlug)
    {
        $category = CategoryPost::where('slug', $categorySlug)->first();
        abort_unless($category, 404);

        $posts = Post::where('published', 1)->where('category_post_id', $category->id)
            ->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')
            ->paginate($this->pagination);

        return view('welcome', ['posts' => $posts]);
    }
}
