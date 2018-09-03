<div class="images-toolbar">
    <ul class="images-toolbar--container clearfix">
        <li class="images-toolbar--button">
            <button id="upload-image" data-bind="click: uploadImage">Upload</button>
        </li>
        <li class="images-toolbar--button">
            <button id="refresh" data-bind="click: refresh">Refresh</button>
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
<div id="confirm-delete-modal" class="upload-submodal">
    <div class="modal-form">
        <label>Are you sure you want to delete the following item?</label>
        <button onclick="deleteItem()">Delete</button>
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
        refresh : function() {
            reRender(folder);
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
                if (data.files.length > 0) {
                    for (var i = 0; i < data.files.length; i++) {
                        self.imagesList.push({"name": data.files[i].fullPath, "fullpath": data.files[i].fullPath});
                    }
                } else {
                    if (data.files.length == 0) {
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
        $.ajax({
            url: '/adm/upload/uploadfiles',
            type: 'post',
            data: formData,
            processData: false,
            contentType: false
        }).done(function() {
            MediaManager.imageMessage('<p class="success">upload success.</p>');
            MediaManager.closeModal();
            MediaManager.reRender({name:'/', path:'/'});
        });
    });

    $("#rename").on('click', function() {
        $("#rename-item-modal").addClass("visible");
    });
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
