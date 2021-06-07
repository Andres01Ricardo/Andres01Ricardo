var aDatos=[]; 

$( window ).on( "load", function() {
  cargarProducto();

  

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





$("body").on("keyup",".cantidad, .valorUnitario, .iva",function(e){

	var cantidad=eliminarMoneda($(this).parents("tr").find(".cantidad").val(),",","."); 

  var iva=eliminarMoneda($(this).parents("tr").find(".iva").val(),",","."); 

	if(iva=="")iva=0;

	if($(this).parents("tr").find(".valorUnitario").val()!=""){var valorUnitario=eliminarMoneda(eliminarMoneda(eliminarMoneda($(this).parents("tr").find(".valorUnitario").val(),"$",""),".",""),",","."); }else{ var valorUnitario=0}

	subtotal=parseFloat(cantidad)*parseFloat(valorUnitario); 

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

  calcularDeduccion(); 

}



// $("body").on("click touchstart","[name='datos[tipoCompra]']",function(e){

//     cargarProducto(); 

// })





$("body").on("click touchstart","#btnGuardar",function(e){

    e.preventDefault();

      if(true === $("#frmGuardar").parsley().validate()){

        Swal.fire({

          title: 'Está seguro?',

          text: 'Está a punto de enviar está factura para su gestión!',

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

            url:URL+"functions/facturacompra/guardarfactura.php", 

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

                  title: "Factura enviada!",

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

          //   url:URL+"functions/facturacompra/guardarfactura.php", 

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

          //         title: "Factura enviada!",

          //         text: 'con exito',

          //         closeOnConfirm: true,

          //       }

          //       ).then((result) => {

          //        window.history.back(); 

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

          //   text: 'Está a punto de enviar está factura para su gestión!',

          //   icon: 'warning',

          //   buttons: {

          //       confirm : {text:'Si, Enviar!',className:'sweet-warning',closeModal:false},

          //       cancel : 'Cancelar' 

          //   },

          //   dangerMode: true,

          // })

          //   .then((willDelete) => {

          //     if (willDelete) {

          //       var formu = document.getElementById("frmGuardar");

            

          //       var data = new FormData(formu);

          //       $.ajax({

          //       url:URL+"functions/facturacompra/guardarfactura.php", 

          //       type:"POST", 

          //       data: data,

          //       contentType:false, 

          //       processData:false, 

          //       dataType: "json",

          //       cache:false 

          //       }).done(function(msg){  

          //         if(msg.msg){



          //           swal({   

          //             title: "Factura enviada!",   

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



$("body").on("change","[name='datos[idEmpresa]']",function(e){

    var id=$(this).val(); 

    if(id!=""){

      cargarProducto(); 

      $.ajax({

        url:URL+"functions/facturacompra/proveedorempresa.php", 

        type:"POST", 

        data: {"idEmpresa":id}, 

        dataType: "json",

        }).done(function(msg){  

          var sHtml="<option value=''>Seleccione una opción</option>"; 

          msg.lista.forEach(function(element,index){

            sHtml+="<option value='"+element.idProveedor+"'>"+element.razonSocial+"</option>"; 

          })



          $("[name='datos[idProveedor]']").html(sHtml);

      });

    }else{

      $("[name='datos[idProveedor]']").html("<option value=''>Seleccione una opción</option>");

    }

    

})


$( '.tipoCompra' ).on( 'click touchstart', function() {
  cargarProducto();
});


// if($("[name='datos[idEmpresa']").val()!=""){

//     cargarProducto();

//   }


cargarProducto=function(){

  var idB=$("[name='datos[tipoCompraB]']");
  var idS=$("[name='datos[tipoCompraS]']");
  var id=1;
    if( idB.is(':checked') && idS.is(':checked') ){
        // Hacer algo si el checkbox ha sido seleccionado
        id=3;
    } else if( idB.is(':checked') ){
        // Hacer algo si el checkbox ha sido deseleccionado
        id=1;
    }else if( idS.is(':checked') ){
        // Hacer algo si el checkbox ha sido deseleccionado
        id=2;
    }

    if(id!="" && $("[name='datos[idEmpresa]'").val()!=""){

      var titulo="Servicios"; 

      if(id==1){

        titulo="Productos"; 

        $("#tableProductos thead tr").find("th").eq(1).html(titulo); 

      }

      $.ajax({

        url:URL+"functions/productosservicios/listarproductosservicios.php", 

        type:"POST", 

        data: {"tipo":id,"idEmpresa":$("[name='datos[idEmpresa]'").val()}, 

        dataType: "json",

        }).done(function(msg){ 
          console.log(msg); 

          aDatos=[]; 

          $(".producto").val("");

          $(".idProducto").val("");

          msg.forEach(function(element,index){

          aDatos.push({

              value: element.idProductoServicio,

              label: element.codigo+" - "+element.nombre,

            })

        })

          console.log(aDatos);
        autocomplete(); 

      });

    }else{

      $(".producto").val("");

    }

}



$('[data-toggle="tooltip"]').tooltip()





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

    if (valorMoneda!="") {

    var valorMonedaSumar=eliminarMoneda(valorMoneda.toString(),".",",");
    // alert(valorMonedaSumar);
    }


    $("#tableDeducciones tbody:last").append("<tr>"

    +"<td><input type='hidden' name='impuesto["+cantidad+"][tipoDeduccion]' id='item["+cantidad+"][tipoDeduccion]' class='form-control tipoDeduccion' value='"+tipo+"' >"

    +"<input type='hidden' name='impuesto["+cantidad+"][concepto]' id='item["+cantidad+"][concepto]' class='form-control concepto' value='"+concepto+"' >"

    +"<input type='hidden' name='impuesto["+cantidad+"][idConcepto]' id='item["+cantidad+"][idConcepto]' class='form-control idConcepto' value='"+idConcepto+"' >"

    +"<input type='hidden' name='impuesto["+cantidad+"][baseImpuestos]' id='item["+cantidad+"][baseImpuestos]' class='form-control baseImpuestos' value='"+base+"' >"

    +"<input type='hidden' name='impuesto["+cantidad+"][valor]' id='item["+cantidad+"][valor]' class='form-control valor' value='"+valorMonedaSumar+"' >"+

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

calcularDeduccion=function(){

  var valor=0;

  $("#tableDeducciones .valor").each(function(index,element){

    // valor+=parseFloat($(element).val()); 
    valor+=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($(element).val(),"$",""),".",""),",",".")); 

  })

  // var valorTotal=eliminarMoneda(eliminarMoneda($("[name='datos[total]']").val(),",",""),"$",""); 

  // var amortizacion=eliminarMoneda(eliminarMoneda($("[name='datos[amortizacion]']").val(),",",""),"$",""); 
  var valorTotal=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($("[name='datos[total]']").val(),"$",""),".",""),",",".")); 

  // var amortizacion=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($("[name='datos[amortizacion]']").val(),"$",""),".",""),",",".")); 


  $("[name='datos[totalDeduccion]']").val(valor).trigger("change");
  pago=valorTotal-valor; 

  $("[name='datos[totalPago]']").val(pago).trigger("change");

  // pago=valorTotal-valor-amortizacion; 

  // $("[name='datos[totalPago]']").val(pago).trigger("change");

    // parseFloat(.val()); 
}



// $("body").on("change","[name='datos[total]']",function(e){
//     calcularDeduccion();
// })