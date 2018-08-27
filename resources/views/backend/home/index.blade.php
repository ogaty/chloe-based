@extends('backend.layout')

@section('title')
    <title>{{ \App\Models\Settings::blogTitle() }} | Home</title>
@stop

@section('content')
    <section id="main">
        @include('backend.shared.partials.sidebar-navigation')
        <section id="content">
            <div class="container">
                <div class="card">
                    <div class="card__header">
                        <h2>Welcome!
                            <small>Here are some helpful links we've gathered to get you started:
                            </small>
                        </h2>
                    </div>
                    <div class="card__body">
                    </div>
                </div>
                <div class="row">
                    @if(\App\Models\User::isAdmin(Auth::guard()->user()->role))
                        <div class="col-sm-6 col-md-6">
                            @include('backend.home.cards-at-a-glance')
                        </div>
                    @endif
                    <div class="col-sm-6 col-md-6">
                        @include('backend.home.cards-quick-draft')
                    </div>
                    <div class="col-sm-6 col-md-6">
                        @include('backend.home.cards-recent-posts')
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
