<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    //
    public function index() {

        return view('frontend.blogs.index');
    }
}
