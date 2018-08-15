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
                        <ul class="images-toolbar--container">
                            <li class="images-toolbar--button">Upload</li>
                            <li class="images-toolbar--button">Add Folder</li>
                            <li class="images-toolbar--button">Refresh</li>
                            <li class="images-toolbar--button">Move</li>
                            <li class="images-toolbar--button">Delete</li>
                            <li class="images-toolbar--button">Rename</li>
                        </ul>
                    </div>
                    <div id="images-content">
                        <div id="images-content__list">
                        </div>
                        <div id="preview-sidebar">
                        </div>
                    </div>
                    <div id="create-directory-modal" class="modal" style="display:none;">
                        <input type="text">
                        <button>Apply</button>
                        <button>Cancel</button>
                    </div>
                    <div id="confirm-delete-modal" class="modal" style="display:none;">
                        <label>Are you sure you want to delete the following item?</label>
                        <button>Delete</button>
                        <button>Cancel</button>
                    </div>
                    <div id="move-item-modal" class="modal" style="display:none;">
                        <option>
                            <select>/</select>
                        </option>
                        <button>Apply</button>
                        <button>Cancel</button>
                    </div>
                    <div id="rename-item-modal" class="modal" style="display:none;">
                        <input type="text">
                        <button>Apply</button>
                        <button>Cancel</button>
                    </div>

                </div>
            </div>
        </section>
    </section>
@stop

@section('unique-js')
<script>
$(function() {
    reRender('/');
});
function reRender(path) {
    $.ajax({
        url: '/adm/upload/ls?path=' + path,
        dataType: 'json',
        success: function(data) {
            console.log(data);
            $("#images-content__list").html("");
            console.log(data.breadCrumbs);
            if (data.subFolders.length > 0) {
                for (var i = 0; i < data.subFolders.length; i++) {
                    $("#images-content__list").append('<li><a href="javascript:void(0)" onclick="reRender(\''+data.subFolders[i].fullPath+'\')">'+data.subFolders[i].name+'</a></li>');
                }
            }
            if (data.files.length > 0) {
                for (var i = 0; i < data.files.length; i++) {
                    $("#images-content__list").append('<li>'+data.files[i].name+'</li>');
                }
            } else {
                $("#images-content__list").html('<h4>This folder is empty.</h4><p>Drag and drop files onto this window to upload files.</p></div>');
            }
        }
    });
}
function closeModal() {
    $("body").find(".modal").removeClass("visible");
}
</script>
@stop                                                                                                                                       

