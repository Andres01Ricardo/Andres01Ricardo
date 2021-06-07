$("body").on("click touchstart","#btnGuardar",function(e){

    e.preventDefault();



    var clave=$("[name='datos[clave]']").val();

    var nuevaClave=$("[name='datos[nuevaClave]']").val();

    var patt=validarClave();



    if(!patt){ return false; }

    if(clave!=nuevaClave){

      Swal.fire(

          'Algo ha salido mal!',

          'Las contraseñas deben coincidir',

          'error'

        ).then((result) => {

          

        })



        return false; 

    }else{

      var formu = document.getElementById("frmCambiarClave");

            

      var data = new FormData(formu);

      $.ajax({

      url:URL+"functions/usuario/cambiarclave.php", 

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

            title: "Clave Cambiada!",

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

    }

  })



function validarClave(){

  var regex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/ ;



  var clave=$("[name='datos[clave]']").val();



  var request=regex.test(clave);

  if(!request) {

    Swal.fire(

      'Algo ha salido mal!',

      'Las contraseñas deben contener minimo 8 caracteres entre números y letras',

      'error'

    ).then((result) => {

      

    })



  }

  

  return request

  

}





$("body").on("change","[name='datos[idDepartamentoResidencia]']",function(e){

    var id=$(this).val();

    if(id!=""){

      $.ajax({

        url:"functions/generales/ciudades.php", 

        type:"POST", 

        data: {"idDepartamento":id}, 

        dataType: "json",

        }).done(function(msg){  

          var sHtml="<option value=''>Seleccione una opción</option>"; 

          msg.ciudades.forEach(function(element,index){

            sHtml+="<option value='"+element.idCiudad+"'>"+element.nombre+"</option>"; 

          })



          $("[name='datos[idCiudadResidencia]']").html(sHtml);

      });

    } else{

      $("[name='datos[idCiudadResidencia]']").html("<option value=''>Seleccione una opción</option>");

    }

    

})



$("body").on("click touchstart","#btnActualizar",function(e){

    e.preventDefault();

      if(true === $("#frmNuevo").parsley().validate()){

          Swal.fire({

          title: 'Está seguro?',

          text: 'Está a punto de actualizar sus datos!',

          icon: 'warning', 

          showCancelButton: true,

          showLoaderOnConfirm: true,

          confirmButtonText: `Si, Continuar!`,

          cancelButtonText:'Cancelar',

          preConfirm: function(result) {

          return new Promise(function(resolve) {

            var formu = document.getElementById("frmNuevo");

        

            var data = new FormData(formu);

            $.ajax({

            url:URL+"functions/usuario/actualizarusuario.php", 

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

                  title: "Datos Actualizados!",

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



        

          // swal({

          //   title: 'Está seguro?',

          //   text: 'Está a punto de actualizar sus datos!',

          //   icon: 'warning',

          //   buttons: {

          //       confirm : {text:'Si, Guardar!',className:'sweet-warning',closeModal:false},

          //       cancel : 'Cancelar' 

          //   },

          //   dangerMode: true,

          // })

          //   .then((willDelete) => {

          //     if (willDelete) {

          //       var formu = document.getElementById("frmNuevo");

            

          //       var data = new FormData(formu);

          //       $.ajax({

          //       url:URL+"functions/usuario/actualizarusuario.php", 

          //       type:"POST", 

          //       data: data,

          //       contentType:false, 

          //       processData:false, 

          //       dataType: "json",

          //       cache:false 

          //       }).done(function(msg){  

          //         if(msg.msg){



          //           swal({   

          //             title: "Datos Actualizados!",   

          //             text: "con exito",

          //             type: "success",        

          //             closeOnConfirm: true 

          //             }).then((element)=>{

          //               location.reload(); 

                        

          //             })

          //         }else{

          //           swal({   

          //             title: "Algo ha salido mal!",   

          //             text: "ya existe un registro con este numero de cedula",

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