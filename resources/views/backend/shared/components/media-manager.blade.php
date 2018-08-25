{{--post側はcloseModalが必要--}}
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
<div id="images-breadCrumb" class="images-breadcrumb"></div>
<div id="images-content">
    <div id="images-content__list" class="images-content__list">
    </div>
    <div id="preview-sidebar">
    </div>
</div>
<div id="upload-modal" class="modal">
    <form id="upload-form" class="modal-form"> 
        <input type="file" name="file" id="image-uploader">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <button type="button" onclick="closeModal()">Close</button>
    </form>
</div>
<div id="create-directory-modal" class="modal">
    <div class="modal-form">
        <input type="text" id="newDir">
        <button onclick="createDirectory()">Apply</button>
        <button onclick="closeModal()">Cancel</button>
    </div>
</div>
<div id="confirm-delete-modal" class="modal">
    <div class="modal-form">
        <label>Are you sure you want to delete the following item?</label>
        <button onclick="deleteItem()">Delete</button>
        <button onclick="closeModal()">Cancel</button>
    </div>
</div>
<div id="move-item-modal" class="modal">
    <div class="modal-form">
        <div>
            <select id="all-directories"></select>
        </div>
        <button onclick="moveItem()">Apply</button>
        <button onclick="closeModal()">Cancel</button>
    </div>
</div>
<div id="rename-item-modal" class="modal">
    <div class="modal-form">
        <input type="text" id="newName">
        <button onclick="renameItem()">Apply</button>
        <button onclick="closeModal()">Cancel</button>
    </div>
</div>
