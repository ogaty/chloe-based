@extends('backend.layout')

@section('title')
    <title>{{ \App\Models\Settings::blogTitle() }} | Home</title>
@stop

@section('content')
    <section id="main">
        @include('backend.shared.partials.sidebar-navigation')
        <section id="content">
            <div class="container">
                @if(\App\Models\User::isAdmin(Auth::guard()->user()->role))
                    @include('backend.home.sections.welcome')
                @endif
                <div class="row">
                    @if(\App\Models\User::isAdmin(Auth::guard()->user()->role))
                        <div class="col-sm-6 col-md-6">
                            @include('backend.home.sections.at-a-glance')
                        </div>
                    @endif
                    <div class="col-sm-6 col-md-6">
                        @include('backend.home.sections.quick-draft')
                    </div>
                    <div class="col-sm-6 col-md-6">
                        @include('backend.home.sections.recent-posts')
                    </div>
                    <div class="col-sm-6 col-md-6">
                    </div>
                </div>
            </div>
        </section>
    </section>
    @include('backend.home.partials.modals.update')
@stop

@section('unique-js')
    @if(session()->get('_login'))
        @include('backend.shared.notifications.notify', ['section' => '_login'])
        {{ session()->forget('_login') }}
    @endif
    @include('backend.shared.components.slugify')
@stop
