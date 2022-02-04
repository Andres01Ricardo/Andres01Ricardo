$("body").on("click touchstart","#facturarCotizacion",function(e){


	var overlay = document.getElementById("overlayImpuestos");
    var popup   = document.getElementById("popupImpuestos");

   
    overlay.classList.add('active');
    popup.classList.add('active');
    
});

$("body").on("click","#btn-cerrar",function(e){
    var overlay = document.getElementById("overlayImpuestos");
    var popup   = document.getElementById("popupImpuestos");

   
    overlay.classList.remove('active');
    popup.classList.remove('active');
});


$('[data-toggle="tooltip"]').tooltip();


$("body").on("click touchstart","#btnGuardar",function(e){

    e.preventDefault();

      if(true === $("#frmGuardar").parsley().validate()){

        Swal.fire({

        title: '¿Está seguro?',

        text: 'Está a punto de facturar la cotización!',

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

            url:URL+"functions/facturaventa/facturarcotizacion.php", 

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

                  title: 'Cotizacion facturada!',

                  text: 'con exito',

                  closeOnConfirm: true,

                }

                ).then((result) => {

                  location.replace('../cotizacion/');

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

  })