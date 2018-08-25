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

                    @include('backend.shared.components.media-manager')

                </div>
            </div>
        </section>
    </section>
@stop

@section('unique-js')
<script>
var folder = "/";
$(function() {
    reRender('/');
    
    $("#image-uploader").on('change', function() {
        var form = $('#upload-form').get()[0];
        var formData = new FormData( form );
	formData.append('folder', folder);
        $.ajax({
            url: '/adm/upload/uploadfiles',
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
	reRender(folder);
    });
    $("#move").on('click', function() {
        $.ajax({
            url: '/adm/upload/alldirectories',
            dataType: 'json'
        }).done(function(data) {
	    for (var i = 0; i < data.length; i++) {
$("#all-directories").append("<option value=\"" + data[i].fullPath + "\">" + data[i].name + "</option>");
	    }
        });
        $("#move-item-modal").addClass("visible");
    });
    $("#rename").on('click', function() {
        $("#rename-item-modal").addClass("visible");
    });
    $("#delete").on('click', function() {
        $("#confirm-delete-modal").addClass("visible");
    });
});
function reRender(path) {
    folder = path;
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
                    $("#images-content__list").append('<li class="images-content__item"><input type="checkbox" class="images-content__check" data-fullpath="'+data.subFolders[i].fullPath+'"><a href="javascript:void(0)" onclick="reRender(\''+data.subFolders[i].fullPath+'\')">'+data.subFolders[i].name+'</a></li>');
                }
            }
            if (data.files.length > 0) {
                for (var i = 0; i < data.files.length; i++) {
                    $("#images-content__list").append('<li class="images-content__item"><input type="checkbox" class="images-content__check" data-fullpath="'+data.files[i].fullPath+'"><a href="javascript:void(0)">'+data.files[i].name+'</a></li>');
                }
            } else {
                if (data.subFolders.length == 0) {
                    $("#images-content__list").html('<h4>This folder is empty.</h4><p>Drag and drop files onto this window to upload files.</p></div>');
                }
            }
    });
}
function createDirectory() {
    $.ajax({
        url: '/adm/upload/createfolder?folder=' + folder + '&new_folder=' + $("#newDir").val(),
        dataType: 'json'
    }).done(function(data) {
	if (data.success.length > 0) {
            console.log(data.success);
	}
        closeModal();
	reRender(folder);
    }).fail(function(req, stat, err) {
	console.log(req.status);
	console.log(stat);
	console.log(err);
    });
}
function deleteItem() {
    $.ajax({
        url: '/adm/upload/deleteItem?folder=' + folder,
        dataType: 'json',
        type: 'post',
	data: {'_token': '{{csrf_token()}}', 'path': $(".images-content__check:checked").data("fullpath")}
    }).done(function(data) {
	if (data.success.length > 0) {
            console.log(data.success);
	}
        closeModal();
	reRender(folder);
    }).fail(function(req, stat, err) {
	console.log(req.status);
	console.log(stat);
	console.log(err);
    });
}
function moveItem() {
    $.ajax({
        url: '/adm/upload/moveitem',
        dataType: 'json',
        type: 'post',
        data: {'_token': '{{csrf_token()}}', 'from': $(".images-content__check:checked").data("fullpath"),
        'to': $("#all-directories").val()}
    }).done(function(data) {
	if (data.success.length > 0) {
            console.log(data.success);
	}
        closeModal();
	reRender(folder);
    }).fail(function(req, stat, err) {
	console.log(req.status);
	console.log(stat);
	console.log(err);
    });
}
function renameItem() {
    $.ajax({
        url: '/adm/upload/renameitem',
        dataType: 'json',
        type: 'post',
        data: {'_token': '{{csrf_token()}}', 'name': $("#newName").val()}
    }).done(function(data) {
        if (data.success.length > 0) {
            console.log(data.success);
        }
        closeModal();
        reRender(folder);
    }).fail(function(req, stat, err) {
        console.log(req.status);
        console.log(stat);
        console.log(err);
    });
}
function closeModal() {
    $("body").find(".modal").removeClass("visible");
}
</script>
@stop                                                                                                                                       

