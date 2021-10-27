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





// $("body").on("keyup",".cantidad, .valorUnitario, .iva",function(e){

//   var cantidad=$(this).parents("tr").find(".cantidad").val(); 

//   var iva=$(this).parents("tr").find(".iva").val(); 

//   if(iva=="")iva=0;

//   if($(this).parents("tr").find(".valorUnitario").val()!=""){var valorUnitario=eliminarMoneda(eliminarMoneda($(this).parents("tr").find(".valorUnitario").val(),"$",""),",",""); }else{ var valorUnitario=0}

//   subtotal=parseInt(cantidad)*parseFloat(valorUnitario); 

//   total=parseFloat(subtotal)*(1+(parseFloat(iva)/100)); 

//   $(this).parents("tr").find(".total").val(total).trigger("change");

//   $(this).parents("tr").find(".subtotal").val(subtotal).trigger("change");

//   totalizar(); 

// })



// $("body").on("keyup","[name='datos[descuento]']",function(e){

//   totalizar(); 

// })



// totalizar=function(){

//   var subtotal=0; 

//   var valor=0; 

//   var iva=0;

//   var totalIva=0;

//   var total=0; 

//   $(".subtotal").each(function(index,element){

//     if($(element).val()!=""){valor=parseFloat(eliminarMoneda(eliminarMoneda($(element).val(),"$",""),",","")); }else{ valor=0; }

//     subtotal+=valor

//   })

//   $(".iva").each(function(index,element){

//     var subtotal=$(this).parents("tr").find(".subtotal").val(); 

//     if(subtotal!=""){subtotal=parseFloat(eliminarMoneda(eliminarMoneda(subtotal,"$",""),",","")); }else{ subtotal=0; }

//     if($(element).val()!=""){iva=parseFloat(eliminarMoneda(eliminarMoneda($(element).val(),"$",""),",","")); }else{ iva=0; }

//     totalIva+=parseFloat(subtotal)*(parseFloat(iva)/100);

//   })

//   $(".total").each(function(index,element){

//     if($(element).val()!=""){valor=parseFloat(eliminarMoneda(eliminarMoneda($(element).val(),"$",""),",","")); }else{ valor=0; }

//     total+=valor

//   })

//   if($("[name='datos[descuento]']").val()!=""){descuento=parseFloat(eliminarMoneda(eliminarMoneda($("[name='datos[descuento]']").val(),"$",""),",","")); }else{ descuento=0; }

//   $("[name='datos[subtotal]']").val(subtotal).trigger("change"); 

//   $("[name='datos[iva]']").val(totalIva).trigger("change"); 

//   $("[name='datos[total]']").val((subtotal-descuento+totalIva)).trigger("change"); 

// }



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

  // $("#tableProductos tbody tr:last").find(".idUnidad").attr("id","item["+cant+"][idUnidad]").attr("name","item["+cant+"][idUnidad]").val(""); 

  // $("#tableProductos tbody tr:last").find(".valorUnitario").attr("id","item["+cant+"][valorUnitario]").attr("name","item["+cant+"][valorUnitario]").val(''); 

  // $("#tableProductos tbody tr:last").find(".subtotal").attr("id","item["+cant+"][subtotal]").attr("name","item["+cant+"][subtotal]").val(""); 

  // $("#tableProductos tbody tr:last").find(".iva").attr("id","item["+cant+"][iva]").attr("name","item["+cant+"][iva]").val(''); 

  // $("#tableProductos tbody tr:last").find(".total").attr("id","item["+cant+"][total]").attr("name","item["+cant+"][total]").val('');

  autocomplete(); 

})

$("body").on("change","#remision",function(e){

  if ($(this).val()!="") {
    $.ajax({

      url:URL+"functions/crm/cargarcotizacion.php", 

      type:"POST", 

      data: {"idCotizacion":$(this).val()}, 

      dataType: "json",

      }).done(function(msg){  
        console.log(msg);
        // msg.forEach(function(element,index){

          var observaciones= msg.cotizacion.observaciones;
          var numeroRemision= msg.cotizacion.numeroCotizacion.substring(4);
          var cliente = msg.cliente.idCliente+' - '+msg.cliente.nombre+' '+msg.cliente.apellidos;
          var idCliente = msg.cliente.codigoCliente;
          var sHtml="";
          var numero=0;
          $("#observaciones").val(observaciones);
          $("#numero").val("REM"+numeroRemision);
          $("#cliente").val(cliente);
          $("#idCliente").val(idCliente);
          msg.cotizacionItem.forEach(function(element,index){
            console.log(element);
            numero=index+1;
            sHtml+='<tr>';
            sHtml+="<td>"+numero+"</td>";
            sHtml+='<td><input type="text" name="item['+index+'][producto]" id="item['+index+'][producto]" class="form-control producto mayusculas" required placeholder="Detalle" value="'+element.detalleProducto+'" ><input type="hidden" name="item['+index+'][idProducto]" id="item['+index+'][idProducto]" class="form-control idProducto" value="'+element.idProductoServicio+'" ></td>';
            sHtml+='<td><input type="text" class="form-control descripcion mayusculas" name="item['+index+'][descripcion]" id="item['+index+'][descripcion]" placeholder="Descripción" required value="'+element.descripcion+'"  ></td>';
            sHtml+='<td><input type="text" class="form-control numero cantidad" name="item['+index+'][cantidad]" id="item['+index+'][cantidad]" placeholder="Cantidad" required  value="'+element.cantidad+'"  ></td>';
            sHtml+='<td class="centrar"><a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn btn-icon btn-sm btn-danger eliminar"><i class="fas fa-trash"></i></a> </td>';
          sHtml+='</tr>';
          })


          $("#tableProductos tbody").append(sHtml); 
          $("#agregar").removeClass("ocultar");
        // autocomplete(); 

    }); 
  }



})

  
  
  


// foreach($aCotizacion as $cotizacion){
//       <tr style="text-align: center;">
//         <th scope="row"><?php echo $cotizacion['detalleProducto'];?></th>
//         <td ><?php echo $cotizacion['descripcion'];?></td>
//         <td ><?php echo $cotizacion['cantidad'];?></td>
//         <td><?php echo "$".number_format($cotizacion['valorUnitario'],2,",","."); ?></td>
//         <td><?php echo "$".number_format($cotizacion['subtotal'],2,",","."); ?></td>
//         <td><?php echo $cotizacion['iva'];?>%</td>
//         <td><?php echo "$".number_format($cotizacion['total'],2,",",".");?></td>
//       </tr>
//      <?php } ?>
//      <tr style="text-align: center; font-size: 25px;">
//       <th>Total</th>
//       <td>-</td>
//       <td>-</td>
//       <td>-</td>
//       <td><?php echo "$".number_format($aCotizacionTotal['subtotal'],2,",","."); ?></td>
//       <td><?php echo "$".number_format($aCotizacionTotal['iva'],2,",","."); ?></td>
//       <td><?php echo "$".number_format($aCotizacionTotal['total'],2,",","."); ?></td>
//      </tr>

     

$("body").on("click touchstart",".eliminar",function(e){



  var cant=$("#tableProductos tbody tr").length; 

  if(cant>1){

    $('select.flexselect').removeData("flexselect");

    $(this).parents("tr").remove(); 

    $("#tableProductos tbody tr").each(function(index,element){

      $(element).find("td").eq(0).html(index+1); 



      $(element).find(".producto").attr("id","item["+index+"][producto]").attr("name","item["+index+"][producto]");

      $(element).find(".idProducto").attr("id","item["+index+"][idProducto]").attr("name","item["+index+"][idProducto]");

      $(element).find(".descripcion").attr("id","item["+index+"][descripcion]").attr("name","item["+index+"][descripcion]"); 

      $(element).find(".cantidad").attr("id","item["+index+"][cantidad]").attr("name","item["+index+"][cantidad]"); 

      // $(element).find(".idUnidad").attr("id","item["+index+"][idUnidad]").attr("name","item["+index+"][idUnidad]").val(""); 

      // $(element).find(".valorUnitario").attr("id","item["+index+"][valorUnitario]").attr("name","item["+index+"][valorUnitario]").val(''); 

      // $(element).find(".subtotal").attr("id","item["+index+"][subtotal]").attr("name","item["+index+"][subtotal]").val(""); 

      // $(element).find(".iva").attr("id","item["+index+"][iva]").attr("name","item["+index+"][iva]").val(''); 

      // 

      // $(element).find(".total").attr("id","item["+index+"][total]").attr("name","item["+index+"][total]").val('');
      // $(element).find(".producto").attr("id","item["+index+"][producto]").attr("name","item["+index+"][producto]");
      // $(element).find(".idProducto").attr("id","item["+index+"][idProducto]").attr("name","item["+index+"][idProducto]");
      // $(element).find(".descripcion").attr("id","item["+index+"][descripcion]").attr("name","item["+index+"][descripcion]");
      // $(element).find(".cantidad").attr("id","item["+index+"][cantidad]").attr("name","item["+index+"][cantidad]");
      
    })

    

    autocomplete(); 

  }

  

})



$("body").on("click touchstart","#btnGuardar",function(e){

    e.preventDefault();

      if(true === $("#frmGuardar").parsley().validate()){

         Swal.fire({

        title: 'Está seguro?',

        text: 'Está a punto de crear una nueva remisión!',

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

            url:URL+"functions/crm/guardarremision.php", 

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

                  title: 'Remisión creada!',

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
      }

  })