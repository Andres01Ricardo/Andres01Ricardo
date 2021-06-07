$("body").on("change","[name='datos[idDepartamento]']",function(e){

    var id=$(this).val(); 

    if(id!=""){

      $.ajax({

        url:URL+"functions/generales/ciudades.php", 

        type:"POST", 

        data: {"idDepartamento":id}, 

        dataType: "json",

        }).done(function(msg){  

          var sHtml="<option value=''>Seleccione una opción</option>"; 

          msg.ciudades.forEach(function(element,index){

            sHtml+="<option value='"+element.idCiudad+"'>"+element.nombre+"</option>"; 

          })



          $("[name='datos[idCiudad]']").html(sHtml);

      });

    }else{

      $("[name='datos[idCiudad]']").html("<option value=''>Seleccione una opción</option>");

    }

    

})



$("body").on("change","[name='datos[tipoPersona]']",function(e){

  if($(this).val()==1){

    $("[name='datos[digitoVerificador]']").attr("readonly","readonly");

    $("[name='datos[digitoVerificador]']").removeAttr("required");

  }else{

    $("[name='datos[digitoVerificador]']").attr("required",true);

    $("[name='datos[digitoVerificador]']").removeAttr("readonly");

  }

})



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

            url:URL+"functions/cliente/guardarcliente.php", 

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

      }).then((result) => {

        if (result.isConfirmed) {

        //   var formu = document.getElementById("frmGuardar");

      

        //   var data = new FormData(formu);

        //   $.ajax({

        //   url:URL+"functions/cliente/guardarcliente.php", 

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

        //         title: 'Cliente creado!',

        //         text: 'con exito',

        //         closeOnConfirm: true,

        //       }

        //       ).then((result) => {

        //        location.reload(); 

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





      

          // swal({

          //   title: 'Está seguro?',

          //   text: 'Está a punto de guardar un nuevo cliente!',

          //   icon: 'warning',

          //   buttons: {

          //       confirm : {text:'Si, Guardar!',className:'sweet-warning',closeModal:false},

          //       cancel : 'Cancelar' 

          //   },

          //   dangerMode: true,

          // })

          //   .then((willDelete) => {

          //     if (willDelete) {

          //       var formu = document.getElementById("frmGuardar");

            

          //       var data = new FormData(formu);

          //       $.ajax({

          //       url:URL+"functions/cliente/guardarcliente.php", 

          //       type:"POST", 

          //       data: data,

          //       contentType:false, 

          //       processData:false, 

          //       dataType: "json",

          //       cache:false 

          //       }).done(function(msg){  

          //         if(msg.msg){



          //           swal({   

          //             title: "Cliente creado!",   

          //             text: "con exito",

          //             type: "success",        

          //             closeOnConfirm: true 

          //             }).then((element)=>{

          //               location.reload(); 

          //             })

          //         }else{

          //           swal({   

          //             title: "Algo ha salido mal!",   

          //             text: "Este NIT ya se encuentra registrado",

          //             type: "error",        

          //             closeOnConfirm: true 

          //             }).then((element)=>{

                        

          //             });

          //         }

                

          //     });

          //     } else {

                

          //     }

          //   });

            

       

      }

  })