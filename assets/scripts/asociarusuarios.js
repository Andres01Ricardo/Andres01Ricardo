$("body").on("click touchstart","#btnGuardar",function(e){

    

  e.preventDefault();

  Swal.fire({

    title: 'Está seguro?',

    text: 'Está a punto de asociar empresas a este usuario!',

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

          url:URL+"functions/usuario/asociarempresas.php", 

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

               location.href=URL+"listarusuarios"; 

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

    //   var formu = document.getElementById("frmGuardar");

  

    //   var data = new FormData(formu);

    //   $.ajax({

    //   url:URL+"functions/usuario/asociarempresas.php", 

    //   type:"POST", 

    //   data: data,

    //   contentType:false, 

    //   processData:false, 

    //   dataType: "json",

    //   cache:false 

    //   }).done(function(msg){  

    //     if(msg.msg){

    //       Swal.fire(

    //         {

    //         icon: 'success',

    //         title: 'Cambios realizados!',

    //         text: 'con exito',

    //         closeOnConfirm: true,

    //       }

    //       ).then((result) => {

    //        location.href=URL+"listarusuarios"; 

    //       })

    //     }else{

    //        Swal.fire(

    //         'Algo ha salido mal!',

    //         'Verifique su conexión a internet',

    //         'error'

    //       ).then((result) => {

            

    //       })

    //     }

      

    // });

    } 



   })

    // e.preventDefault();

    //  swal({

    //   title: 'Está seguro?',

    //   text: 'Está a punto de asociar empresas a este usuario!',

    //   icon: 'warning',

    //   buttons: {

    //       confirm : {text:'Si, Continuar!',className:'sweet-warning',closeModal:false},

    //       cancel : 'Cancelar' 

    //   },

    //   dangerMode: true,

    // })

    //   .then((willDelete) => {

    //     if (willDelete) {

    //       var formu = document.getElementById("frmGuardar");

      

    //       var data = new FormData(formu);

    //       $.ajax({

    //       url:URL+"functions/usuario/asociarempresas.php", 

    //       type:"POST", 

    //       data: data,

    //       contentType:false, 

    //       processData:false, 

    //       dataType: "json",

    //       cache:false 

    //       }).done(function(msg){  

    //         if(msg.msg){



    //           swal({   

    //             title: "Cambios realizados!",   

    //             text: "con exito",

    //             type: "success",        

    //             closeOnConfirm: true 

    //             }).then((element)=>{

    //               location.href=URL+"listarusuarios"; 

    //             })

    //         }else{

    //           swal({   

    //             title: "Algo ha salido mal!",   

    //             text: "Verifique su conexión a internet",

    //             type: "error",        

    //             closeOnConfirm: true 

    //             }).then((element)=>{

                  

    //             });

    //         }

          

    //     });

    //     } else {

          

    //     }

    //   });



  })