// $(document).ready(function(e){

// 	dataTable("#tableFacturas"); 

// })

$(document).ready(function(){

    var table = $('#tableFacturas').DataTable({
      orderCellsTop: true,
       fixedHeader: true,
      // dom: 'Bfrtip',
        
    });

    $('#tableFacturas thead tr').clone(true).appendTo( '#tableFacturas thead' );

    $('#tableFacturas thead tr:eq(1) th').each( function (i) {
        var title = $(this).text(); //es el nombre de la columna
        $(this).html( '<input type="text"  class="form-control" style="heigth:25%;" />' );
 
        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );   
});

$('[data-toggle="tooltip"]').tooltip();