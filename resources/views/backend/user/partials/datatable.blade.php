<div id="authUserId" data-field-message="{{ Auth::guard()->user()->id }}"></div>
<script type="text/javascript">
    $(function(){
        $("#users").DataTable();
    });
</script>
