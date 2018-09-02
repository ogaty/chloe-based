<div class="images-toolbar">
    <ul class="images-toolbar--container clearfix">
        <li class="images-toolbar--button">
            <button id="upload-image" data-bind="click: uploadImage">Upload</button>
        </li>
        <li class="images-toolbar--button">
            <button id="add-directory" data-bind="click: addDirectory">Add Directory</button>
        </li>
        <li class="images-toolbar--button">
            <button id="refresh" data-bind="click: refresh">Refresh</button>
        </li>
        <li class="images-toolbar--button">
            <button id="move" data-bind="click: move">Move</button>
        </li>
        <li class="images-toolbar--button">
            <button id="delete" data-bind="click: deleteItem">Delete</button>
        </li>
        <li class="images-toolbar--button">
            <button id="rename" data-bind="click: rename">Rename</button>
        </li>
    </ul>
</div>
<div id="images-content">
    <div data-bind="html: imageMessage">
    </div>
    <ul id="images-content__list" class="images-content__List" data-bind="foreach: imagesList">
        <li class="images-content__item">
            <a href="javascript:void(0)" class="images-content__file" data-bind="text: name, attr: {'data-fullpath': fullpath}"></a>
        </li>
    </ul>
<div>
</div>
    <div id="preview-sidebar">
    </div>
</div>
{{--modal start--}}
<div id="upload-modal" class="upload-submodal">
    <form id="upload-form" class="modal-form"> 
        <input type="file" name="file" id="image-uploader">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <button type="button" data-bind="click: closeModal">Close</button>
    </form>
</div>
<div id="create-directory-modal" class="upload-submodal">
    <div class="modal-form">
        <h3>Directory name</h3>
        <div>
            <input type="text" id="newDir">
        </div>
        <button data-bind="click: createDirectory">Apply</button>
        <button type="button" data-bind="click: closeModal">Cancel</button>
    </div>
</div>
<div id="confirm-delete-modal" class="upload-submodal">
    <div class="modal-form">
        <label>Are you sure you want to delete the following item?</label>
        <button onclick="deleteItem()">Delete</button>
        <button type="button" data-bind="click: closeModal">Cancel</button>
    </div>
</div>
<div id="move-item-modal" class="upload-submodal">
    <div class="modal-form">
        <div>
            <select id="all-directories"></select>
        </div>
        <button onclick="moveItem()">Apply</button>
        <button type="button" data-bind="click: closeModal">Cancel</button>
    </div>
</div>
<div id="rename-item-modal" class="upload-submodal">
    <div class="modal-form">
        <input type="text" id="newName">
        <button onclick="renameItem()">Apply</button>
        <button type="button" data-bind="click: closeModal">Cancel</button>
    </div>
</div>
{{--modal end--}}

<script>
$(function() {
    var folder = "/";

    var MediaManager = {
        imageMessage: ko.observable(),
        imagesList: ko.observableArray(),
        topPath: ko.observable(),
        uploadImage : function() {
            $("#upload-modal").addClass("visible");
        },
        addDirectory : function() {
            $("#create-directory-modal").addClass("visible");
        },
        refresh : function() {
            reRender(folder);
        },
        move : function() {
            console.log("clicked");
        },
        deleteItem : function() {
            $("#confirm-delete-modal").addClass("visible");
        },
        rename : function() {
            $("#rename-item-modal").addClass("visible");
        },
        closeModal : function() {
            $("body").find(".upload-submodal").removeClass("visible");
        },
	createDirectory : function() {
            var self = this;
    $.ajax({
        url: '/adm/upload/createfolder?folder=' + folder + '&new_folder=' + $("#newDir").val(),
        dataType: 'json'
    }).done(function(data) {
	if (data.success.length > 0) {
            console.log(data.success);
	}
        self.closeModal();
	self.reRender({name: folder, path: $("#newDir").val()});
    }).fail(function(req, stat, err) {
	console.log(req.status);
	console.log(stat);
	console.log(err);
    });
},
        reRender : function(obj) {
            folder = obj.path;
	    var self = MediaManager;
            $.ajax({
                url: '/adm/upload/ls?path=' + obj.path,
                dataType: 'json'
            }).done(function(data) {
                console.log("reRender");
                console.log(data);
                self.imageMessage("");
                self.imagesList.removeAll();
                if (data.subFolders.length > 0) {
                    for (var i = 0; i < data.subFolders.length; i++) {
                        self.imagesList.push({"name": data.subFolders[i].name, "fullpath": data.subFolders[i].fullPath});
                    }
                }
                if (data.files.length > 0) {
                    for (var i = 0; i < data.files.length; i++) {
                        self.imagesList.push({"name": data.files[i].name, "fullpath": data.files[i].fullPath});
                    }
                } else {
                    if (data.subFolders.length == 0) {
                        self.imageMessage('<h4>This folder is empty.</h4><p>Drag and drop files onto this window to upload files.</p></div>');
                    }
                }
                console.log("reRender end");
            });
	}
    }

    ko.applyBindings(MediaManager);

    MediaManager.reRender({name: '/', path: '/'});
    
    $("#images-content").on("click", ".images-content__item", function() {
	$(".images-content__item").removeClass("selected");
        $(this).addClass("selected");
    });


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
            MediaManager.imageMessage('<p class="success">upload success.</p>');
        });
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
    /*
    function reRender(path) {
    console.log("reRender2");

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
*/
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

});
</script>
