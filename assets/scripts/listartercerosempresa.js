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



$("body").on("click",".eliminar",function(e){

  e.preventDefault();
  var idEliminar=$(this).attr('value');
  var idEmpresa=$("#idEmpresa").val();
  
        Swal.fire({
        title: '¿Está seguro?',
        text: 'Está a punto de eliminar este tercero!',
        icon: 'warning', 
        showCancelButton: true,
        showLoaderOnConfirm: true,
        confirmButtonText: `Si, Eliminar!`,
        cancelButtonText:'Cancelar',
        preConfirm: function(result) {
          return new Promise(function(resolve) {
            // var formu = document.getElementById("frmEliminar");
            // var data = new FormData(formu);
            $.ajax({
            url:URL+"functions/terceros/eliminartercero.php", 
            type:"POST", 
            data:  {"idEliminar":idEliminar,"idEmpresa":idEmpresa},
            dataType: "json"
            }).done(function(msg){  
              if(msg.msg){
                Swal.fire(
                 {icon: 'success',
                  title: 'Tercero eliminada!',
                  text: 'con exito',
                  closeOnConfirm: true,
                }
                ).then((result) => {
                 location.reload(); 
                })
              }else{
                 Swal.fire(
                  'No se pudo eliminar el tercero!',
                  'porque tiene movimiento',
                  'error'
                ).then((result) => {
                })
              }
          });
          });
        }
      })
})