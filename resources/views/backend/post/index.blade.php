@extends('backend.layout')

@section('title')
    <title>{{ \App\Models\Settings::blogTitle() }} | Posts</title>
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
                            <li class="breadcrumb__active">Posts</li>
                        </ol>
                        <ul class="actions">
                            <li class="dropdown">
                                <a href="" data-toggle="dropdown">
                                    <i class="zmdi zmdi-more-vert"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a href="{!! route('admin.post.index') !!}"><i class="zmdi zmdi-refresh-alt pd-r-5"></i> Refresh Posts</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        @include('backend.shared.partials.errors')
                        @include('backend.shared.partials.success')
                        <h2>Posts&nbsp;
                            <a href="{!! route('admin.post.create') !!}" id="create-post"><i class="zmdi zmdi-plus-circle" data-placement="bottom" title="" data-original-title="Create a new post"></i></a>

                            <small>This page provides a comprehensive overview of all your blog posts. Click the <span class="zmdi zmdi-edit text-primary"></span> icon next to each post to update its contents or the <span class="zmdi zmdi-search text-primary"></span> icon to see what it looks like to your readers.</small>
                        </h2>
                    </div>

                    <div class="table-responsive">
                        <table id="posts" class="table table-condensed table-vmiddle">
                            <thead>
                                <tr>
                                    <th data-column-id="id" data-type="numeric" data-order="desc">ID</th>
                                    <th data-column-id="title">Title</th>
                                    <th data-column-id="author">Author</th>
                                    <th data-column-id="published">Status</th>
                                    <th data-column-id="slug">Slug</th>
                                    <th data-column-id="date" data-type="date" data-formatter="humandate">Date</th>
                                    <th data-column-id="commands" data-formatter="commands" data-sortable="false">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $post)
                                    <tr>
                                        <td>{{ $post->id }}</td>
                                        <td>{{ $post->title }}</td>
                                        <td>{{ $post->getAuthor($post->user_id) }}</td>
                                        <td>{!! $post->is_published == 1 ? '<span style="color:#f00;">Published</span>' : 'Draft' !!}</td>
                                        <td>{{ $post->slug }}</td>
                                        @if($post->updated_at != $post->created_at)
                                            <td>{{ $post->updated_at->format('Y/m/d H:i') }}</td>
                                        @else
                                            <td>{{ $post->created_at->format('Y/m/d H:i') }}</td>
                                        @endif
                                        <td><a href="{!! route('admin.post.edit', $post->id) !!}"><ion-icon name="create"></ion-icon></a>
                                        <a href="{!! route('front.post', $post->slug) !!}"><ion-icon name="tv"></ion-icon></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="backend-paginate">
                        @if ($data->currentPage() > 1)
                            <li class="previous">
                <a href="{!! $data->url($data->currentPage() - 1) !!}">
                    <i class="fa fa-angle-left fa-lg"></i>
                    Previous
                </a>
                            </li>
        @endif
        @if ($data->hasMorePages())
                            <li class="next">
                <a href="{!! $data->nextPageUrl() !!}">
                    Next
                    <i class="fa fa-angle-right"></i>
                </a>
                            </li>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@stop

@section('unique-js')
    @if(Session::get('_delete-post'))
        @include('backend.shared.notifications.notify', ['section' => '_delete-post'])
        {{ \Session::forget('_delete-post') }}
    @endif
    @if(Session::get('_update-post'))
        @include('backend.shared.notifications.notify', ['section' => '_update-post'])
        {{ \Session::forget('_update-post') }}
    @endif
    @include('backend.post.partials.datatable')
@stop
