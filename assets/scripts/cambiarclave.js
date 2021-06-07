$("body").on("click touchstart","#btnGuardar",function(e){

		e.preventDefault();

      if(true === $("#frmGuardar").parsley().validate()){

            if($("#clave").val()!=$("#nuevaClave").val()){

              Swal.fire({

                icon: 'error',

                title: 'Algo ha salido mal!',

                text: 'Los campos deben coincidir',

                closeOnConfirm: true,

              }

              ).then((result) => {

               //location.reload();  

              })

              return false; 

            }

            var formu = document.getElementById("frmGuardar");

            

            var data = new FormData(formu);

            $.ajax({

            url:"functions/sesion/cambiarclave.php", 

            type:"POST", 

            data: data,

            contentType:false, 

            processData:false, 

            dataType: "json",

            cache:false 

            }).done(function(msg){  

              if(!msg.error){

              	 Swal.fire(

                  'Algo ha salido mal!',

                  'Verifique su conexión a internet',

                  'error'

                ).then((result) => {

                  

                })

              }else{

              	location.href=msg.msg; 

              }



          });

       

      }

	})