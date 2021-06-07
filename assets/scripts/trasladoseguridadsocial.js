$("body").on("change","[name='datos[idEmpleado]']",function(e){

	$("#numeroDocumento").val('')

	if($(this).val()!=""){

		var cc=$(this).find("option:selected").attr("cc")

		$("#numeroDocumento").val(cc)



		$.ajax({

	        url:URL+"functions/nomina/seguridadsocialempleado.php", 

	        type:"POST", 

	        data: {"idEmpleado":$(this).val()}, 

	        dataType: "json",

	        }).done(function(msg){  

	          

	          $("#eps").val(msg.eps)

	          $("#pensiones").val(msg.pensiones)

	          $("#cesantias").val(msg.cesantias)



	      });

	

	}

})





$("body").on("change","[name='datos[tipoTraslado]']",function(e){

	

	if($(this).val()!=""){

		$.ajax({

	        url:URL+"functions/nomina/seguridadsocial.php", 

	        type:"POST", 

	        data: {"tipo":$(this).val()}, 

	        dataType: "json",

	        }).done(function(msg){  

	          

	          var sHtml="<option value=''>Seleccione una opción</option>"; 

	          msg.lista.forEach(function(element,index){

	            sHtml+="<option value='"+element.idSeguridadSocial+"'>"+element.nombre+"</option>"; 

	          })



	          $("[name='datos[idTraslado]']").html(sHtml);



	      });

	}else{

		$("[name='datos[idTraslado]']").html(sHtml);		

	}

})



$("body").on("click touchstart","#btnGuardar",function(e){

    e.preventDefault();

      if(true === $("#frmGuardar").parsley().validate()){

          Swal.fire({

          title: 'Está seguro?',

          text: 'Está a punto de realizar cambio en la seguridad social de '+$("[name='datos[idEmpleado]']").find("option:selected").html()+'!',

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

            url:URL+"functions/nomina/guardarcambioseguridadsocial.php", 

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

                  title: "Traslado registrado!",

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

          } 



         })



        

          // swal({

          //   title: 'Está seguro?',

          //   text: 'Está a punto de realizar cambio en la seguridad social de '+$("[name='datos[idEmpleado]']").find("option:selected").html()+'!',

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

          //       url:URL+"functions/nomina/guardarcambioseguridadsocial.php", 

          //       type:"POST", 

          //       data: data,

          //       contentType:false, 

          //       processData:false, 

          //       dataType: "json",

          //       cache:false 

          //       }).done(function(msg){  

          //         if(msg.msg){



          //           swal({   

          //             title: "Traslado registrado!",   

          //             text: "con exito",

          //             type: "success",        

          //             closeOnConfirm: true 

          //             }).then((element)=>{

          //               location.reload(); 

          //             })

          //         }else{

          //           swal({   

          //             title: "Algo ha salido mal!",   

          //             text: "Revise su conexion a internet",

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