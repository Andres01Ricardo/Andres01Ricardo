$("body").on("click touchstart","#btnGuardar",function(e){

    e.preventDefault();

      if(true === $("#frmGuardar").parsley().validate()){

        Swal.fire({

        title: 'Está seguro?',

        text: 'Está a punto de guardar un nuevo cliente!',

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

            url:URL+"functions/crm/insertarcliente.php", 

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

                  title: 'Cliente creado!',

                  text: 'con exito',

                  closeOnConfirm: true,

                }

                ).then((result) => {

                 location.reload(); 

                })

              }else{

                 Swal.fire(

                  'Algo ha salido mal!',

                  'El cliente ya se encuentra registrado en el sistema',

                  'error'

                ).then((result) => {

                  

                })

              }

            

          });

          });

        }

      })

      }

  })


$("body").on("change","#tipoDocumento",function(e){

    if ($('#tipoDocumento option:selected').text()=='NIT') {
      $("#labelNombre").addClass('ocultar');
      $("#labelRazon").removeClass('ocultar');
      $("#apellidos").removeAttr('required');
      $("#divApellidos").css('display',"none");

    }
    else{
      $("#labelNombre").removeClass('ocultar');
      $("#labelRazon").addClass('ocultar');
      $("#apellidos").attr('required','required');
      $("#divApellidos").css('display',"block");

    }
})

