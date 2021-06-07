$(document).ready(function() {
    $('#tableMovimientoGeneral').DataTable( {
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
            title: 'MOVIMIENTO GENERAL CUENTAS',
            filename: 'Movimiento_general_cuentas',
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
            text: '<i class="far fa-file-pdf" style="color: #fff;font-size: 26px;"></i>',
            messageTop:'Terceros',
            titleAttr: 'PDF'
            
            },
            {
            extend: 'print',
            text: '<i class="fas fa-print" style="color: #fff;font-size: 26px;"></i>',
            autoPrint: true,
            titleAttr: 'IMPRIMIR'
            }
            
        ]
    } );
} );

$('[data-toggle="tooltip"]').tooltip();