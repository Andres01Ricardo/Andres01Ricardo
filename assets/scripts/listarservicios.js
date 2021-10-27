// $(document).ready(function(e){
// 	dataTable("#tableProductos"); 
// })
var empresa=document.getElementById('empresa').value;
var logo=document.getElementById('logo').value;
var nit=document.getElementById('nitEmpresa').value;
var digitoVerificador=document.getElementById('digitoVerificador').value;
var fecha=new Date();
var dia=fecha.getDate();
var mes=fecha.getMonth()+1;
var anio=fecha.getFullYear();
var hoy=fecha.toLocaleDateString();
var url=document.getElementById('url').value;
// var tipo=document.getElementById('tipo').value;

$(document).ready(function(){

    var table = $('#tableProductos').DataTable({
      orderCellsTop: true,
       fixedHeader: true,
      dom: 'Bfrtip',
        buttons: [

      //       {
      //       extend: 'copyHtml5',
      //       text: '<i class="far fa-copy" style="color: #fff;font-size: 26px;"></i>',
      //       className: 'botoncopiar',
      //       titleAttr: 'COPIAR'
      //       },
      //       {
      //       extend: 'excel',
      //       footer: true,
      //       title: 'PLAN CUENTAS',
      //       filename: 'CUENTAS CONTABLES',
      //       text:'<i class="fas fa-file-excel" style="color: #fff;font-size: 26px;"></i>',
      //       titleAttr: 'EXCEL'
      //       },
      //       {
      //       extend: 'csvHtml5',
      //       text: '<i class="fas fa-file-csv" style="color: #fff;font-size: 26px;"></i>',
      //       titleAttr: 'CSV'
            
      //       },
            {
            extend: 'pdf',
            text: '<i class="far fa-file-pdf" style="color: #fff;font-size: 26px;"></i>',
            messageTop:'SERVICIOS',
            titleAttr: 'PDF'
            
            },
            {
            extend: 'print',
            text: '<i class="fas fa-print" style="color: #fff;font-size: 26px;"></i>',
            autoPrint: true,
            titleAttr: 'IMPRIMIR',
            // messageTop:'<br><div>'+'nit: '+nit+'</div>'+'<div>  email: '+email+'</div><div>   telefono: '+telefono+'</div>',
            // title: '<img src="'+url+logo+'" width="60" height="60">'+'   '+empresa
             title:'<table class="table"><thead><tr><th style="float:left;">SmartBuss</th><th ><img src="'+url+logo+'" width="60" height="60">    '+empresa+'</th><th></th><th>'+hoy+'</th></tr><tr><th> </th><th>Nit: '+nit+'-'+digitoVerificador+'</th><th> </th><th> </th></tr> <tr><th></th><th >SERVICIOS </th><th> </th></tr><tr><th></th><th > </th><th> </th></tr></thead></table>',
            // title: 'SERVICIOS'

            }
            
        ]
        
    });

    //Creamos una fila en el head de la tabla y lo clonamos para cada columna
    $('#tableProductos thead tr').clone(true).appendTo( '#tableProductos thead' );

    $('#tableProductos thead tr:eq(1) th').each( function (i) {
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