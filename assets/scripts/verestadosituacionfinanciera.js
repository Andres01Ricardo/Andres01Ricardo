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
var tipo=document.getElementById('tipo').value;
var desde=document.getElementById('desde').value;
var hasta=document.getElementById('hasta').value;

$(document).ready(function(){

    var table = $('#tablecomprobacion').DataTable({
      // orderCellsTop: true,
      //  fixedHeader: true,
      paging: false,
      ordering: false,
      dom: 'Bfrtip',
        buttons: [

            {
            extend: 'copyHtml5',
            text: '<i class="far fa-copy" style="color: #fff;font-size: 26px;"></i>',
            className: 'botoncopiar',
            titleAttr: 'COPIAR'
            },
            {
            extend: 'excel',
            footer: true,
            title: 'ESTADO SITUACION FINANCIERA',
            filename: 'ESTADO SITUACION FINANCIERA',
            text:'<i class="fas fa-file-excel" style="color: #fff;font-size: 26px;"></i>',
            titleAttr: 'EXCEL'
            },
            {
            extend: 'csvHtml5',
            text: '<i class="fas fa-file-csv" style="color: #fff;font-size: 26px;"></i>',
            titleAttr: 'CSV'
            
            },
            {
            extend: 'pdf',
            customize: function(doc) {
                doc.pageMargins = [ 10, 10, 15, 10 ]
            },
            text: '<i class="far fa-file-pdf" style="color: #fff;font-size: 24px;"></i>',
            pageSize: 'A3',
            
            
            titleAttr: 'PDF',

            title:'AS-Smartbuss           '+empresa+'             '+hoy+'\n Nit: '+nit+'-'+digitoVerificador+'\n ESTADO SITUACION FINANCIERA - '+tipo+'\n DESDE:  '+desde+' HASTA: '+hasta,  
          
                },
            {
            extend: 'print',
            customize: function ( win ) {
                    $(win.document.body).find( '.derecha' ).css( 'text-align', 'right' );
                     $(win.document.body).find('td').css('font-size', '18pt');
                     $(win.document.body).find('th').css('font-size', '22pt');
                },
            text: '<i class="fas fa-print" style="color: #fff;font-size: 24px;"></i>',
            autoPrint: true,
            titleAttr: 'IMPRIMIR',
            title:'<table style="font-size: 20px;font-family: "Arial";width: 100%;" class="table"><thead><tr><th style="float:left;">AS-Smartbuss</th><th ><img src="'+url+logo+'" width="60" height="60">    '+empresa+'</th><th></th><th>'+hoy+'</th></tr><tr><th> </th><th>Nit: '+nit+'-'+digitoVerificador+'</th><th> </th><th> </th></tr> <tr><th></th><th >ESTADO SITUACION FINANCIERA - '+tipo+'</th><th> </th></tr><tr><th></th><th >DESDE:  '+desde+' HASTA: '+hasta+'</th><th> </th></tr></thead></table>',

            

            }
            
        ]
        
    });

    //Creamos una fila en el head de la tabla y lo clonamos para cada columna
    // $('#tablecomprobacion thead tr').clone(true).appendTo( '#tablecomprobacion thead' );

    // $('#tablecomprobacion thead tr:eq(1) th').each( function (i) {
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

$('[data-toggle="tooltip"]').tooltip();