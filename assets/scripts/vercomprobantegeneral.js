// var empresa=document.getElementById('nombreEmpresa').value;
// var logo=document.getElementById('logoEmpresa').value;
// var nit=document.getElementById('nitEmpresa').value;
// var email=document.getElementById('emailEmpresa').value;
// var telefono=document.getElementById('telefonoEmpresa').value;
// var url=document.getElementById('url').value;

// var numero=document.getElementById('numero').value;
// var fecha=document.getElementById('fecha').value;

// var tipo=document.getElementById('tipo').value;
// var comprobante=document.getElementById('comprobante').value;
$(document).ready(function() {
    var table= $('#tableComprobante').DataTable( {
        paging: false,
      ordering: false,
      
      dom: 'Blfrtip',
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
            title: 'COMPROBANTE',
            filename: 'COMPOBANTE',
            text:'<i class="fas fa-file-excel" style="color: #fff;font-size: 26px;"></i>',
            titleAttr: 'EXCEL',
            exportOptions: { orthogonal: 'export' }
            },
            // {
            // extend: 'csvHtml5',
            // text: '<i class="fas fa-file-csv" style="color: #fff;font-size: 26px;"></i>',
            // titleAttr: 'CSV'
            
            // },
            // {
            // extend: 'pdfHtml5',
            // text: '<i class="far fa-file-pdf" style="color: #fff;font-size: 26px;"></i>',
            // // messageTop:'<br><div>'+'nit: '+nit+'</div>'+'<div>  email: '+email+'</div><div>   telefono: '+telefono+'</div>',
            // // messageTop:'nit: '+nit+'  email: '+email+'   telefono: '+telefono,
            // // title: '<table class="table"><thead style="text-aling:left;"><tr style="text-aling:left;"><th rowspan="2"><img src="'+url+logo+'" width="60" height="60"></th><th>'+empresa+'</th><th>No. '+tipo+'-'+comprobante+'-'+numero+'</th></tr><tr><th>Nit: '+nit+'</th><th>fecha: '+fecha+'</th></tr></thead></table>',
            // title:empresa,
            // titleAttr: 'PDF',
            // customize: function(doc) {
            //     doc.pageMargins = [ 10, 10, 10, 10 ]
            // },
            
            // },
            // {
            // extend: 'print',
            // text: '<i class="fas fa-print" style="color: #fff;font-size: 26px;"></i>',
            // autoPrint: true,
            // // messageTop:'<br><div>'+'nit: '+nit+'</div>'+'<div>  email: '+email+'</div><div>   telefono: '+telefono+'</div>',
            // title: '<table class="table"><thead style="text-aling:left;"><tr style="text-aling:left;"><th rowspan="2"><img src="'+url+logo+'" width="60" height="60"></th><th>'+empresa+'</th><th>No. '+tipo+'-'+comprobante+'-'+numero+'</th></tr><tr><th>Nit: '+nit+'</th><th>fecha: '+fecha+'</th></tr></thead></table>',
            // titleAttr: 'IMPRIMIR'
            // }
            
        ]
    } );
    // $('#tableComprobante thead tr').clone(true).appendTo( '#tableComprobante thead' );

    // $('#tableComprobante thead tr:eq(1) th').each( function (i) {
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
} );

$('[data-toggle="tooltip"]').tooltip();





// var table = $('#tableEnterprise').DataTable({
//       // orderCellsTop: true,
//       //  fixedHeader: true,
      
//         buttons: [

//             {
//             extend: 'copyHtml5',
//             text: '<i class="far fa-copy" style="color: #fff;font-size: 26px;"></i>',
//             className: 'botoncopiar',
//             titleAttr: 'COPIAR'
//             },
//             {
//             extend: 'excel',
//             footer: true,
//             title: 'BALANCE COMPROBACION',
//             filename: 'BALANCE COMPROBACION',
//             text:'<i class="fas fa-file-excel" style="color: #fff;font-size: 26px;"></i>',
//             titleAttr: 'EXCEL'
//             },
//             {
//             extend: 'csvHtml5',
//             text: '<i class="fas fa-file-csv" style="color: #fff;font-size: 26px;"></i>',
//             titleAttr: 'CSV'
            
//             },
//             {
//             extend: 'pdf',
            
//             pageSize: 'A4',
//             text: '<i class="far fa-file-pdf" style="color: #fff;font-size: 26px;"></i>',
            
//             titleAttr: 'PDF',

//             // title:'Juriscon--           '+empresa+'             '+hoy+'\n Nit: '+nit+'-'+digitoVerificador+'\n ESTADO SITUACION FINANCIERA - '+tipo+'\n DESDE:  '+desde+' HASTA: '+hasta,  
          
//                 },
//             {
//             extend: 'print',
//             customize: function ( win ) {
//                     $(win.document.body).find( '.derecha' ).css( 'text-align', 'right' );
//                 },
//             text: '<i class="fas fa-print" style="color: #fff;font-size: 26px;"></i>',
//             autoPrint: true,
//             titleAttr: 'IMPRIMIR',
//             // title:'<table class="table"><thead><tr><th style="float:left;">Juriscon</th><th ><img src="'+url+logo+'" width="60" height="60">    '+empresa+'</th><th></th><th>'+hoy+'</th></tr><tr><th> </th><th>Nit: '+nit+'-'+digitoVerificador+'</th><th> </th><th> </th></tr> <tr><th></th><th >BALANCE DE COMPROBACION - '+tipo+'</th><th> </th></tr><tr><th></th><th >DESDE:  '+desde+' HASTA: '+hasta+'</th><th> </th></tr></thead<tbody><tr></tr></tbody></table>',

            

//             }
            
//         ]
        
//     });

    //Creamos una fila en el head de la tabla y lo clonamos para cada columna
