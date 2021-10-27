
$("body").on("click touchstart","#btnGuardar",function(e){
    e.preventDefault();
    var idEmpresa=$(this).attr("idEmpresa");
    var mes=$(this).attr("mes");
    // alert(idEmpresa);
    // alert(mes);

          Swal.fire({
          title: '¿Está seguro?',
          text: 'Está a punto de hacer el cierre de mes, no podrá eliminar o modificar comprobantes contables!',
          icon: 'warning', 
          showCancelButton: true,
          showLoaderOnConfirm: true,
          confirmButtonText: `Si, Guardar!`,
          cancelButtonText:'Cancelar',
          preConfirm: function(result) {
          return new Promise(function(resolve) {
            // var formu = document.getElementById("frmGuardar");
            // var data = new FormData(formu);
            $.ajax({
            url:URL+"functions/comprobantes/cierremes.php", 
            type:"POST", 
            data: {"idEmpresa":idEmpresa,"mes":mes},
            dataType: "json",
            }).done(function(msg){  
              if(msg.msg){
                Swal.fire(
                  {
                  icon: 'success',
                  title: "Mes cerrado!",
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

$('[data-toggle="tooltip"]').tooltip();