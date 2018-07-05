<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use \App\Models\Post;
use Carbon\Carbon;

class BlogController extends \App\Http\Controllers\Controller
{
    //
    public function index(Request $request) {
        $tag = $request->get('tag');

        $posts = Post::with('tags')
            ->where('published_at', '<=', Carbon::now())
            ->where('custom_code', 'blog')
            ->where('is_published', 1)
            ->orderBy('published_at', 'desc')
            ->simplePaginate(6);
        $data = [
            'posts' => $posts,
            'tag' => $tag,
            'reverse_direction' => false,
        ];
        return view('frontend.blogs.index', $data);
    }
}
