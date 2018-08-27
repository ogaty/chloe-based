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
                <div class="card-container">
                @if(\App\Models\User::isAdmin(Auth::guard()->user()->role))
                    @include('backend.home.cards-at-a-glance')
                @endif
                @include('backend.home.cards-quick-draft')
                @include('backend.home.cards-recent-posts')
                </div>
            </div>
        </section>
    </section>
@stop

@section('unique-js')
    @if(session()->get('_login'))
        @include('backend.shared.notifications.notify', ['section' => '_login'])
        {{ session()->forget('_login') }}
    @endif
    @include('backend.shared.components.slugify')
@stop
