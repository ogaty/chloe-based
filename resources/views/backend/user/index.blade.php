@extends('backend.layout')

@section('title')
    <title>{{ \App\Models\Settings::blogTitle() }} | Users</title>
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
                            <li class="breadcrumb__active">Users</li>
                        </ol>
                        <ul class="actions">
                            <li class="dropdown">
                                <a href="" data-toggle="dropdown">
                                    <i class="zmdi zmdi-more-vert"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a href="{!! route('admin.user.index') !!}"><i class="zmdi zmdi-refresh-alt pd-r-5"></i> Refresh Users</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        @include('backend.shared.partials.errors')
                        @include('backend.shared.partials.success')
                        <h2>Users&nbsp;
                            <a href="{!! route('admin.user.create') !!}" id="create-user"><i class="zmdi zmdi-plus-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Create a new user"></i></a>

                            <small>This page provides a comprehensive overview of all the current users. Click the <span class="zmdi zmdi-edit text-primary"></span> icon next to each user to update their site access or remove them from the system.</small>
                        </h2>
                    </div>

                    <div class="table-responsive">
                        <table id="users" class="table table-condensed table-vmiddle">
                            <thead>
                            <tr>
                                <th data-column-id="id" data-type="numeric" data-order="asc">ID</th>
                                <th data-column-id="display_name">Name</th>
                                <th data-column-id="email">Email</th>
                                <th data-column-id="role">Role</th>
                                <th data-column-id="posts">Posts</th>
                                <th data-column-id="commands" data-formatter="commands" data-sortable="false">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $user)
                                <tr style="text-align: center;">
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->display_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->isAdmin($user->role) ? 'Administrator' : 'User' }}</td>
                                    <td>{{ $user->postCount($user->id) }}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </section>
@stop

@section('unique-js')
    @include('backend.user.partials.datatable')

    @if(Session::get('_new-user'))
        @include('backend.shared.notifications.notify', ['section' => '_new-user'])
        {{ \Session::forget('_new-user') }}
    @endif

    @if(Session::get('_delete-user'))
        @include('backend.shared.notifications.notify', ['section' => '_delete-user'])
        {{ \Session::forget('_delete-user') }}
    @endif
@stop
