<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="/js/backend.js"></script>
<script>
    window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
    ]); ?>
</script>
