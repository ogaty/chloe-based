<?php

namespace App\Http\Controllers\Backend;

use Session;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\Tag;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use Carbon\Carbon;

class PostController extends Controller
{
    const PER_PAGE = 6;
    /**
     * Display a listing of the posts.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data = Post::where('custom_code', 'blog')->simplePaginate(15);

        return view('backend.post.index', compact('data'));
    }

    public function page(Request $request)
    {
        $page = $request->get('page');
        $skip = self::PER_PAGE * $page;
        $data = Post::where('custom_code', 'blog')->skip($skip)->take(self::PER_PAGE)->get()->toArray();

        return $data;
    }

    /**
     * Show the new post form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data = new Post();
	$data->published_at = Carbon::now();
        $allTagIds = Tag::all()->toArray();
        return view('backend.post.create', compact('allTagIds', 'data'));
    }

    /**
     * Store a newly created Post.
     *
     * @param PostCreateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostCreateRequest $request)
    {
        $post = Post::create($request->postFillData());
        $post->tags()->attach($request->get('tags', []));

        $request->session()->put('_new-post', 'Success! New :entity has been created.');

        return redirect()->route('admin.post.edit', $post->id);
    }

    /**
     * Show the post edit form.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $data = Post::find($id);
        $allTagIds = Tag::all()->toArray();

        return view('backend.post.edit', compact('id', 'data', 'allTagIds'));
    }

    /**
     * Update the Post.
     *
     * @param PostUpdateRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostUpdateRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->fill($request->postFillData());
        $post->save();
        $post->syncTags($request->get('tags', []));

        $request->session()->put('_update-post', 'Success! :entity has been updated.');

        return redirect()->route('admin.post.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->tags()->detach();
        $post->delete();

        $request->session()->put('_delete-post', 'Success! :entity has been deleted.');

        return redirect()->route('admin.post.index');
    }
}
