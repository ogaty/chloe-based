<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use \App\Models\Post;
use \App\Models\Tag;
use \App\Models\User;
use \App\Models\Settings;
use Carbon\Carbon;

class BlogController extends \App\Http\Controllers\Controller
{
    //
    public function index(Request $request) {
        $tag = $request->get('tag');
        $tagModel = Tag::where('title', $tag)->first();

        $posts = Post::with('tags')
            ->whereHas('tags', function ($q) use ($tagModel) {
                $q->where('id', '=', $tagModel->id);
            })
            ->where('published_at', '<=', Carbon::now())
            ->where('custom_code', 'blog')
            ->where('is_published', 1)
            ->orderBy('published_at', 'desc')
            ->simplePaginate(6);
        $data = [
            'posts' => $posts,
            'tag' => $tagModel,
            'reverse_direction' => false,
        ];
        return view('frontend.blogs.index', $data);
    }

    public function showPost($slug, Request $request)
    {
        $post = Post::with('tags')->whereSlug($slug)->firstOrFail();
        $user = User::where('id', $post->user_id)->firstOrFail();
        $tag = $request->get('tag');
        $title = $post->title;
        $css = Settings::customCSS();
        $js = Settings::customJS();

        if ($tag) {
            $tag = Tag::whereTag($tag)->firstOrFail();
        }

        if (! $post->is_published && ! Auth::check()) {
            return redirect()->route('canvas.blog.post.index');
        }

        $ad1 = $contents = Settings::ad1();
        $ad2 = $contents = Settings::ad2();
        $post->content_html = str_replace('<span id="ad1"></span>', $ad1, $post->content_html);
        $layout = "frontend.blogs.post";
        return view($layout, compact('post', 'tag', 'slug', 'title', 'user', 'css', 'js'));
    }
}
