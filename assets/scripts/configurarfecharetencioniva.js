$("body").on("click touchstart","#btnGuardar",function(e){

  e.preventDefault();

  Swal.fire({

    title: 'Está seguro?',

    text: 'Está a punto de hacer cambios en las empresas para este calendario!',

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

          url:URL+"functions/calendarioimpuesto/configurarempresas.php", 

          type:"POST", 

          data: data,

          contentType:false, 

          processData:false, 

          dataType: "json",

          cache:false 

          }).done(function(msg){  

            if(msg.msg){

              Swal.fire({

                icon: 'success',

                title: 'Cambios realizados!',

                text: 'con exito',

                closeOnConfirm: true,

              }

              ).then((result) => {

               location.href=URL+"listarfecharetencioniva"; 

              })

            }else{

               Swal.fire(

                'Algo ha salido mal!',

                'Verifique su conexión a internet',

                'error'

              ).then((result) => {

                

              })

            }

          

        });    

        });

      }

  }).then((result) => {

    if (result.isConfirmed) {

    } 

  })



  })