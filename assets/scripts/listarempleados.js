$(document).ready(function(e){
	dataTable("#tableEmpleados"); 
})


$("body").on("click touchstart","#btnEliminar",function(e){
    e.preventDefault();
    var idEliminar=$(this).attr('value');

        Swal.fire({
        title: '¿Está seguro?',
        text: 'Está a punto de eliminar este empleado!',
        icon: 'warning', 
        showCancelButton: true,
        showLoaderOnConfirm: true,
        confirmButtonText: `Si, Eliminar!`,
        cancelButtonText:'Cancelar',
        preConfirm: function(result) {
          return new Promise(function(resolve) {
            $.ajax({
            url:URL+"functions/nomina/eliminarempleado.php", 
            type:"POST", 
            data: {"idEliminar":idEliminar},
            dataType: "json",
            }).done(function(msg){  
              if(msg.msg){
                Swal.fire(
                 {icon: 'success',
                  title: 'Empleado eliminado!',
                  text: 'con exito',
                  closeOnConfirm: true,
                }
                ).then((result) => {
                 location.reload(); 
                })
              }else{
                 Swal.fire(
                  'Algo ha salido mal!',
                  'Verifique su conexión a internet',
                  'error'
                )
              }
          });
          });
        }
      })
  })