@extends('backend.layout')

@section('title')
    <title>{{ \App\Models\Settings::blogTitle() }} | Edit Post</title>
@stop

@section('content')
    <section id="main">
        <div class="post-media-modal">
        </div>
        @include('backend.post.partials.modals.media-manager')
        @include('backend.shared.partials.sidebar-navigation')
        <section id="content">
            <div class="container">
                @include('backend.post.partials.form')
            </div>
        </section>
    </section>
    @include('backend.post.partials.modals.delete')
@stop

@section('unique-js')
    @include('backend.post.partials.editor')
    @if(Session::get('_update-post'))
        {{ \Session::forget('_update-post') }}
    @endif
    @if(Session::get('_new-post'))
        {{ \Session::forget('_new-post') }}
    @endif
@stop
