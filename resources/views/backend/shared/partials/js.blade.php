<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://unpkg.com/ionicons@4.2.2/dist/ionicons.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="/js/knockout-3.4.2.js"></script>

@if (Route::is('admin.post.create') || Route::is('admin.post.edit'))
<script src="/js/simplemde.js"></script>
@endif

<script type="text/javascript" src="/js/backend.js"></script>
<script>
    window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
    ]); ?>
</script>
