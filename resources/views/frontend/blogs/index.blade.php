@extends('frontend.layout')

@if (isset($tag->title))
    @section('title', \App\Models\Settings::blogTitle().' | '.$tag->title)
@else
    @section('title', \App\Models\Settings::blogTitle().' | Blog')
@endif
@section('og-title', \App\Models\Settings::blogTitle())
@section('twitter-title', \App\Models\Settings::blogTitle())
@section('og-description', \App\Models\Settings::blogDescription())
@section('twitter-description', \App\Models\Settings::blogDescription())

@section('content')
    <div class="site-body">    
    <div class="container">
        <div class="">
            <div class="posts">
                @include('frontend.shared.tag')
                @include('frontend.shared.posts')
                @include('frontend.shared.paginate-index')
            </div>
        </div>
    </div>
    </div>
@stop

@section('unique-js')
    <script src="/js/new-frontend.js" charset="utf-8"></script>
@endsection
