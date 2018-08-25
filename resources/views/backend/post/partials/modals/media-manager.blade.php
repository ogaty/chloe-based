<div class="post-media-modal">
    <div class="chloe-media-manager">
        @include('backend.shared.components.media-manager')
        <div>
            <ul>
                <li>aaa.png</li>
            </ul>
        </div>
        <button type="button" onclick="insertAndClose()">Select</button>
    </div>
</div>

<script>
function insertAndClose() {
    $(".post-media-modal").removeClass("visible");
}
</script>
