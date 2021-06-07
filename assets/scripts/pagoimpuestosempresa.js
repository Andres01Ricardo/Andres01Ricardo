
$("body").on("click touchstart","#btnPagarICA",function(e){


	
    var overlay = document.getElementById("overlayICA");
    var popup   = document.getElementById("popupICA");

    overlay.classList.add('active');
    popup.classList.add('active');
});

$("body").on("click touchstart","#btnCerrarICA",function(e){
    var overlay = document.getElementById("overlayICA");
    var popup   = document.getElementById("popupICA");
    
    
    overlay.classList.remove('active');
    popup.classList.remove('active');
});


$("body").on("click touchstart","#btnPagarRetencion",function(e){


	
    var overlay = document.getElementById("overlayRetencion");
    var popup   = document.getElementById("popupRetencion");

    overlay.classList.add('active');
    popup.classList.add('active');
});

$("body").on("click touchstart","#btnCerrarRetencion",function(e){
    var overlay = document.getElementById("overlayRetencion");
    var popup   = document.getElementById("popupRetencion");
    
    
    overlay.classList.remove('active');
    popup.classList.remove('active');
});
$("body").on("click touchstart","#btnPagarIVA",function(e){


	
    var overlay = document.getElementById("overlayIVA");
    var popup   = document.getElementById("popupIVA");

    overlay.classList.add('active');
    popup.classList.add('active');
});

$("body").on("click touchstart","#btnCerrarIVA",function(e){
    var overlay = document.getElementById("overlayIVA");
    var popup   = document.getElementById("popupIVA");
    
    
    overlay.classList.remove('active');
    popup.classList.remove('active');
});

$("body").on("click touchstart","#btnPagarSeguridadSocial",function(e){



    var overlay = document.getElementById("overlaySeguridadSocial");
    var popup   = document.getElementById("popupSeguridadSocial");

   
    overlay.classList.add('active');
    popup.classList.add('active');
});

$("body").on("click touchstart","#btnCerrarSeguridadSocial",function(e){
    var overlay = document.getElementById("overlaySeguridadSocial");
    var popup   = document.getElementById("popupSeguridadSocial");
    
    
    overlay.classList.remove('active');
    popup.classList.remove('active');
});

$('[data-toggle="tooltip"]').tooltip();


$("body").on("click touchstart","#btnGuardarICA",function(e){

    e.preventDefault();

      if(true === $("#frmGuardarICA").parsley().validate()){

         Swal.fire({

        title: 'Está seguro?',

        text: 'Está a punto de marcar pagado el ica!',

        icon: 'warning', 

        showCancelButton: true,

        showLoaderOnConfirm: true,

        confirmButtonText: `Si, Guardar!`,

        cancelButtonText:'Cancelar',

        preConfirm: function(result) {

          return new Promise(function(resolve) {

            var formu = document.getElementById("frmGuardarICA");

      

            var data = new FormData(formu);

            $.ajax({

            url:URL+"functions/impuestos/pagarICA.php", 

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

                  title: 'ICA pagado!',

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

  })

$("body").on("click touchstart","#btnModificarICA",function(e){

    e.preventDefault();

      if(true === $("#frmModificarICA").parsley().validate()){

         Swal.fire({

        title: 'Está seguro?',

        text: 'Está a punto de modificar el ica!',

        icon: 'warning', 

        showCancelButton: true,

        showLoaderOnConfirm: true,

        confirmButtonText: `Si, Guardar!`,

        cancelButtonText:'Cancelar',

        preConfirm: function(result) {

          return new Promise(function(resolve) {

            var formu = document.getElementById("frmModificarICA");

      

            var data = new FormData(formu);

            $.ajax({

            url:URL+"functions/impuestos/modificarICA.php", 

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

                  title: 'ICA modificado!',

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

  })



$("body").on("click touchstart","#btnGuardarRetencion",function(e){

    e.preventDefault();

      if(true === $("#frmGuardarRetencion").parsley().validate()){

         Swal.fire({

        title: 'Está seguro?',

        text: 'Está a punto de marcar pagado la retencion!',

        icon: 'warning', 

        showCancelButton: true,

        showLoaderOnConfirm: true,

        confirmButtonText: `Si, Guardar!`,

        cancelButtonText:'Cancelar',

        preConfirm: function(result) {

          return new Promise(function(resolve) {

            var formu = document.getElementById("frmGuardarRetencion");

      

            var data = new FormData(formu);

            $.ajax({

            url:URL+"functions/impuestos/pagarRetencion.php", 

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

                  title: 'Retención pagada!',

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

  })

$("body").on("click touchstart","#btnModificarRetencion",function(e){

    e.preventDefault();

      if(true === $("#frmModificarRetencion").parsley().validate()){

         Swal.fire({

        title: 'Está seguro?',

        text: 'Está a punto de modificar la retencion!',

        icon: 'warning', 

        showCancelButton: true,

        showLoaderOnConfirm: true,

        confirmButtonText: `Si, Guardar!`,

        cancelButtonText:'Cancelar',

        preConfirm: function(result) {

          return new Promise(function(resolve) {

            var formu = document.getElementById("frmModificarRetencion");

      

            var data = new FormData(formu);

            $.ajax({

            url:URL+"functions/impuestos/modificarRetencion.php", 

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

                  title: 'Retencion modificado!',

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

  })


$("body").on("click touchstart","#btnGuardarIVA",function(e){

    e.preventDefault();

      if(true === $("#frmGuardar").parsley().validate()){

         Swal.fire({

        title: 'Está seguro?',

        text: 'Está a punto de marcar pagado el iva!',

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

            url:URL+"functions/impuestos/pagarIVA.php", 

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

                  title: 'IVA pagado!',

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

  })


$("body").on("click touchstart","#btnModificarIVA",function(e){

    e.preventDefault();

      if(true === $("#frmModificarIVA").parsley().validate()){

         Swal.fire({

        title: 'Está seguro?',

        text: 'Está a punto de modificar la IVA!',

        icon: 'warning', 

        showCancelButton: true,

        showLoaderOnConfirm: true,

        confirmButtonText: `Si, Guardar!`,

        cancelButtonText:'Cancelar',

        preConfirm: function(result) {

          return new Promise(function(resolve) {

            var formu = document.getElementById("frmModificarIVA");

      

            var data = new FormData(formu);

            $.ajax({

            url:URL+"functions/impuestos/modificarIVA.php", 

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

                  title: 'IVA modificado!',

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

  })



$("body").on("click touchstart","#btnGuardarSeguridadSocial",function(e){

    e.preventDefault();

      if(true === $("#frmGuardarSeguridadSocial").parsley().validate()){

         Swal.fire({

        title: 'Está seguro?',

        text: 'Está a punto de marcar pagado la seguridad social!',

        icon: 'warning', 

        showCancelButton: true,

        showLoaderOnConfirm: true,

        confirmButtonText: `Si, Guardar!`,

        cancelButtonText:'Cancelar',

        preConfirm: function(result) {

          return new Promise(function(resolve) {

            var formu = document.getElementById("frmGuardarSeguridadSocial");

      

            var data = new FormData(formu);

            $.ajax({

            url:URL+"functions/impuestos/pagarSeguridadSocial.php", 

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

                  title: 'seguridad social pagada!',

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

  })



$("body").on("click touchstart","#btnModificarSeguridadSocial",function(e){

    e.preventDefault();

      if(true === $("#frmModificarSeguridadSocial").parsley().validate()){

         Swal.fire({

        title: 'Está seguro?',

        text: 'Está a punto de modificar la Seguridad Social!',

        icon: 'warning', 

        showCancelButton: true,

        showLoaderOnConfirm: true,

        confirmButtonText: `Si, Guardar!`,

        cancelButtonText:'Cancelar',

        preConfirm: function(result) {

          return new Promise(function(resolve) {

            var formu = document.getElementById("frmModificarSeguridadSocial");

      

            var data = new FormData(formu);

            $.ajax({

            url:URL+"functions/impuestos/modificarSeguridadSocial.php", 

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

                  title: 'Seguridad Social modificada!',

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

  })