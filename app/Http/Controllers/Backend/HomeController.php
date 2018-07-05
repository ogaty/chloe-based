<?php

namespace App\Http\Controllers\Backend;

use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use App\Models\Settings;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display the application home page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data = [
            'posts' => Post::all(),
            'recentPosts' => Post::orderBy('created_at', 'desc')->take(4)->get(),
            'tags' => Tag::all(),
            'users' => User::all(),
            'disqus' => Settings::disqus(),
            'analytics' => Settings::gaId(),
            'status' => 1,
            'canvasVersion' => 1,
            'latestRelease' => Settings::latestRelease(),
        ];

        return view('backend.home.index', compact('data'));
    }
}
