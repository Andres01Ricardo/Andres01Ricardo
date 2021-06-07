$(document).ready(function(e){

	dataTable("#tableFacturas"); 

})



$("body").on("click",".comprobante",function(e){

	$("#frmGuardar")[0].reset(); 

	var empresa=$(this).parents("tr").find("td").eq(2).html()

	var proveedor=$(this).parents("tr").find("td").eq(3).html()

	var factura=$(this).parents("tr").find("td").eq(4).html()

    var total=$(this).parents("tr").find("td").eq(6).html()



	var id=$(this).attr("id"); 

	$("[name='datos[idFacturaCompra]']").val(id); 

	$("#nroFactura").val(factura); 

	$("#proveedor").val(proveedor); 

	$("#empresa").val(empresa); 
    
    $("#total").val(total); 

})



$("body").on("click","#btnGuardar",function(e){

    e.preventDefault();

      

      if(true === $("#frmGuardar").parsley().validate()){

        Swal.fire({

        title: 'Está seguro?',

        text: 'Está a punto de marcar como pagada esta factura!',

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

            url:URL+"functions/facturacompra/guardarcomprobanteegreso.php", 

            type:"POST", 

            data: data,

            contentType:false, 

            processData:false, 

            dataType: "json",

            cache:false 

            }).done(function(msg){  

              if(msg.msg){

                Swal.fire(

                 {icon: 'success',

                  title: 'Pago realizado!',

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

        //   url:URL+"functions/facturacompra/guardarcomprobanteegreso.php", 

        //   type:"POST", 

        //   data: data,

        //   contentType:false, 

        //   processData:false, 

        //   dataType: "json",

        //   cache:false 

        //   }).done(function(msg){  

        //     if(msg.msg){

        //       Swal.fire(

        //        {icon: 'success',

        //         title: 'Pago realizado!',

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

        //   text: 'Está a punto de guardar marcar como pagada esta factura!',

        //   icon: 'warning',

        //   buttons: {

        //         confirm : {text:'Si, Continuar!',className:'sweet-warning',closeModal:false},

        //         cancel : 'Cancelar' 

        //     },

        //   dangerMode: true,

        // })

        //   .then((willDelete) => {

        //     if (willDelete) {

        //       var formu = document.getElementById("frmGuardar");

          

        //       var data = new FormData(formu);

        //       $.ajax({

        //       url:URL+"functions/facturacompra/guardarcomprobanteegreso.php", 

        //       type:"POST", 

        //       data: data,

        //       contentType:false, 

        //       processData:false, 

        //       dataType: "json",

        //       cache:false 

        //       }).done(function(msg){  

        //         if(msg.msg){



        //           swal({   

        //             title: "Pago realizado!",   

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


$('[data-toggle="tooltip"]').tooltip();