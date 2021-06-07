$(document).ready(function(e){

	dataTable("#tableFacturas"); 

})

$("body").on("click",".comprobante",function(e){

	$("#frmGuardar")[0].reset(); 

	

	var factura=$(this).parents("tr").find("td").eq(3).html();

    var total=$(this).parents("tr").find("td").eq(5).html();

	var id=$(this).attr("id"); 

	$("[name='datos[idFacturaVenta]']").val(id); 

	$("#nroFactura").val(factura); 

    
    $("#total").val(total); 

})





$("body").on("click","#btnGuardar",function(e){

    e.preventDefault();

      

      if(true === $("#frmGuardar").parsley().validate()){

        Swal.fire({

        title: '¿Está seguro?',

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

            url:URL+"functions/facturaventa/guardarcomprobanteingreso.php", 

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

      })
      }

  })


$('[data-toggle="tooltip"]').tooltip();