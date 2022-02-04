$("body").on("click touchstart","#btnGuardar",function(e){

    e.preventDefault();

      if(true === $("#frmGuardar").parsley().validate()){

            var formu = document.getElementById("frmGuardar");

            
            Swal.fire({

              title: 'Está seguro?',
              text: 'Está a punto de enviar está factura para su gestión!',
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

            url:URL+"functions/configuracion/guardarsalariominimo.php", 

            type:"POST", 

            data: data,

            contentType:false, 

            processData:false, 

            dataType: "json",

            cache:false 

            }).done(function(msg){  

              if(!msg.error){

                if(msg.msg){

                    Swal.fire(

                  {

                    icon: 'success',

                    title: "Salario Minimo Registrado!",

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

                    ).then((result) => {

                      

                    })

                  }

              }else{

                location.href=msg.msg; 

              }

            

          });
              }
              )}
            })


            

       

      }

  })



$("body").on("click","#limpiar",function(e){

  $("#frmGuardar")[0].reset();

})