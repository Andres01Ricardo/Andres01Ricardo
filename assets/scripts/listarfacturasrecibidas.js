// $(document).ready(function(e){

// 	dataTable("#tableFacturas"); 

// })
// $(document).ready(function(){
  $( window ).on( "load", function() {
//   var empresa=document.getElementById('nombreEmpresa').value;
// var logo=document.getElementById('logoEmpresa').value;
// var nit=document.getElementById('nitEmpresa').value;
// var email=document.getElementById('emailEmpresa').value;
// var telefono=document.getElementById('telefonoEmpresa').value;
// var url=document.getElementById('url').value;
    var table = $('#tableFacturas').DataTable({
      orderCellsTop: true,
       fixedHeader: true,
       ordering:false
    });

    //Creamos una fila en el head de la tabla y lo clonamos para cada columna
    $('#tableFacturas thead tr').clone(true).appendTo( '#tableFacturas thead' );

    $('#tableFacturas thead tr:eq(1) th').each( function (i) {
        var title = $(this).text(); //es el nombre de la columna
        $(this).html( '<input type="text"  class="form-control" style="heigth:25%;" />' );
 
        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );   
});



$("body").on("click",".comprobante",function(e){

	$("#frmGuardar")[0].reset(); 

	var empresa=$(this).parents("tr").find("td").eq(2).html()

	var proveedor=$(this).parents("tr").find("td").eq(3).html()

	var factura=$(this).parents("tr").find("td").eq(4).html()

    var total=$(this).parents("tr").find("td").eq(6).html()
    var saldo=$(this).parents("tr").find("td").eq(8).html()


var idEmpresa=$(this).parents("tr").find("td").eq(10).html();


	var id=$(this).attr("id"); 

	$("[name='datos[idFacturaCompra]']").val(id); 

	$("#nroFactura").val(factura); 

	$("#proveedor").val(proveedor); 

	$("#empresa").val(empresa); 
    
    if (saldo!='$0,00') {
    $("#total").val(saldo); 
    $("#totalSaldo").val(saldo); 

  }
  if (saldo=='$0,00') {
    $("#total").val(total); 
    $("#totalSaldo").val(total); 
    
  }
    // $("#total").val(total); 


    $.ajax({
      url:URL+"functions/facturacompra/consultarcuentatotal.php", 
      type:"POST", 
      data: {"empresa":idEmpresa,"tipoFactura":'compra'}, 
      dataType: "json",
      }).done(function(msg){  

          if(msg.length!=0){

              console.log('este:');
              console.log(msg);
              var sHtml=""; 
              msg.forEach(function(element,index){
                sHtml+="<option value='"+element.idEmpresaCuenta+"'>"+element.codigoCuenta+'-'+element.nombre+"</option>"; 
              })
              $("#cuentaContableTotal").html(sHtml);

              if(msg.length>1){
                $("#divCuentaContableTotal").removeClass('ocultar');
              }
          }
          if(msg.length==0){
          }

        })




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

$("body").on("click touchstart","#btnEliminar",function(e){

    e.preventDefault();
    var idEliminar=$(this).attr('name');
      var posicion=idEliminar.split('[');
      var posicion2=posicion[1].split(']');
      var posicion3=posicion2[0];
      // alert(posicion);
      var inputPoscion="idFacturaCompraEliminar["+posicion3+"][idFacturaCompraEliminar]";
      var idFacturaEliminar=document.getElementById(inputPoscion).value;
      // alert(idFacturaEliminar);

      // if(true === $("#frmEliminar").parsley().validate()){

        Swal.fire({

        title: '¿Está seguro?',

        text: 'Está a punto de eliminar esta factura!',

        icon: 'warning', 

        showCancelButton: true,

        showLoaderOnConfirm: true,

        confirmButtonText: `Si, Eliminar!`,

        cancelButtonText:'Cancelar',

        preConfirm: function(result) {

          return new Promise(function(resolve) {

            // var formu = document.getElementById("frmEliminar");

      

            // var data = new FormData(formu);

            $.ajax({

            url:URL+"functions/facturacompra/eliminarfacturacompra.php", 

            type:"POST", 

            data: {"idFactura":idFacturaEliminar},

            dataType: "json",



            }).done(function(msg){  

              if(msg.msg){

                Swal.fire(

                 {icon: 'success',

                  title: 'Factura eliminada!',

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
      // }

  })



$("body").on("click touchstart","#btnAnular",function(e){

    e.preventDefault();
      var idEliminar=$(this).attr('name');
      var posicion=idEliminar.split('[');
      var posicion2=posicion[1].split(']');
      var posicion3=posicion2[0];
      // alert(posicion);
      var inputPoscion="idFacturaCompraEliminar["+posicion3+"][idFacturaCompraEliminar]";
      var idFacturaAnular=document.getElementById(inputPoscion).value;
      alert(idFacturaAnular);
      // if(true === $("#frmEliminar").parsley().validate()){

        Swal.fire({

        title: '¿Está seguro?',

        text: 'Está a punto de anular esta factura!',

        icon: 'warning', 

        showCancelButton: true,

        showLoaderOnConfirm: true,

        confirmButtonText: `Si, Anular!`,

        cancelButtonText:'Cancelar',

        preConfirm: function(result) {

          return new Promise(function(resolve) {

            // var formu = document.getElementById("frmEliminar");

      

            // var data = new FormData(formu);

            $.ajax({

            url:URL+"functions/facturacompra/anularfacturacompra.php", 

            type:"POST", 

            data:  {"idFactura":idFacturaAnular},

            dataType: "json"


            }).done(function(msg){  

              if(msg.msg){

                Swal.fire(

                 {icon: 'success',

                  title: 'Factura anulada!',

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
      // }

  })

$('[data-toggle="tooltip"]').tooltip();