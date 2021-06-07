$("body").on("click","#aprobarlegalizacion",function(e){

    e.preventDefault();

      // if(true === $("#frmGuardar").parsley().validate()){

        var idProyecto=$("#idProyecto").val();
        

          Swal.fire({

          title: '¿Está seguro?',

          text: 'Está a punto de aprobar la legalizacion de este proyecto!',

          icon: 'warning', 

          showCancelButton: true,

          showLoaderOnConfirm: true,

          confirmButtonText: `Si, Continuar!`,

          cancelButtonText:'Cancelar',

          preConfirm: function(result) {

          return new Promise(function(resolve) {

            // var formu = document.getElementById("frmGuardar");

        

            // var data = new FormData(formu);

            $.ajax({

            url:URL+"functions/legalizaciones/aprobarlegalizacion.php", 

            type:"POST", 

            data: {"idProyecto":idProyecto},

            // contentType:false, 

            // processData:false, 

            dataType: "json",

            // cache:false 

            }).done(function(msg){  

              if(msg.msg){

                Swal.fire(

                  {

                  icon: 'success',

                  title: "legalizacion aprobada!",

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

      // }

  })