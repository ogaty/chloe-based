<script type="text/javascript">
    $(function(){
            $("#posts").DataTable({
              "rowCallback": function( row, data, dataIndex ) {
                if ( data[3] == "Published" ) {
                    $(row).find("td").eq(3).css( "color", "#ff0000" );
                }
            },
    }); 
    });
</script>
