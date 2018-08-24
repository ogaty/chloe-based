

@include('backend.post.partials.modals.help')
<script src="/js/simplemde.js"></script>
<script>
var simplemde = new SimpleMDE({
    element: $("#editor")[0],
    spellChecker: false,
    renderingConfig: {
        singleLineBreaks: false
    }
});
</script>
