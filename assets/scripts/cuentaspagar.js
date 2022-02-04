$( window ).on( "load", function() {

    var table = $('#tableEnterprise').DataTable({
      orderCellsTop: false,
       fixedHeader: true,
       ordering: false,
       columnDefs:[{
            targets: "_all",
            sortable: false
        }],
       
      dom: 'Bltip',
        buttons: [

            
            // {
            // extend: 'excel',
            // footer: true,
            // title: 'PLAN CUENTAS',
            // filename: 'CUENTAS CONTABLES',
            // text:'<i class="fas fa-file-excel" style="color: #fff;font-size: 26px;"></i>',
            // titleAttr: 'EXCEL'
            // },
            
            {
	            extend: 'pdf',
	            text: '<i class="far fa-file-pdf" style="color: #fff;font-size: 26px;"></i>',
	            title:'CUENTAS A PAGAR',
	            titleAttr: 'PDF',
	            exportOptions: {
	                columns: [ 0, 1, 2,3,4, 5 ]
	            }
            },
            {
	            extend: 'print',
	            text: '<i class="fas fa-print" style="color: #fff;font-size: 26px;"></i>',
	            autoPrint: true,
	            titleAttr: 'IMPRIMIR',
	            // messageTop:'<br><div>'+'nit: '+nit+'</div>'+'<div>  email: '+email+'</div><div>   telefono: '+telefono+'</div>',
	            // title: '<img src="'+url+logo+'" width="60" height="60">'+'   '+empresa
	            title:'CUENTAS A PAGAR',
	            exportOptions: {
	                columns: [ 0, 1, 2,3,4, 5 ]
	            }
            }
        ]
        
    });

    //Creamos una fila en el head de la tabla y lo clonamos para cada columna
    // $('#tableEnterprise thead tr').clone(true).appendTo( '#tableEnterprise thead' );

    // $('#tableEnterprise thead tr:eq(1) th').each( function (i) {
    //     var title = $(this).text(); //es el nombre de la columna
    //     $(this).html( '<input type="text"  class="form-control" style="heigth:25%;" />' );
 
    //     $( 'input', this ).on( 'keyup change', function () {
    //         if ( table.column(i).search() !== this.value ) {
    //             table
    //                 .column(i)
    //                 .search( this.value )
    //                 .draw();
    //         }
    //     } );
    // } );   
});