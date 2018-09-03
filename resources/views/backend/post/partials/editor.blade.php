

<script>
var simplemde = new SimpleMDE({
    element: $("#editor")[0],
    spellChecker: false,
    toolbar: [
        "bold", "italic", "heading", "|",
        "quote", "unordered-list", "ordered-list", "|",
        'link', 'image',
        {
            name: 'insertImage',
            action: function (editor) {
        window.post = true;
                                    openFromPageImage();
                            }.bind(this),
                            className: "fa fa-picture-o",
                            title: "Insert Media Browser Image"
                        },
                        "|",
                        "preview", "side-by-side", "fullscreen", "|"
                    ],
    renderingConfig: {
        singleLineBreaks: false
    }
});
</script>
