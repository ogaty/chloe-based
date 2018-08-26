<?php

namespace App\Http\Controllers\Backend;

use Session;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display the user profile page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $userData = Auth::guard()->user()->toArray();
//        $blogData = config('blog');
//        $data = array_merge($userData, $blogData);

$data = $userData;
        return view('backend.profile.index', compact('data'));
    }

    /**
     * Display the user profile privacy page.
     *
     * @return \Illuminate\View\View
     */
    public function editPrivacy()
    {
        return view('backend.profile.privacy', [
            'data' => array_merge(Auth::guard()->user()->toArray(), config('blog')),
        ]);
    }

    /**
     * Update the user profile information.
     *
     * @param ProfileUpdateRequest $request
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->fill($request->toArray())->save();
        $user->save();

        $request->session()->put('_profile', trans('canvas::messages.update_success', ['entity' => 'Profile']));

        return redirect()->route('canvas.admin.profile.index');
    }
}
