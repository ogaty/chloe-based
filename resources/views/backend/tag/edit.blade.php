@extends('backend.layout')

@section('title')
    <title>{{ \App\Models\Settings::blogTitle() }} | Edit Tag</title>
@stop

@section('content')
    <section id="main">
        @include('backend.shared.partials.sidebar-navigation')
        <section id="content">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <ol class="breadcrumb">
                            <li><a href="{!! route('admin.home') !!}">Home</a></li>
                            <li><a href="{!! route('admin.tag.index') !!}">Tags</a></li>
                            <li class="active">Edit Tag</li>
                        </ol>
                        @include('backend.shared.partials.errors')
                        @include('backend.shared.partials.success')
                        <h2>
                            Edit <em>{{ $data['title'] }}</em>
                            <small>
                                @if(isset($data['updated_at']))
                                    Last edited on {{$data['updated_at']->format('M d, Y') }} at {{ $data['updated_at']->format('g:i A') }}
                                @else
                                    Last edited on {{ $data['created_at']->format('M d, Y') }} at {{ $data['created_at']->format('g:i A') }}
                                @endif
                            </small>
                        </h2>

                    </div>
                    <div class="card-body card-padding">
                        <form class="keyboard-save" role="form" method="POST" id="tagUpdate" action="{!! route('admin.tag.update', $data['id']) !!}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="id" value="{{ $data['id'] }}">

                            @include('backend.tag.partials.form')

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-icon-text">
                                    <i class="zmdi zmdi-floppy"></i> Save
                                </button>&nbsp;
                                <button type="button" class="btn btn-danger btn-icon-text" data-toggle="modal" data-target="#modal-delete">
                                    <i class="zmdi zmdi-delete"></i> Delete
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </section>
    @include('backend.tag.partials.modals.delete')
@stop

@section('unique-js')
    @if(Session::get('_update-tag'))
        {{ \Session::forget('_update-tag') }}
    @endif
@stop
