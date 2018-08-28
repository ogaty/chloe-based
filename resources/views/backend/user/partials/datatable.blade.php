<div id="authUserId" data-field-message="{{ Auth::guard()->user()->id }}"></div>
<script type="text/javascript">
    $(function(){
        $("#users").DataTable({
              "rowCallback": function( row, data, dataIndex ) {
                if ( data[3] == "Administrator" ) {
                    $(row).find("td").eq(3).css( "color", "#ff0000" );
                }
            },
    });
    });
</script>
