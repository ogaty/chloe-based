@extends('backend.layout')

@section('title')
    <title>{{ \App\Models\Settings::blogTitle() }} | Media</title>
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
                            <li class="active">Media</li>                                                                                   
                        </ol>
                        <ul class="actions">
                            <li class="dropdown">
                                <a href="" data-toggle="dropdown">
                                    <i class="zmdi zmdi-more-vert"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a href="{!! route('admin.upload') !!}"><i class="zmdi zmdi-refresh-alt pd-r-5"></i> Refresh Media Library</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <h2>Media Library
                            <small>
                                Drag and drop files onto this window to upload. Double-click a folder name to see its
                                contents.
                            </small>
                        </h2>
                    </div>

                    <div class="images-toolbar">
                        <span>Upload</span>
                        <span>Add Folder</span>
                        <span>Refresh</span>
                        <span>Move</span>
                        <span>Delete</span>
                        <span>Rename</span>
                    </div>
		    <div id="images-content">
                    </div>

                </div>
            </div>
        </section>
    </section>
@stop

@section('unique-js')
<script>
$(function() {
    $.ajax({
        url: '/adm/upload/ls?path=public',
        dataType: 'json',
        success: function(data) {
            console.log(data);
	    $("#images-content").html("");
	    if (data.files.length > 0) {
                for (var i = 0; i < data.files.length; i++) {
                    $("#images-content").append(data.files[i].name);
                }
	    } else {
                $("#images-content").html('<h4>This folder is empty.</h4><p>Drag and drop files onto this window to upload files.</p></div>');
	    }
        }
    });
});
</script>
@stop                                                                                                                                       

