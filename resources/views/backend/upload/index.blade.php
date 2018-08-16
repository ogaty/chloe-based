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
                            <li class="images-toolbar--button"><button id="upload-image">Upload</button></li>
                            <li class="images-toolbar--button"><button id="add-folder">Add Folder</button></li>
                            <li class="images-toolbar--button"><button id="refresh">Refresh</button></li>
                            <li class="images-toolbar--button"><button id="move">Move</button></li>
                            <li class="images-toolbar--button"><button id="delete">Delete</button></li>
                            <li class="images-toolbar--button"><button id="rename">Rename</button></li>
                        </ul>
                    </div>
                    <div id="images-breadCrumb" class="images-breadcrumb">
                    </div>
                    <div id="images-content">
                        <div id="images-content__list" class="images-content__list">
                        </div>
                        <div id="preview-sidebar">
                        </div>
                    </div>
                    <div id="upload-modal" class="modal" style="display:none;">
                        <form id="upload-form"> 
                            <input type="file" id="image-uploader">
                        </form>
                        <button>Close</button>
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
    
    $("#image-uploader").on('change', function() {
        var form = $('#upload-form').get()[0];
        var formData = new FormData( form );
        $.ajax({
            url: '/adm/upload/uploadFiles',
            type: 'post',
            data: formData,
            processData: false,
            contentType: false
        }).done(function() {
        });
    });

    $("#upload-image").on('click', function() {
        $("#upload-modal").addClass("visible");
    });
    $("#add-folder").on('click', function() {
        $("#create-directory-modal").addClass("visible");
    });
    $("#refresh").on('click', function() {
    });
    $("#move").on('click', function() {
        $("#move-item-modal").addClass("visible");
    });
    $("#rename").on('click', function() {
        $("#rename-item-modal").addClass("visible");
    });
    $("#remove").on('click', function() {
        $("#confirm-delete-modal").addClass("visible");
    });
});
function reRender(path) {
    $.ajax({
        url: '/adm/upload/ls?path=' + path,
        dataType: 'json'
    }).done(function(data) {
        console.log(data);
            $("#images-content__list").html("");
            console.log(data.breadCrumbs);
	    if (typeof data.breadCrumbs.name != undefined) {
                $("#images-breadCrumb").html("");
                $("#images-breadCrumb").append('<li class="images-breadcrumb__item"><a href="javascript:void(0)" onclick="reRender(\''+data.breadCrumbs.fullPath+'\')">'+data.breadCrumbs.name+'</a></li>');
	    }
            if (data.breadCrumbs.length > 0) {
                $("#images-breadCrumb").html("");
                for (var i = 0; i < data.breadCrumbs.length; i++) {
                    $("#images-breadCrumb").append('<li class="images-breadcrumb__item"><a href="javascript:void(0)" onclick="reRender(\''+data.breadCrumbs[i].fullPath+'\')">'+data.breadCrumbs[i].name+'</a></li>');
                }
            }
            if (data.subFolders.length > 0) {
                for (var i = 0; i < data.subFolders.length; i++) {
                    $("#images-content__list").append('<li class="images-content__item"><a href="javascript:void(0)" onclick="reRender(\''+data.subFolders[i].fullPath+'\')">'+data.subFolders[i].name+'</a></li>');
                }
            }
            if (data.files.length > 0) {
                for (var i = 0; i < data.files.length; i++) {
                    $("#images-content__list").append('<li class="images-content__item">'+data.files[i].name+'</li>');
                }
            } else {
                if (data.subFolders.length == 0) {
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

