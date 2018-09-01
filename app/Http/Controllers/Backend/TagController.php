<?php

namespace App\Http\Controllers\Backend;

use Session;
use App\Models\Tag;
use App\Http\Controllers\Controller;
use App\Http\Requests\TagCreateRequest;
use App\Http\Requests\TagUpdateRequest;
use Illuminate\Http\Request;

class TagController extends Controller
{
    const PER_PAGE = 6;

    protected $fields = [
        'name' => '',
        'slug' => '',
        'meta_description' => '',
        'layout' => 'frontend.blog.index',
        'reverse_direction' => 0,
        'created_at' => '',
        'updated_at' => '',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data = Tag::take(self::PER_PAGE)->simplePaginate(15);

        return view('backend.tag.index', compact('data'));
    }

    public function page(Request $request)
    {
        $page = $request->get('page');
        $skip = self::PER_PAGE * $page;
        $data = Tag::skip($skip)->take(self::PER_PAGE)->get()->toArray();

        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data = [];

        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }

        return view('backend.tag.create', compact('data'));
    }

    /**
     * Store the newly created tag in the database.
     *
     * @param TagCreateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TagCreateRequest $request)
    {
        $tag = new Tag();
        $tag->fill($request->toArray())->save();
        $tag->save();

        $request->session()->put('_new-tag', 'Success! New tag has been created.');

        return redirect()->route('admin.tag.index');
    }

    /**
     * Show the form for editing a tag.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        $data = ['id' => $id];
        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $tag->$field);
        }

        return view('backend.tag.edit', compact('data'));
    }

    /**
     * Update the tag in storage.
     *
     * @param TagUpdateRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TagUpdateRequest $request, $id)
    {
        $tag = Tag::findOrFail($id);
        $tag->fill($request->toArray())->save();
        $tag->save();

        $request->session()->put('_update-tag', 'Success! New tag has been uploaded.');

        return redirect()->route('admin.tag.edit', $id);
    }

    /**
     * Delete the tag.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        $request->session->put('_delete-tag', 'Success! :entity has been deleted.');

        return redirect()->route('canvas.admin.tag.index');
    }
}
