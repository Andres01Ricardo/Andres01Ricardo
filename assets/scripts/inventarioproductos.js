$(document).ready(function(e){

	dataTable("#tableEnterprise"); 


})



$("body").on("click touchstart",".sumarInsumo",function(e){

	// $("#frmGuardar")[0].reset(); 

	var producto=$(this).parents("tr").find("td").eq(1).html()

	var unidad=$(this).parents("tr").find("td").eq(3).html()

	// var factura=$(this).parents("tr").find("td").eq(4).html()

 //    var total=$(this).parents("tr").find("td").eq(6).html()


	var id=$(this).attr("id"); 

	$("[name='datos[idProducto]']").val(id); 

	$("#insumoSumar").val(producto); 

	$("#unidadSumar").val(unidad); 

	// $("#empresa").val(empresa); 
    
 //    $("#total").val(total); 

})



$("body").on("click touchstart",".restarInsumo",function(e){

	// $("#frmGuardar")[0].reset(); 

	var insumo=$(this).parents("tr").find("td").eq(1).html()

	var unidad=$(this).parents("tr").find("td").eq(3).html()

	// var factura=$(this).parents("tr").find("td").eq(4).html()

 //    var total=$(this).parents("tr").find("td").eq(6).html()


	var id=$(this).attr("id"); 

	$("[name='datos[idProductoRestar]']").val(id); 

	$("#insumoRestar").val(insumo); 

	$("#unidadRestar").val(unidad); 

	// $("#empresa").val(empresa); 
    
 //    $("#total").val(total); 

})





$("body").on("click touchstart","#btnSumar",function(e){

    e.preventDefault();

      

      if(true === $("#frmSumar").parsley().validate()){

        Swal.fire({

        title: '¿Está seguro?',

        text: 'Está a punto de sumar unidades al inventario de productos!',

        icon: 'warning', 

        showCancelButton: true,

        showLoaderOnConfirm: true,

        confirmButtonText: `Si, Guardar!`,

        cancelButtonText:'Cancelar',

        preConfirm: function(result) {

          return new Promise(function(resolve) {

            var formu = document.getElementById("frmSumar");

      

            var data = new FormData(formu);

            $.ajax({

            url:URL+"functions/inventario/modificarinventarioproducto.php", 

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

                  title: 'Inventario modificado!',

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

                )

              } 

          });

          });

        }

      })

      }

  })




$("body").on("click touchstart","#btnRestar",function(e){

    e.preventDefault();

      

      if(true === $("#frmRestar").parsley().validate()){

        Swal.fire({

        title: '¿Está seguro?',

        text: 'Está a punto de restar unidades al inventario de insumos!',

        icon: 'warning', 

        showCancelButton: true,

        showLoaderOnConfirm: true,

        confirmButtonText: `Si, Guardar!`,

        cancelButtonText:'Cancelar',

        preConfirm: function(result) {

          return new Promise(function(resolve) {

            var formu = document.getElementById("frmRestar");

      

            var data = new FormData(formu);

            $.ajax({

            url:URL+"functions/inventario/modificarinventarioproducto.php", 

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

                  title: 'Inventario modificado!',

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

                )

              } 

          });

          });

        }

      })

      }

  })


$('[data-toggle="tooltip"]').tooltip()