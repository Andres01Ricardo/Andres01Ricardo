$("body").on("click touchstart","#btnGuardar",function(e){

    

  e.preventDefault();

  if(true === $("#frmGuardar").parsley().validate()){

    Swal.fire({

      title: 'Está seguro?',

      text: 'Está a punto de ajustar el saldo a esta cuenta bancaria!',

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

            url:URL+"functions/cuentabancaria/ajustarsaldos.php", 

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

                  title: 'Cambios realizados!',

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

  }

  

  })

$('.decimales').keyup(function () { 
    this.value = this.value.replace(/[^0-9\,]/g,'');

});