$(document).ready(function() {

  var inputIdTipoAuxilio=$("#inputIdTipoAuxilio").val();
  if (inputIdTipoAuxilio==3) {
    $("#divOtroAuxilio").css("display","block");
  }
  if (inputIdTipoAuxilio==2) {
    $("#divOtroAuxilio").css("display","none");
  }
})

$("body").on("change","#idAuxilioExtralegal",function(e){
  var idAuxilioExtralegal= $(this).val();
  if (idAuxilioExtralegal==3) {
    $("#divOtroAuxilio").css("display","block");
  }
  if (idAuxilioExtralegal==2) {
    $("#divOtroAuxilio").css("display","none");
  }
})


$("body").on("click","#btnGuardar",function(e){

    e.preventDefault();

      if(true === $("#frmGuardar").parsley().validate()){

          Swal.fire({

          title: 'Está seguro?',

          text: 'Está a punto de editar los datos de esta novedad!',

          icon: 'warning', 

          showCancelButton: true,

          showLoaderOnConfirm: true,

          confirmButtonText: `Si, Continuar!`,

          cancelButtonText:'Cancelar',

          preConfirm: function(result) {

          return new Promise(function(resolve) {

            var formu = document.getElementById("frmGuardar");

        

            var data = new FormData(formu);

            $.ajax({

            url:URL+"functions/nomina/editarnovedad.php", 

            type:"POST", 

            data: data,

            contentType:false, 

            processData:false, 

            dataType: "json",

            cache:false 

            }).done(function(msg){  

              if(msg.msg){

                Swal.fire(

                  {

                  icon: 'success',

                  title: "Información actualizada!",

                  text: 'con exito',

                  closeOnConfirm: true,

                }

                ).then((result) => {

                 window.history.back(); 

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

      }

  })

