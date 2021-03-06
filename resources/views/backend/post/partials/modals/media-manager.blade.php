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
        var mde = window.simplemde;
        var file = $(".images-content__item.selected").eq(0).text().trim();
        var output = '[' + file + '](' + file + ')';

        output = '!' + output;

        mde.codemirror.replaceSelection(output);
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
