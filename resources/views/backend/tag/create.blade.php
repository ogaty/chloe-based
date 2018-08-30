@extends('backend.layout')

@section('title')
    <title>{{ \App\Models\Settings::blogTitle() }} | New Tag</title>
@stop

@section('content')
    <section id="main">
        @include('backend.shared.partials.sidebar-navigation')
        <section id="content">
            <div class="container">
                <div class="card">
                    <div class="card__header">
                        <ol class="breadcrumb">
                            <li class="breadcrumb__parent"><a href="{!! route('admin.home') !!}">Home</a></li>
                            <li class="breadcrumb__parent"><a href="{!! route('admin.tag.index') !!}">Tags</a></li>
                            <li class="breadcrumb__active">New Tag</li>
                        </ol>
                        @include('backend.shared.partials.errors')
                        @include('backend.shared.partials.success')
                        <h2>Create a New Tag</h2>
                    </div>
                    <div class="card__body card-padding">
                        <form class="keyboard-save" role="form" method="POST" id="tagUpdate" action="{!! route('admin.tag.index') !!}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            @include('backend.tag.partials.form')

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-icon-text"><i class="zmdi zmdi-floppy"></i> Save</button>
                                &nbsp;
                                <a href="{!! route('admin.tag.index') !!}"><button type="button" class="btn btn-link">Cancel</button></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </section>
@stop

@section('unique-js')
@stop
