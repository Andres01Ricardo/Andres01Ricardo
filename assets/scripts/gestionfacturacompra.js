var aDatos=[]; 

$(document).ready(function(e){
$("#selectCaja").css("display", "none");
$("#divAbono").css("display", "none");
$("#divEnlazarFactura").css("display", "none");
var idEmpresa=$("#idEmpresaGestion").val();
// alert(idEmpresa);
	$.ajax({

	    url:URL+"functions/productosservicios/listarproductosservicios.php", 

	    type:"POST", 

	    data: {"tipo":$("[name='datos[tipoFactura']").val(),"idEmpresa":idEmpresa}, 

	    dataType: "json",

	    }).done(function(msg){  

        console.log(msg)

	      msg.forEach(function(element,index){

	      	aDatos.push({

			        value: element.idProductoServicio,

			        label: element.codigo+" - "+element.nombre,

			      })

	      })

	      autocomplete(); 

	  });   



      $.ajax({
          url:URL+"functions/facturacompra/consultarcomprobantefactura.php", 
          type:"POST", 
          data: {"idEmpresa":idEmpresa}, 
          dataType: "json",
          }).done(function(msg){  
            console.log('este es:');
            console.log(msg);
              if(msg.length!=0){

                  
                  var sHtml="<option value=''>Seleccione una opción</option>"; 
                  msg.forEach(function(element,index){
                    sHtml+="<option value='"+element.idComprobante+"'>"+element.nroFactura+"</option>"; 
                  })
                  $("#enlazarFactura").html(sHtml);

                  // if(msg.length>1){
                    // $("#divEnlazarFactura").removeClass('ocultar');
                  // }
              }
              // if(msg.length==0){
              // }

            })


          $.ajax({
          url:URL+"functions/facturacompra/consultarcuentatotal.php", 
          type:"POST", 
          data: {"empresa":$("[name='datos[idEmpresa]'").val(),"tipoFactura":'compra'}, 
          dataType: "json",
          }).done(function(msg){  

              if(msg.length!=0){

                  console.log('aca');
                  console.log(msg);
                  // var sHtml=""; 
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
                
                // Swal.fire(
                // {
                //   icon: 'error',
                //   title: "El total a pagar no se encuentra parametrizado!",   
                //   text: "Por favor parametrice la cuenta contable",
                //   closeOnConfirm: true,
                // }).then((element)=>{

                //   // $( ".registrar" ).eq(index).removeClass('ocultar');

                // });
              }

            })


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

        $( ".producto" ).eq(index).val( ui.item.label ).removeClass("no-producto");

        $( ".idProducto" ).eq(index).val( ui.item.value );

        $(this).parents("td").find("span").remove(); 

        return false;

      },

      select: function( event, ui ) {

      	var index=$(this).index(".producto")

        $( ".producto" ).eq(index).val( ui.item.label ).removeClass("no-producto");

        $( ".idProducto" ).eq(index).val( ui.item.value );

        $(this).parents("td").find("span").remove(); 

        

        return false;

      }

    })

}



$("body").on("change","[name='datos[grupo]']",function(e){

    var id=$(this).val(); 

    if(id!=""){

        var tipo=$(this).find("option:selected").attr("tipo");

        $("[name='datos[tipo]']").val(tipo); 

        $.ajax({

          url:URL+"functions/productosservicios/segmentos.php", 

          type:"POST", 

          data: {"idgrupo":id}, 

          dataType: "json",

          }).done(function(msg){  

            var sHtml="<option value=''>Seleccione una opción</option>"; 

            msg.segmentos.forEach(function(element,index){

              sHtml+="<option value='"+element.idSegmento+"'>"+element.codigo+" - "+element.nombre+"</option>"; 

            })



            $("[name='datos[segmento]']").html(sHtml);

        });

    }else{

      $("[name='datos[tipo]']").val(""); 

      $("[name='datos[segmento]']").html("<option value=''>Seleccione una opción</option>");

    }

    

})



$("body").on("change","[name='datos[segmento]']",function(e){

    var id=$(this).val(); 

    if(id!=""){

        $.ajax({

          url:URL+"functions/productosservicios/familias.php", 

          type:"POST", 

          data: {"idsegmento":id}, 

          dataType: "json",

          }).done(function(msg){  

            var sHtml="<option value=''>Seleccione una opción</option>"; 

            msg.familias.forEach(function(element,index){

              sHtml+="<option value='"+element.idFamilia+"'>"+element.codigo+" - "+element.nombre+"</option>"; 

            })



            $("[name='datos[familia]']").html(sHtml);

        });

    }else{

      $("[name='datos[familia]']").html("<option value=''>Seleccione una opción</option>");

    }

    

})



$("body").on("change","[name='datos[familia]']",function(e){

    var id=$(this).val(); 

    if(id!=""){

        $.ajax({

          url:URL+"functions/productosservicios/clases.php", 

          type:"POST", 

          data: {"idfamilia":id}, 

          dataType: "json",

          }).done(function(msg){  

            var sHtml="<option value=''>Seleccione una opción</option>"; 

            msg.clases.forEach(function(element,index){

              sHtml+="<option value='"+element.idClase+"'>"+element.codigo+" - "+element.nombre+"</option>"; 

            })



            $("[name='datos[clase]']").html(sHtml);

        });

    }else{

      $("[name='datos[clase]']").html("<option value=''>Seleccione una opción</option>");

    }

    

})



$("body").on("change","[name='datos[clase]']",function(e){

    var id=$(this).val(); 

    if(id!=""){

        $.ajax({

          url:URL+"functions/productosservicios/bienservicio.php", 

          type:"POST", 

          data: {"idclase":id,"tipo":$("[name='datos[tipo]']").val()}, 

          dataType: "json",

          }).done(function(msg){  

            var sHtml="<option value=''>Seleccione una opción</option>"; 

            msg.bienes.forEach(function(element,index){

              valor=element.idBienes; 

              

              sHtml+="<option value='"+valor+"'>"+element.codigo+" - "+element.nombre+"</option>"; 

            })



            $("[name='datos[bien]']").html(sHtml);

        });

    }else{

      $("[name='datos[bien]']").html("<option value=''>Seleccione una opción</option>");

    }

    

})





$('input[type=radio][name="datos[inventario]"]').change(function() {
    var id=this.value;
    var idEmpresa=document.getElementById('datos[idEmpresa]').value;
    if (id == 1) {

        $.ajax({

          url:URL+"functions/inventario/consultarinventario.php", 

          type:"POST", 

          data: {"idEmpresa":idEmpresa}, 

          dataType: "json",

          }).done(function(msg){  

            var sHtml="<option value=''>Seleccione una opción</option>"; 

            msg.inventario.forEach(function(element,index){

              var valor=element.idProducto; 

             

              sHtml+="<option value='"+valor+"'>"+element.producto+"</option>"; 

            })



            $("[name='datos[idInventario]']").html(sHtml);

        });

    }
    else if (id == 2) {
        
        var sHtml="<option value=''>No inventario</option>";
        $("[name='datos[idInventario]']").html(sHtml);

       
    }
});






$("body").on("click",".registrar",function(e){

	var posicion=$(this).parents(".filaItem").index(".filaItem"); 

	var valor=$(this).parents(".filaItem").find(".producto").val(); 

	$("[name='datos[nombre]']").val(valor); 

	$("#btnGuardarProducto").attr("position",posicion); 

})



$("body").on("click","#btnGuardarProducto",function(e){

    e.preventDefault();

      if(true === $("#frmGuardarProducto").parsley().validate()){

        var texto="Servicio"; 

          if($("[name='datos[tipo]']").val()==1){

            var texto="Producto"; 

          }



          Swal.fire({

            title: 'Está seguro?',

            text: 'Está a punto de guardar un nuevo '+texto+'!',

            icon: 'warning', 

            showCancelButton: true,

            showLoaderOnConfirm: true,

            confirmButtonText: `Si, Guardar!`,

            cancelButtonText:'Cancelar',

            preConfirm: function(result) {

              return new Promise(function(resolve) {

                var formu = document.getElementById("frmGuardarProducto");

            

                var data = new FormData(formu);

                $.ajax({

                url:URL+"functions/productosservicios/guardarproductoservicio.php", 

                type:"POST", 

                data: data,

                contentType:false, 

                processData:false, 

                dataType: "json",

                cache:false 

                }).done(function(msg){  

                  if(msg.msg){



                    $(".producto").eq($("#btnGuardarProducto").attr("position")).val(msg.nombre).removeClass("no-producto")

                    $(".idProducto").eq($("#btnGuardarProducto").attr("position")).val(msg.id)

                    $(".idProducto").eq($("#btnGuardarProducto").attr("position")).parents("td").find("span").remove(); 

                    $("#modalProducto").modal("toggle"); 

                    swal.close();

                  }else{

                    swal({   

                      title: "Algo ha salido mal!",   

                      text: "Revise su conexión a internet",

                      type: "error",        

                      closeOnConfirm: true 

                      }).then((element)=>{

                        

                      });

                  }

                

              });    

              });

            }

          }).then((result) => {

            if (result.isConfirmed) {

              // var formu = document.getElementById("frmGuardarProducto");

            

              //   var data = new FormData(formu);

              //   $.ajax({

              //   url:URL+"functions/productosservicios/guardarproductoservicio.php", 

              //   type:"POST", 

              //   data: data,

              //   contentType:false, 

              //   processData:false, 

              //   dataType: "json",

              //   cache:false 

              //   }).done(function(msg){  

              //     if(msg.msg){



              //       $(".producto").eq($("#btnGuardarProducto").attr("position")).val(msg.nombre).removeClass("no-producto")

              //       $(".idProducto").eq($("#btnGuardarProducto").attr("position")).val(msg.id)

              //       $(".idProducto").eq($("#btnGuardarProducto").attr("position")).parents("td").find("span").remove(); 

              //       $("#modalProducto").modal("toggle")

              //     }else{

              //       swal({   

              //         title: "Algo ha salido mal!",   

              //         text: "Revise su conexión a internet",

              //         type: "error",        

              //         closeOnConfirm: true 

              //         }).then((element)=>{

                        

              //         });

              //     }

                

              // });

            } 

          })



      }

  })





$("body").on("change","#tipoDeduccion",function(e){

	if($(this).val()==1||$(this).val()==2){

		$(".concepto-select").removeClass("ocultar")

		$(".baseimpuestos").removeClass("ocultar")

		$(".concepto-texto").addClass("ocultar")

		$(".boton-agregar").addClass("col-md-2").removeClass("col-md-3")

		$(".valor").addClass("col-md-2").removeClass("col-md-3")

		$("#valor").attr("readonly","readonly"); 

     $.ajax({

          url:URL+"functions/configuracion/listarretencioneica.php", 

          type:"POST", 

          data: {"tipo":$(this).val()}, 

          dataType: "json",

          }).done(function(msg){  

            var sHtml="<option value=''>Seleccione una opción</option>"; 

            msg.retenciones.forEach(function(element,index){

              var ciudad=""; 

              if(element.ciudad!=""){

                ciudad="("+element.ciudad+")"; 

              }

              sHtml+="<option porcentaje='"+element.valor+"' value='"+element.idRetencion+"'>"+element.valor+"% - "+element.descripcion+" "+ciudad+"</option>"; 

            })



            $("#conceptoSelect").html(sHtml);

        });

	}else{

		$(".concepto-select").addClass("ocultar")

		$(".baseimpuestos").addClass("ocultar")

		$(".concepto-texto").removeClass("ocultar")

		$(".boton-agregar").addClass("col-md-3").removeClass("col-md-2")

		$(".valor").addClass("col-md-3").removeClass("col-md-2")

		$("#valor").removeAttr("readonly")

		

	}

})



$("body").on("change","#baseImpuestos",function(e){



   var base=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($(this).val(),"$",""),".",""),",","."))

   var subtotal=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($('[name="datos[subtotal]"]').val(),"$",""),".",""),",","."))

   if(base>subtotal){

    swal({   

      title: "Algo ha salido mal!",   

      text: "La base de impuestos no puede ser mayor al subtotal",

      type: "error",        

      closeOnConfirm: true 

      }).then((element)=>{

        $("#baseImpuestos").val("")

      });

      return false; 

   }

  if($("#conceptoSelect").val()!=""){

    var porcentaje=parseFloat($("#conceptoSelect").find("option:selected").attr("porcentaje")); 

    var valor=base*(porcentaje/100); 

    $("#valor").val(valor).trigger("change"); 

  }

})





$("body").on("click","#btnAgregar",function(e){

  var tipo=$("#tipoDeduccion").val(); 

  var tipoDeduccion=$("#tipoDeduccion").find("option:selected").html(); 



  var concepto=$("#conceptoText").val(); 

  var idConcepto=''; 

  var base=0; 

  if($("#tipoDeduccion").val()==1||$("#tipoDeduccion").val()==2){

    concepto=$("#conceptoSelect").find("option:selected").html()

    idConcepto=$("#conceptoSelect").val(); 

    base=$("#baseImpuestos").val(); 

  }

  var valor=$("#valor").val(); 

  if(valor!=""){

    var valorMoneda=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda(valor,"$",""),".",""),",","."));

  }

  

  var cantidad=$("#tableDeducciones tbody tr").length; 

  var totalDeduccion=0; 

  var totalPago=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($("[name='datos[total]']").val(),"$",""),".",""),",","."));

  if($("[name='datos[totalDeduccion]']").val()!=""){

    totalDeduccion=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($("[name='datos[totalDeduccion]']").val(),"$",""),".",""),",","."));

  }



  if((totalDeduccion+valorMoneda)>totalPago){

    Swal.fire(

      {

        icon: 'error',

        title: 'Algo ha salido mal!',

        text: 'El valor de las deducciones no puede superar el valor del pago',

        closeOnConfirm: true,

      }

      ).then((result) => {

       $("#valor").val("")

      })

      return false;

  }

  if(concepto!=""&&tipo!=""&&valor!=""){

    

    if(base!=""){

      base=eliminarMoneda(eliminarMoneda(eliminarMoneda(base,"$",""),".",""),",",".");

    }



    $("#tableDeducciones tbody:last").append("<tr>"

    +"<td><input type='hidden' name='impuesto["+cantidad+"][tipoDeduccion]' id='item["+cantidad+"][tipoDeduccion]' class='form-control tipoDeduccion' value='"+tipo+"' >"

    +"<input type='hidden' name='impuesto["+cantidad+"][concepto]' id='item["+cantidad+"][concepto]' class='form-control concepto' value='"+concepto+"' >"

    +"<input type='hidden' name='impuesto["+cantidad+"][idConcepto]' id='item["+cantidad+"][idConcepto]' class='form-control idConcepto' value='"+idConcepto+"' >"

    +"<input type='hidden' name='impuesto["+cantidad+"][baseImpuestos]' id='item["+cantidad+"][baseImpuestos]' class='form-control baseImpuestos' value='"+base+"' >"

    +"<input type='hidden' name='impuesto["+cantidad+"][valor]' id='item["+cantidad+"][valor]' class='form-control valor' value='"+valorMoneda+"' >"
    +"<input type='hidden' name='impuesto["+cantidad+"][idFacturaCompraDeduccion]' id='item["+cantidad+"][idFacturaCompraDeduccion]' class='form-control idFacturaCompraDeduccion' value='"+0+"' >"+
      tipoDeduccion+"</td>"

    +"<td>"+concepto+"</td>"

    +"<td>"+valor+"</td>"

    +"<td><a href='javascript:void(0)' data-toggle='tooltip' id='eliminar' data-placement='top' title='Eliminar' class='btnEliminar btn btn-icon btn-sm btn-danger'><i class='fas fa-trash'></i></a></td>"

    +"</tr>"); 



    $("#tipoDeduccion").val(''); 

    $("#conceptoText").val(''); 

    $("#conceptoSelect").val('');

    $("#valor").val('');

    $("#baseImpuestos").val('');

  }

  calcularDeduccion(); 

})



$("body").on("change","[name='datos[amortizacion]']",function(e){

  calcularDeduccion(); 

})

calcularDeduccion=function(){

  var valor=0;

  $("#tableDeducciones .valor").each(function(index,element){

    valor+=parseFloat($(element).val()); 

  })

  var valorTotal=eliminarMoneda(eliminarMoneda(eliminarMoneda($("[name='datos[total]']").val(),"$",""),".",""),",","."); 

  var amortizacion=eliminarMoneda(eliminarMoneda(eliminarMoneda($("[name='datos[amortizacion]']").val(),"$",""),".",""),",","."); 

  $("[name='datos[totalDeduccion]']").val(valor).trigger("change");

  pago=valorTotal-valor-amortizacion; 

  $("[name='datos[totalPago]']").val(pago).trigger("change");

}



$("body").on("click",".btnEliminar",function(e){

  $(this).parents("tr").css("background-color","#f0d0d0"); 

  var elemento=this; 

  setTimeout(function(){

    $(elemento).parents("tr").remove();

    $("#tableDeducciones tbody tr").each(function(index,element){

      $(element).find(".tipoDeduccion").attr("id","item["+index+"][tipoDeduccion]").attr("name","item["+index+"][tipoDeduccion]")

      $(element).find(".concepto").attr("id","item["+index+"][concepto]").attr("name","item["+index+"][concepto]")

      $(element).find(".idConcepto").attr("id","item["+index+"][idConcepto]").attr("name","item["+index+"][idConcepto]")

      $(element).find(".baseImpuestos").attr("id","item["+index+"][baseImpuestos]").attr("name","item["+index+"][baseImpuestos]")

      $(element).find(".valor").attr("id","item["+index+"][valor]").attr("name","item["+index+"][valor]")

    })

    

    calcularDeduccion(); 

  },500)

})



$("body").on("change",".egreso",function(e){



  var fecha=$("[name='datos[fechaPagoReal]']").val(); 

  var comprobante=$("[name='datos[comprobante]']").val(); 

  if(fecha!=""||comprobante!=""){

    $("[name='datos[fechaPagoReal]']").attr("required","required"); 

    $("[name='datos[comprobante]']").attr("required","required"); 

  }else{

    $("[name='datos[fechaPagoReal]']").removeAttr("required"); 

    $("[name='datos[comprobante]']").removeAttr("required"); 

  }

})





$("body").on("click","#btnGuardar",function(e){

    e.preventDefault();

      if($(".registrar").is(":visible")){

        Swal.fire(

          {

            icon: 'error',

            title: 'Algo ha salido mal!',

            text: 'Faltan productos por registrar',

            closeOnConfirm: true,

          }

        )

        return false;

      }

      if(true === $("#frmGuardar").parsley().validate()){



        Swal.fire({

            title: 'Está seguro?',

            text: 'Está a punto de realizar la gestión a esta factura!',

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

                url:URL+"functions/facturacompra/guardargestionfactura.php", 

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

                      title: 'Gestión realizada!',

                      text: 'con exito',

                      closeOnConfirm: true,

                    }).then((result) => {

                      // window.history.back(); 
                      location.href=URL+"listarfacturasrecibidas"; 

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

            //   url:URL+"functions/facturacompra/guardargestionfactura.php", 

            //   type:"POST", 

            //   data: data,

            //   contentType:false, 

            //   processData:false, 

            //   dataType: "json",

            //   cache:false 

            //   }).done(function(msg){  

            //     if(msg.msg){

            //       Swal.fire(

            //         icon: 'success',

            //         title: 'Gestión realizada!',

            //         text: 'con exito',

            //         closeOnConfirm: true,

            //       ).then((result) => {

            //         window.history.back(); 

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



      }

  })



$("body").on("change","[name='datos[formaPago]']",function(e){

  // $(this).val()
    if($("#radioCuentaBancaria").is(':checked')){
      $("#selectCuenta").css("display", "block");
      $("#selectCaja").css("display", "none");
    }
    if($("#radioCaja").is(':checked')){
      $("#selectCuenta").css("display", "none");
      
      $("#selectCaja").css("display", "block");
    }
})

$("body").on("change","[name='datos[radioPago]']",function(e){

  // $(this).val()
    if($("#radioPagoTotal").is(':checked')){
      $("#divAbono").css("display", "none");
      $("#abono").removeAttr("required");
      // $("#selectCaja").css("display", "none");
    }
    if($("#radioAbono").is(':checked')){
      $("#divAbono").css("display", "block");
      $("#abono").attr("required", "required");
      
      // $("#selectCaja").css("display", "block");
    }
})



$("body").on("change","[name='datos[radioEnlazar]']",function(e){

  // $(this).val()
    if($("#radioNoEnlazar").is(':checked')){
      $("#divEnlazarFactura").css("display", "none");
      $("#enlazarFactura").removeAttr("required");
      // $("#selectCaja").css("display", "none");
    }
    if($("#radioEnlazar").is(':checked')){
      $("#divEnlazarFactura").css("display", "block");
      $("#enlazarFactura").attr("required", "required");
      
      // $("#selectCaja").css("display", "block");
    }
})