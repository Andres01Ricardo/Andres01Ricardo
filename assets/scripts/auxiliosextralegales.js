$("body").on("change","[name='datos[idEmpleado]']",function(e){

  $("#numeroDocumento").val('')

  if($(this).val()!=""){

    var cc=$(this).find("option:selected").attr("cc")

    $("#numeroDocumento").val(cc)

  }

})



$("body").on("change","[name='datos[idAuxilio]']",function(e){

  var editable=$(this).find("option:selected").attr("editable"); 



  if(editable==1){

    $(".otro").removeClass("ocultar"); 

    $("[name='datos[otroAuxilio]']").attr("required","required"); 

    $(".deducible").removeClass("col-md-6").addClass("col-md-4"); 

  }else{

  	$(".otro").addClass("ocultar"); 

    $("[name='datos[otroAuxilio]']").removeAttr("required","required"); 

    $(".deducible").removeClass("col-md-4").addClass("col-md-6"); 

  }

})



$("body").on("click touchstart","#btnGuardar",function(e){

e.preventDefault();

  if(true === $("#frmGuardar").parsley().validate()){

    e.preventDefault();

    Swal.fire({

      title: 'Está seguro?',

      text: 'Está a punto de registrar un auxilio extralegal a '+$("[name='datos[idEmpleado]']").find("option:selected").html()+'!',

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

          url:URL+"functions/nomina/guardarauxilioextralegal.php", 

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

                title: 'Auxilio Extralegal registrado!',

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

    }).then((result) => {

      if (result.isConfirmed) {

    //   var formu = document.getElementById("frmGuardar");

  

    //   var data = new FormData(formu);

    //   $.ajax({

    //   url:URL+"functions/nomina/guardarauxilioextralegal.php", 

    //   type:"POST", 

    //   data: data,

    //   contentType:false, 

    //   processData:false, 

    //   dataType: "json",

    //   cache:false 

    //   }).done(function(msg){  

    //     if(msg.msg){

    //       Swal.fire({

    //         icon: 'success',

    //         title: 'Auxilio Extralegal registrado!',

    //         text: 'con exito',

    //         closeOnConfirm: true,

    //       }

    //       ).then((result) => {

    //        location.reload();  

    //       })

    //     }else{

    //       Swal.fire(

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

      //   text: 'Está a punto de registrar un auxilio extralegal a '+$("[name='datos[idEmpleado]']").find("option:selected").html()+'!',

      //   icon: 'warning',

      //   buttons: {

      //           confirm : {text:'Si, Guardar!',className:'sweet-warning',closeModal:false},

      //           cancel : 'Cancelar' 

      //       },

      //   dangerMode: true,

      // })

      //   .then((willDelete) => {

      //     if (willDelete) {

      //       var formu = document.getElementById("frmGuardar");

        

      //       var data = new FormData(formu);

      //       $.ajax({

      //       url:URL+"functions/nomina/guardarauxilioextralegal.php", 

      //       type:"POST", 

      //       data: data,

      //       contentType:false, 

      //       processData:false, 

      //       dataType: "json",

      //       cache:false 

      //       }).done(function(msg){  

      //         if(msg.msg){



      //           swal({   

      //             title: "Auxilio Extralegal registrado!",   

      //             text: "con exito",

      //             type: "success",        

      //             closeOnConfirm: true 

      //             }).then((element)=>{

      //               location.reload(); 

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

        

   

  }

})