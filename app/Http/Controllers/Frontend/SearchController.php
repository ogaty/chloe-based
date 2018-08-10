<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Models\Post;
use \App\Models\Tag;
use Carbon\Carbon;


class SearchController extends Controller
{
    public function index(Request $request) {
        $tag = $request->get('tag');
        $tagModel = new Tag();

        $posts = Post::with('tags')
            ->where('published_at', '<=', Carbon::now())
            ->where('custom_code', 'blog')
            ->where('is_published', 1)
            ->where('title', 'like', '%' . $request->get('query') . '%')
            ->orderBy('published_at', 'desc')
            ->simplePaginate(6);
        $data = [
            'posts' => $posts,
            'tag' => $tagModel,
            'reverse_direction' => false,
        ];
        return view('frontend.blogs.index', $data);

    }
}
