var aDatos=[]; 

$(document).ready(function(e){



	$.ajax({

	    url:URL+"functions/productosservicios/listarproductosservicios.php", 

	    type:"POST", 

	    data: {"idEmpresa":$("[name='datos[idEmpresa']").val()}, 

	    dataType: "json",

	    }).done(function(msg){  

	      msg.forEach(function(element,index){

	      	aDatos.push({

			        value: element.idProductoServicio,

			        label: element.codigo+" - "+element.nombre,

			      })

	      })

	      autocomplete(); 

	  });   

})


$('.decimales').keyup(function () { 
    this.value = this.value.replace(/[^0-9\,]/g,'');
    

});

autocomplete=function(){

	$( ".producto" ).autocomplete({

      minLength: 0,

      source: aDatos,

      focus: function( event, ui ) {

      	var index=$(this).index(".producto")

        $( ".producto" ).eq(index).val( ui.item.label );

        $( ".idProducto" ).eq(index).val( ui.item.value );

        return false;

      },

      select: function( event, ui ) {

      	var index=$(this).index(".producto")

        $( ".producto" ).eq(index).val( ui.item.label );

        $( ".idProducto" ).eq(index).val( ui.item.value );

        

        return false;

      },

      change: function(event, ui){

        var index=$(this).index(".producto")



        if(ui.item==null){

          $( ".idProducto" ).eq(index).val('');

        }

        return false;

      }

    })

}





$("body").on("keyup",".cantidad, .valorUnitario, .iva",function(e){

  var cantidad=$(this).parents("tr").find(".cantidad").val(); 

  var iva=$(this).parents("tr").find(".iva").val(); 

  if(iva=="")iva=0;

  if($(this).parents("tr").find(".valorUnitario").val()!=""){var valorUnitario=eliminarMoneda(eliminarMoneda(eliminarMoneda($(this).parents("tr").find(".valorUnitario").val(),"$",""),".",""),",","."); }else{ var valorUnitario=0}

  subtotal=parseInt(cantidad)*parseFloat(valorUnitario); 

  total=parseFloat(subtotal)*(1+(parseFloat(iva)/100)); 

  $(this).parents("tr").find(".total").val(total).trigger("change");

  $(this).parents("tr").find(".subtotal").val(subtotal).trigger("change");

  totalizar(); 

})



$("body").on("keyup","[name='datos[descuento]']",function(e){

  totalizar(); 

})



totalizar=function(){

  var subtotal=0; 

  var valor=0; 

  var iva=0;

  var totalIva=0;

  var total=0; 

  $(".subtotal").each(function(index,element){

    if($(element).val()!=""){valor=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($(element).val(),"$",""),".",""),",",".")); }else{ valor=0; }

    subtotal+=valor

  })

  $(".iva").each(function(index,element){

    var subtotal=$(this).parents("tr").find(".subtotal").val(); 

    if(subtotal!=""){subtotal=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda(subtotal,"$",""),".",""),",",".")); }else{ subtotal=0; }

    if($(element).val()!=""){iva=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($(element).val(),"$",""),".",""),",",".")); }else{ iva=0; }

    totalIva+=parseFloat(subtotal)*(parseFloat(iva)/100);

  })

  $(".total").each(function(index,element){

    if($(element).val()!=""){valor=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($(element).val(),"$",""),".",""),",",".")); }else{ valor=0; }

    total+=valor

  })

  if($("[name='datos[descuento]']").val()!=""){descuento=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($("[name='datos[descuento]']").val(),"$",""),".",""),",",".")); }else{ descuento=0; }

  $("[name='datos[subtotal]']").val(subtotal).trigger("change"); 

  $("[name='datos[iva]']").val(totalIva).trigger("change"); 

  $("[name='datos[total]']").val((subtotal-descuento+totalIva)).trigger("change"); 

}



$("body").on("click touchstart","#agregar",function(e){

  $('select.flexselect').removeData("flexselect");

  var sHtml=$("#tableProductos tbody tr:first").html(); 

  var cant=$("#tableProductos tbody tr").length; 

  $("#tableProductos tbody").append("<tr>"+sHtml+"</tr>"); 

  

  $("#tableProductos tbody tr:last").find("td").eq(0).html(cant+1); 



  $("#tableProductos tbody tr:last").find(".producto").attr("id","item["+cant+"][producto]").attr("name","item["+cant+"][producto]").val("");

  $("#tableProductos tbody tr:last").find(".idProducto").attr("id","item["+cant+"][idProducto]").attr("name","item["+cant+"][idProducto]").val("");

  $("#tableProductos tbody tr:last").find(".descripcion").attr("id","item["+cant+"][descripcion]").attr("name","item["+cant+"][descripcion]").val(""); 

  $("#tableProductos tbody tr:last").find(".cantidad").attr("id","item["+cant+"][cantidad]").attr("name","item["+cant+"][cantidad]").val(""); 

  $("#tableProductos tbody tr:last").find(".idUnidad").attr("id","item["+cant+"][idUnidad]").attr("name","item["+cant+"][idUnidad]").val(""); 

  $("#tableProductos tbody tr:last").find(".valorUnitario").attr("id","item["+cant+"][valorUnitario]").attr("name","item["+cant+"][valorUnitario]").val(''); 

  $("#tableProductos tbody tr:last").find(".subtotal").attr("id","item["+cant+"][subtotal]").attr("name","item["+cant+"][subtotal]").val(""); 

  $("#tableProductos tbody tr:last").find(".iva").attr("id","item["+cant+"][iva]").attr("name","item["+cant+"][iva]").val(''); 

  $("#tableProductos tbody tr:last").find(".total").attr("id","item["+cant+"][total]").attr("name","item["+cant+"][total]").val('');

  autocomplete(); 

})





$("body").on("click touchstart",".eliminar",function(e){



  var cant=$("#tableProductos tbody tr").length; 

  if(cant>1){

    $('select.flexselect').removeData("flexselect");

    $(this).parents("tr").remove(); 

    $("#tableProductos tbody tr").each(function(index,element){

      $(element).find("td").eq(0).html(index+1); 



      $(element).find(".producto").attr("id","item["+index+"][producto]").attr("name","item["+index+"][producto]").val("");

      $(element).find(".idProducto").attr("id","item["+index+"][idProducto]").attr("name","item["+index+"][idProducto]").val("");

      $(element).find(".descripcion").attr("id","item["+index+"][descripcion]").attr("name","item["+index+"][descripcion]").val(""); 

      $(element).find(".cantidad").attr("id","item["+index+"][cantidad]").attr("name","item["+index+"][cantidad]").val(""); 

      $(element).find(".idUnidad").attr("id","item["+index+"][idUnidad]").attr("name","item["+index+"][idUnidad]").val(""); 

      $(element).find(".valorUnitario").attr("id","item["+index+"][valorUnitario]").attr("name","item["+index+"][valorUnitario]").val(''); 

      $(element).find(".subtotal").attr("id","item["+index+"][subtotal]").attr("name","item["+index+"][subtotal]").val(""); 

      $(element).find(".iva").attr("id","item["+index+"][iva]").attr("name","item["+index+"][iva]").val(''); 

      $(element).find(".total").attr("id","item["+index+"][total]").attr("name","item["+index+"][total]").val('');

    })

    

    autocomplete(); 

  }

  

})



$("body").on("click touchstart","#btnGuardar",function(e){

    e.preventDefault();

      if(true === $("#frmGuardar").parsley().validate()){

         Swal.fire({

        title: 'Está seguro?',

        text: 'Está a punto de crear una nueva cotización!',

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

            url:URL+"functions/crm/guardarcotizacion.php", 

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

                  title: 'Cotización creada!',

                  text: 'con exito',

                  closeOnConfirm: true,

                }

                ).then((result) => {

                 
                 location.replace('cotizacion'); 

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
      }

  })