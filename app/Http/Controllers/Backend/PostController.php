<?php

namespace App\Http\Controllers\Backend;

use Session;
use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the posts.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data = Post::where('custom_code', 'blog')->get();

        return view('backend.post.index', compact('data'));
    }

    /**
     * Show the new post form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data = [];

        return view('backend.post.create', $data);
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
        $post->syncTags($request->get('tags', []));

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
        $data = $this->dispatch(new PostFormFields($id));

        return view('backend.post.edit', $data);
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

        return redirect()->route('admin.techs.index');
    }
}
