@extends('backend.layout')

@section('title')
    <title>{{ \App\Models\Settings::blogTitle() }} | New Post</title>
@stop

@section('content')
    <section id="main">
        @include('backend.shared.partials.sidebar-navigation')
        <section id="content">
            <div class="container">
                @include('backend.post.partials.form')
            </div>
        </section>
    </section>
@stop

@section('unique-js')
    @include('backend.post.partials.editor')
    @include('backend.shared.notifications.protip')
    @include('backend.shared.components.datetime-picker')
    @include('backend.shared.components.slugify')
@stop
