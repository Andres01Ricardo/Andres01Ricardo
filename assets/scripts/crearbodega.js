// $( document ).ready(function() {

// });



$("body").on("click touchstart","#btnGuardar",function(e){

    e.preventDefault();

      if(true === $("#frmGuardar").parsley().validate()){
        if (verificar_id_cuenta_contable()) {

        var texto="Servicio"; 

          if($("[name='datos[bienServicio]']").val()==1){

            var texto="Producto"; 

          }



          Swal.fire({

          title: '¿Está seguro?',

          text: 'Está a punto de crear una nueva bodega',

          icon: 'warning', 

          showCancelButton: true,

          showLoaderOnConfirm: true,

          confirmButtonText: `Si, Guardar!`,

          cancelButtonText:'Cancelar',

          preConfirm: function(result) {

          return new Promise(function(resolve) {

            var formu = document.getElementById("frmGuardar");

        

            var data = new FormData(formu);

            $.ajax({

            url:URL+"functions/productosservicios/guardarbodega.php", 

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

                  title: "Bodega creada!",

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

            

          });

          });

        }

        })   
        }    

      }

  })