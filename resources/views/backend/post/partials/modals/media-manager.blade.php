<div class="post-media-modal">
    <div class="chloe-media-manager">
        @include('backend.shared.components.media-manager')
        <div class="result-area">
            <ul class="result-area__item">
            </ul>
        </div>
        <button type="button" onclick="insertAndClose()">Select</button>
        <button type="button" onclick="Close()">Cancel</button>
    </div>
</div>

<script>
function insertAndClose() {
    if (post) {
        var mde = this.simpleMde;
        var output = '[' + file.name + '](' + file.relativePath + ')';

    if (this.isImage(file)) {
        output = '!' + output;
    }

    mde.replaceSelection(output);
    }
    else {
    $("#page_image").val( $(".images-content__item.selected a").data("fullpath") );
    }
    $(".post-media-modal").removeClass("visible");
}
function Close() {
    $(".post-media-modal").removeClass("visible");
}
</script>
