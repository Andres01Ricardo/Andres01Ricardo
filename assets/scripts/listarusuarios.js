$(document).ready(function(e){

	dataTable("#tableUsers"); 

})



$("body").on("click touchstart",".settingPanelToggle",function(e){

	var id=$(this).attr("name"); 

    $.ajax({

    url:"functions/usuario/verusuario.php", 

    type:"POST", 

    data: {"idUser":id}, 

    dataType: "html",

    }).done(function(msg){  

      $("#body-view").html(msg)

  });

})





$("body").on("click touchstart",".activar,.inactivar",function(e){

	var elemento=this;

	var tipo=$(this).attr("accion"); 

	var id=$(this).attr("name"); 

	var usuario=$(this).parents("tr").find("td").eq(1).html()+" "+$(this).parents("tr").find("td").eq(2).html(); 

	var mensaje=tipo==1?"Desactivar":"Activar"; 

   e.preventDefault();

   Swal.fire({

          title: 'Está seguro?',

          text: 'Está a punto de '+mensaje+' a '+usuario,

          icon: 'warning', 

          showCancelButton: true,

          showLoaderOnConfirm: true,

          confirmButtonText: `Si, Continuar!`,

          cancelButtonText:'Cancelar',

          preConfirm: function(result) {

          return new Promise(function(resolve) {

             $.ajax({

              url:"functions/usuario/activardesactivarusuario.php", 

              type:"POST", 

              data: {"idUser":id,"accion":tipo},

              dataType: "html",

              }).done(function(msg){  

                if(!msg.msg){



                  var sConfirmacion=tipo==1?"Desactivado":"Activado"

                  swal({   

                    title: "Usuario "+sConfirmacion,   

                    text: "con exito",

                    type: "success",        

                    closeOnConfirm: true 

                    }).then((element)=>{

                      if(tipo==1){

                        $(elemento).removeClass("inactivar").addClass("activar")

                        $(elemento).removeClass("btn-danger").addClass("btn-success")

                        $(elemento).attr("accion",2)

                        $(elemento).find("i").addClass("fa-check").removeClass("fa-times")

                      }else{

                        $(elemento).removeClass("activar").addClass("inactivar")

                        $(elemento).removeClass("btn-success").addClass("btn-danger")

                        $(elemento).attr("accion",1)

                        $(elemento).find("i").addClass("fa-times").removeClass("fa-check")

                      }

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





  //  swal({

  //   title: 'Está seguro?',

  //   text: 'Está a punto de '+mensaje+' a '+usuario,

  //   icon: 'warning',

  //   buttons: {

  //               confirm : {text:'Si, Continuar!',className:'sweet-warning',closeModal:false},

  //               cancel : 'Cancelar' 

  //           },

  //   dangerMode: true,

  // })

  //   .then((will) => {

  //     if (will) {

        

  //       $.ajax({

  //       url:"functions/usuario/activardesactivarusuario.php", 

  //       type:"POST", 

  //       data: {"idUser":id,"accion":tipo},

  //       dataType: "html",

  //       }).done(function(msg){  

  //         if(!msg.msg){



  //         	var sConfirmacion=tipo==1?"Desactivado":"Activado"

  //           swal({   

  //             title: "Usuario "+sConfirmacion,   

  //             text: "con exito",

  //             type: "success",        

  //             closeOnConfirm: true 

  //             }).then((element)=>{

  //               if(tipo==1){

  //               	$(elemento).removeClass("inactivar").addClass("activar")

  //               	$(elemento).removeClass("btn-danger").addClass("btn-success")

  //               	$(elemento).attr("accion",2)

  //               	$(elemento).find("i").addClass("fa-check").removeClass("fa-times")

  //               }else{

  //               	$(elemento).removeClass("activar").addClass("inactivar")

  //               	$(elemento).removeClass("btn-success").addClass("btn-danger")

  //               	$(elemento).attr("accion",1)

  //               	$(elemento).find("i").addClass("fa-times").removeClass("fa-check")

  //               }

  //             })

  //         }else{

  //           swal({   

  //             title: "Algo ha salido mal!",   

  //             text: "Verifique su conexión a internet",

  //             type: "error",        

  //             closeOnConfirm: true 

  //             }, 

  //             function(){  

                 

  //             });

  //         }

        

  //     });

  //     } else {

        

  //     }

  //   });

    

  })