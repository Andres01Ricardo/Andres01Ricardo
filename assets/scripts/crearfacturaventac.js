var aDatos=[]; 
var aDatosC=[]; 
var datos=[]; 


$( window ).on( "load", function() {
  cargarProducto();

  $.ajax({
    url:URL+"functions/facturacompra/consultariva.php", 
    type:"POST", 
    data: {"empresa":$("[name='datos[idEmpresa]'").val(),"tipoFactura":'venta'}, 
    dataType: "json",
    }).done(function(msg){  
        if(msg.length!=0){
            console.log('aca');
            console.log(msg);
        }
        if(msg.length==0){
          Swal.fire(
          {
            icon: 'error',
            title: "El IVA de la factura no se encuentra parametrizado!",   
            text: "Por favor parametrice la cuenta contable",
            closeOnConfirm: true,
          })
          
        }
      })

})

cargarProducto=function(){

  if($("[name='datos[idEmpresa]'").val()!=""){
    var idEmpresa=$("[name='datos[idEmpresa]'").val();
    var id=3;
  $.ajax({

      url:URL+"functions/productosservicios/listarproductoscontable.php", 

      type:"POST", 

      // data: {"idEmpresa":$("[name='datos[idEmpresa']").val()}, 
      data: {"tipo":id,"idEmpresa":$("[name='datos[idEmpresa]'").val()}, 

      dataType: "json",

      }).done(function(msg){ 
        aDatos=[];  
        // console.log("tipo");
        // console.log(msg.tipo);
        // if (msg.tipo==1) {
          
        //   msg.productos.forEach(function(element,index){
            
        //     // console.log("productosFOR");
        //     // console.log(msg.productos);
        //     aDatos.push({
        //         value: element.idProductoContable,
        //         label: element.codigo+" - "+element.descripcion,
                
        //       })
        //   })
        // }
        // if (msg.tipo==2) {
          
          msg.productos.forEach(function(element,index){
            aDatos.push({
                value: element.idProductoServicio,
                label: element.codigo+" - "+element.nombre,
              })
          })
        // }
        $("#tipoProdcutos").val(msg.tipo);
        autocomplete(); 
    });  
      var idEmpresa=$("[name='datos[idEmpresa]'").val();
      $.ajax({
        url:URL+"functions/cuentascontables/cargarcuentascontables.php", 
        type:"POST", 
        data: {"idEmpresa":idEmpresa}, 
        dataType: "json",
        }).done(function(msg){  
          // var $aDatos=[];
          // console.log(msg);
          if (msg.length==0) {
            $(".cuentaContable").val('No hay cuentas contables creadas');
            $(".cuentaContable").attr('disabled','disabled');

          }
          if (msg.length!=0) {
            var sHtml='<option value="">Seleccione</option>';

          msg.forEach(function(element,index){
            sHtml+='<option value="'+element.idCuentaContable+'">'+element.codigoCuentaContable+' - '+element.nombre+'</option>';
            
          })
          $("#formaPagoCuenta").html(sHtml);
          
          // autocomplete(); 
        }
        }); 
          
            // console.log(datos);
            // autocompleteCuentas(); 
      


          $.ajax({
          url:URL+"functions/facturacompra/consultarcuentatotal.php", 
          type:"POST", 
          data: {"empresa":$("[name='datos[idEmpresa]'").val(),"tipoFactura":'venta'}, 
          dataType: "json",
          }).done(function(msg){  

              if(msg.length!=0){

                  console.log('aca');
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
              // if(msg.length==0){
                
              //   Swal.fire(
              //   {
              //     icon: 'error',
              //     title: "El total a pagar no se encuentra parametrizado!",   
              //     text: "Por favor parametrice la cuenta contable",
              //     closeOnConfirm: true,
              //   }).then((element)=>{

              //     // $( ".registrar" ).eq(index).removeClass('ocultar');

              //   });
              // }

            })

          // $.ajax({

          //   url:URL+"functions/centrocosto/cargarcentrocosto.php", 

          //   type:"POST", 

          //   data: {"idEmpresa":idEmpresa}, 

          //   dataType: "json",

          //   }).done(function(msg){  

          //     msg.forEach(function(element,index){

          //       aDatosC.push({

          //           value: element.idCentroCosto,

          //           label: element.codigoCentroCosto+'-'+element.centroCosto,

          //         })

          //     })

          //     autocompleteC(); 


          // }); 

    }else{

      $(".producto").val("");

    }




}

$('.decimales').keyup(function () { 
    this.value = this.value.replace(/[^0-9\,]/g,'');


});


// autocompleteC=function(){
//   $( ".centroCosto" ).autocomplete({
//       minLength: 0,
//       source: aDatosC,
//       focus: function( event, ui ) {
//         var index=$(this).index(".centroCosto");
//         // $( ".centroCosto" ).eq(index).val( ui.item.label );
//         // $( ".idCentroCosto" ).eq(index).val( ui.item.value );
//         return false;
//       },
//       select: function( event, ui ) {
//         var index=$(this).index(".centroCosto");
//         $( ".centroCosto" ).eq(index).val( ui.item.label );
//         $( ".idCentroCosto" ).eq(index).val( ui.item.value );
//         $( ".letreroCentroCosto" ).eq(index).addClass('ocultar');        
//         var id=ui.item.value;
//         aDatosSC=[];
//         $.ajax({
//           url:URL+"functions/centrocosto/cargarsubcentrocosto.php", 
//           type:"POST", 
//           data: {"idCentroCosto":id}, 
//           dataType: "json",
//           }).done(function(msg){  
//             console.log(msg);
//             msg.forEach(function(element,index){
//               aDatosSC.push({
//                   value: element.idSubcentroCosto,
//                   label: element.codigoSubcentroCosto+' - '+element.subcentroCosto,
//                 })
//             })
//             autocompleteSC(); 
//         });   
//         return false;
//       },
//       change: function(event, ui){
//         var index=$(this).index(".centroCosto");
//         if(ui.item==null){
//           $( ".idCentroCosto" ).eq(index).val('');
//         }
//         return false;
//       }
//     })
// }

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
        var idEmpresa = $("[name='datos[idEmpresa]'").val();
        console.log("imprimir");
        console.log($("#tipoProdcutos").val());
        
            $.ajax({
            url:URL+"functions/facturacompra/consultarcuentaproducto.php", 
            type:"POST", 
            data: {"producto":ui.item.value ,"empresa":idEmpresa,"tipoFactura":'venta',"tipoProdcutos":$("#tipoProdcutos").val()}, 
            dataType: "json",
            }).done(function(msg){   
            console.log(msg);          
                if(msg.length!=0){
                    console.log(msg);
                }
                if(msg.length==0){
                  Swal.fire(
                  {
                    icon: 'error',
                    title: "El producto no se encuentra parametrizado!",   
                    text: "Por favor parametrice la cuenta contable",
                    closeOnConfirm: true,
                  })
                  // .then((element)=>{
                    // $( ".registrar" ).eq(index).removeClass('ocultar');
                  // });
                }
              })

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

$("body").on("change","[name='datos[idEmpresa]']",function(e){

    var id=$(this).val(); 
    cargarProducto();

    if(id!=""){
      $.ajax({
        url:URL+"functions/facturaventa/proveedoresempresa.php", 
        type:"POST", 
        data: {"idEmpresa":id}, 
        dataType: "json",
        }).done(function(msg){  

          var sHtml="<option value=''>Seleccione una opción</option>"; 
          msg.lista.forEach(function(element,index){
            sHtml+="<option value='"+element.idTercero+"'>"+element.razonSocial+"</option>"; 
          })

          $("[name='datos[idCliente]']").html(sHtml);
      });
    }else{
      $("[name='datos[idCliente]']").html("<option value=''>Seleccione una opción</option>");
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

  var valorTotal=eliminarMoneda(eliminarMoneda($("[name='datos[total]']").val(),".",""),"$",""); 
  $("[name='datos[totalPago]']").val(valorTotal).trigger("change");

}



$("body").on("click touchstart","#agregar",function(e){

  $('select.flexselect').removeData("flexselect");

  var sHtml=$("#tableProductos tbody tr:first").html(); 

  var cant=$("#tableProductos tbody tr").length; 

  $("#tableProductos tbody").append("<tr>"+sHtml+"</tr>"); 

  

  // $("#tableProductos tbody tr:last").find("td").eq(0).html(cant+1); 
   $("#tableProductos tbody tr:last").find("td").eq(0).html(cant+1+'<span style="margin-right: 2px; color: red;" data-toggle="modal" data-target="#modalProducto" class="registrar ocultar" id="item['+cant+'][registrar]" numero="'+cant+'"><i class="fas fa-star-of-life" data-toggle="tooltip" data-placement="top" title="Debe parametrizar la cuenta contable de este producto"></i></span>'); 



  $("#tableProductos tbody tr:last").find(".registrar").attr("id","item["+cant+"][registrar]");



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

      // $(element).find("td").eq(0).html(index+1); 
      $(element).find("td").eq(0).html(cant+1+'<span style="margin-right: 2px; color: red;" data-toggle="modal" data-target="#modalProducto" class="registrar ocultar" id="item['+index+'][registrar]" numero="'+cant+'"><i class="fas fa-star-of-life" data-toggle="tooltip" data-placement="top" title="Debe parametrizar la cuenta contable de este producto"></i></span>'); 



      // $(element).find(".producto").attr("id","item["+index+"][producto]").attr("name","item["+index+"][producto]").val("");

      // $(element).find(".idProducto").attr("id","item["+index+"][idProducto]").attr("name","item["+index+"][idProducto]").val("");

      // $(element).find(".descripcion").attr("id","item["+index+"][descripcion]").attr("name","item["+index+"][descripcion]").val(""); 

      // $(element).find(".cantidad").attr("id","item["+index+"][cantidad]").attr("name","item["+index+"][cantidad]").val(""); 

      // $(element).find(".idUnidad").attr("id","item["+index+"][idUnidad]").attr("name","item["+index+"][idUnidad]").val(""); 

      // $(element).find(".valorUnitario").attr("id","item["+index+"][valorUnitario]").attr("name","item["+index+"][valorUnitario]").val(''); 

      // $(element).find(".subtotal").attr("id","item["+index+"][subtotal]").attr("name","item["+index+"][subtotal]").val(""); 

      // $(element).find(".iva").attr("id","item["+index+"][iva]").attr("name","item["+index+"][iva]").val(''); 

      // $(element).find(".total").attr("id","item["+index+"][total]").attr("name","item["+index+"][total]").val('');


      $(element).find(".producto").attr("id","item["+index+"][producto]").attr("name","item["+index+"][producto]");
      $(element).find(".idProducto").attr("id","item["+index+"][idProducto]").attr("name","item["+index+"][idProducto]");
      $(element).find(".descripcion").attr("id","item["+index+"][descripcion]").attr("name","item["+index+"][descripcion]");
      $(element).find(".cantidad").attr("id","item["+index+"][cantidad]").attr("name","item["+index+"][cantidad]");
      $(element).find(".idUnidad").attr("id","item["+index+"][idUnidad]").attr("name","item["+index+"][idUnidad]");
      $(element).find(".valorUnitario").attr("id","item["+index+"][valorUnitario]").attr("name","item["+index+"][valorUnitario]");
      $(element).find(".subtotal").attr("id","item["+index+"][subtotal]").attr("name","item["+index+"][subtotal]");
      $(element).find(".iva").attr("id","item["+index+"][iva]").attr("name","item["+index+"][iva]");
      $(element).find(".total").attr("id","item["+index+"][total]").attr("name","item["+index+"][total]");

    })

    

    autocomplete(); 

  }

  

})




$("body").on("change","[name='datos[comprobante]']",function(e){
    // var id=$(this).val(); 
    var idEmpresa=$("#idEmpresa").val();
      var tipoDocumento=$("#tipoDocumento").val();
      var comprobante=$(this).val();
    
      $.ajax({
        url:URL+"functions/comprobantes/cargarnumerocomprobante.php", 
        type:"POST", 
        data: {"tipoDocumento":tipoDocumento,"idEmpresa":idEmpresa,"comprobante":comprobante}, 
        dataType: "json",
        }).done(function(msg){  
          // console.log(msg.comprobanteNumero[0].numeracionActual);
          // var sHtml="<option value=''>Seleccione una opción</option>"; 
          // msg.comprobante.forEach(function(element,index){
          //   sHtml+="<option value='"+element.idParametrosDocumentos+"'>"+element.comprobante+' - '+element.descripcion+"</option>"; 
          // })
          // $("[name='datos[comprobante]']").html(sHtml);
          $("#numeroComprobante").val(msg.comprobanteNumero[0].numeracionActual).trigger('change');
      });
});





$("body").on("click touchstart","#btnGuardar",function(e){
  console.log($("[name='datos[idEmpresa]'").val());
  console.log($("[name='datos[nroFactura]'").val());
  
  $.ajax({
            url:URL+"functions/facturaventa/consultarfacturaventa.php", 
            type:"POST", 
            data: {"idEmpresa":$("[name='datos[idEmpresa]'").val(),"nroFactura":$("[name='datos[nroFactura]'").val()},
            dataType: "json",
            }).done(function(msg){  
              if(msg.msg){
               // if (msg.numeroComprobante!=0) {
                  
                  // -----------------------------------------------------------------------------------------------------------------------------------------------

                  e.preventDefault();
                    if(true === $("#frmGuardar").parsley().validate()){
                       Swal.fire({
                      title: 'Está seguro?',
                      text: 'Está a punto de crear una nueva factura de venta!',
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
                          url:URL+"functions/facturaventa/guardarfacturaventa.php", 
                          type:"POST", 
                          data: data,
                          contentType:false, 
                          processData:false, 
                          dataType: "json",
                          cache:false 
                          }).done(function(msg){  
                            if(msg.msg){
                             if (msg.numeroComprobante!=0) {
                                Swal.fire({
                                  icon: 'success',
                                  title: "Factura enviada con exito!",
                                  text: 'comprobante: '+msg.numeroComprobante,
                                  closeOnConfirm: true,
                                }
                                ).then((result) => {
                                 location.reload();  
                                })
                               }
                              if (msg.numeroComprobante==0) {
                                Swal.fire({
                                  icon: 'success',
                                  title: "Factura enviada con exito!",
                                  text: 'no se pudo crear el comprobante ',
                                  closeOnConfirm: true,
                                }
                                ).then((result) => {
                                 location.reload();  
                                })
                               } 
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

                  // -----------------------------------------------------------------------------------------------------------------------------------------------
                  
                  
                 // }                
              }else{
                 Swal.fire(
                  'Este número de factura ya existe!',
                  'Verifique que sea el número correcto',
                  'error'
                ).then((result) => {
                })
              }
          });
    
  })

// -------------------------------------------------------------------------------------------------------------------------------------
//           $.ajax({
//             url:URL+"functions/facturaventa/consultarfacturaventa.php", 
//             type:"POST", 
//             data: {"idEmpresa":$("[name='datos[idEmpresa']").val(),"nroFactura":$("[name='datos[nroFactura']").val()},
//             dataType: "json",
//             }).done(function(msg){  
//               if(msg.msg){
//                if (msg.numeroComprobante!=0) {
                  


                  
//                  }                
//               }else{
//                  Swal.fire(
//                   'Este número de factura ya existe!',
//                   'Verifique que sea el número correcto',
//                   'error'
//                 ).then((result) => {
//                 })
//               }
//           });
// -------------------------------------------------------------------------------------------------------------------------------------
// var aDatos=[]; 

// $(document).ready(function(e){



// 	$.ajax({

// 	    url:URL+"functions/productosservicios/listarproductosservicios.php", 

// 	    type:"POST", 

// 	    data: {"idEmpresa":$("[name='datos[idEmpresa']").val()}, 

// 	    dataType: "json",

// 	    }).done(function(msg){  

// 	      msg.forEach(function(element,index){

// 	      	aDatos.push({

// 			        value: element.idProductoServicio,

// 			        label: element.codigo+" - "+element.nombre,

// 			      })

// 	      })

// 	      autocomplete(); 

// 	  });   

// })

// $('.decimales').keyup(function () { 
//     this.value = this.value.replace(/[^0-9\.]/g,'');


// });

// autocomplete=function(){

// 	$( ".producto" ).autocomplete({

//       minLength: 0,

//       source: aDatos,

//       focus: function( event, ui ) {

//       	var index=$(this).index(".producto")

//         $( ".producto" ).eq(index).val( ui.item.label );

//         $( ".idProducto" ).eq(index).val( ui.item.value );

//         return false;

//       },

//       select: function( event, ui ) {

//       	var index=$(this).index(".producto")

//         $( ".producto" ).eq(index).val( ui.item.label );

//         $( ".idProducto" ).eq(index).val( ui.item.value );

        

//         return false;

//       },

//       change: function(event, ui){

//         var index=$(this).index(".producto")



//         if(ui.item==null){

//           $( ".idProducto" ).eq(index).val('');

//         }

//         return false;

//       }

//     })

// }



// $("body").on("change","[name='datos[idEmpresa]']",function(e){

//     var id=$(this).val(); 

//     if(id!=""){

//       $.ajax({

//         url:URL+"functions/facturaventa/proveedoresempresa.php", 

//         type:"POST", 

//         data: {"idEmpresa":id}, 

//         dataType: "json",

//         }).done(function(msg){  

//           var sHtml="<option value=''>Seleccione una opción</option>"; 

//           msg.lista.forEach(function(element,index){

//             sHtml+="<option value='"+element.idCliente+"'>"+element.razonSocial+"</option>"; 

//           })



//           $("[name='datos[idCliente]']").html(sHtml);

//       });

//     }else{

//       $("[name='datos[idCliente]']").html("<option value=''>Seleccione una opción</option>");

//     }

    

// })



// $("body").on("keyup",".cantidad, .valorUnitario, .iva",function(e){

//   var cantidad=$(this).parents("tr").find(".cantidad").val(); 

//   var iva=$(this).parents("tr").find(".iva").val(); 

//   if(iva=="")iva=0;

//   if($(this).parents("tr").find(".valorUnitario").val()!=""){var valorUnitario=eliminarMoneda(eliminarMoneda($(this).parents("tr").find(".valorUnitario").val(),"$",""),",",""); }else{ var valorUnitario=0}

//   subtotal=parseFloat(cantidad)*parseFloat(valorUnitario); 

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



// $("body").on("click touchstart","#agregar",function(e){

//   $('select.flexselect').removeData("flexselect");

//   var sHtml=$("#tableProductos tbody tr:first").html(); 

//   var cant=$("#tableProductos tbody tr").length; 

//   $("#tableProductos tbody").append("<tr>"+sHtml+"</tr>"); 

  

//   $("#tableProductos tbody tr:last").find("td").eq(0).html(cant+1); 



//   $("#tableProductos tbody tr:last").find(".producto").attr("id","item["+cant+"][producto]").attr("name","item["+cant+"][producto]").val("");

//   $("#tableProductos tbody tr:last").find(".idProducto").attr("id","item["+cant+"][idProducto]").attr("name","item["+cant+"][idProducto]").val("");

//   $("#tableProductos tbody tr:last").find(".descripcion").attr("id","item["+cant+"][descripcion]").attr("name","item["+cant+"][descripcion]").val(""); 

//   $("#tableProductos tbody tr:last").find(".cantidad").attr("id","item["+cant+"][cantidad]").attr("name","item["+cant+"][cantidad]").val(""); 

//   $("#tableProductos tbody tr:last").find(".idUnidad").attr("id","item["+cant+"][idUnidad]").attr("name","item["+cant+"][idUnidad]").val(""); 

//   $("#tableProductos tbody tr:last").find(".valorUnitario").attr("id","item["+cant+"][valorUnitario]").attr("name","item["+cant+"][valorUnitario]").val(''); 

//   $("#tableProductos tbody tr:last").find(".subtotal").attr("id","item["+cant+"][subtotal]").attr("name","item["+cant+"][subtotal]").val(""); 

//   $("#tableProductos tbody tr:last").find(".iva").attr("id","item["+cant+"][iva]").attr("name","item["+cant+"][iva]").val(''); 

//   $("#tableProductos tbody tr:last").find(".total").attr("id","item["+cant+"][total]").attr("name","item["+cant+"][total]").val('');

//   autocomplete(); 

// })





// $("body").on("click touchstart",".eliminar",function(e){



//   var cant=$("#tableProductos tbody tr").length; 

//   if(cant>1){

//     $('select.flexselect').removeData("flexselect");

//     $(this).parents("tr").remove(); 

//     $("#tableProductos tbody tr").each(function(index,element){

//       $(element).find("td").eq(0).html(index+1); 



//       // $(element).find(".producto").attr("id","item["+index+"][producto]").attr("name","item["+index+"][producto]").val("");

//       // $(element).find(".idProducto").attr("id","item["+index+"][idProducto]").attr("name","item["+index+"][idProducto]").val("");

//       // $(element).find(".descripcion").attr("id","item["+index+"][descripcion]").attr("name","item["+index+"][descripcion]").val(""); 

//       // $(element).find(".cantidad").attr("id","item["+index+"][cantidad]").attr("name","item["+index+"][cantidad]").val(""); 

//       // $(element).find(".idUnidad").attr("id","item["+index+"][idUnidad]").attr("name","item["+index+"][idUnidad]").val(""); 

//       // $(element).find(".valorUnitario").attr("id","item["+index+"][valorUnitario]").attr("name","item["+index+"][valorUnitario]").val(''); 

//       // $(element).find(".subtotal").attr("id","item["+index+"][subtotal]").attr("name","item["+index+"][subtotal]").val(""); 

//       // $(element).find(".iva").attr("id","item["+index+"][iva]").attr("name","item["+index+"][iva]").val(''); 

//       // $(element).find(".total").attr("id","item["+index+"][total]").attr("name","item["+index+"][total]").val('');

//     })

    

//     autocomplete(); 

//   }

  

// })



// $("body").on("click touchstart","#btnGuardar",function(e){

//     e.preventDefault();

//       if(true === $("#frmGuardar").parsley().validate()){

//          Swal.fire({

//         title: 'Está seguro?',

//         text: 'Está a punto de crear una nueva factura de venta!',

//         icon: 'warning', 

//         showCancelButton: true,

//         showLoaderOnConfirm: true,

//         confirmButtonText: `Si, Guardar!`,

//         cancelButtonText:'Cancelar',

//         preConfirm: function(result) {

//           return new Promise(function(resolve) {

//             var formu = document.getElementById("frmGuardar");

      

//             var data = new FormData(formu);

//             $.ajax({

//             url:URL+"functions/facturaventa/guardarfactura.php", 

//             type:"POST", 

//             data: data,

//             contentType:false, 

//             processData:false, 

//             dataType: "json",

//             cache:false 

//             }).done(function(msg){  

//               if(msg.msg){

//                 Swal.fire(

//                   {

//                   icon: 'success',

//                   title: 'Factura enviada!',

//                   text: 'con exito',

//                   closeOnConfirm: true,

//                 }

//                 ).then((result) => {

//                  location.reload(); 

//                 })

//               }else{

//                  Swal.fire(

//                   'Algo ha salido mal!',

//                   'Verifique su conexión a internet',

//                   'error'

//                 ).then((result) => {

                  

//                 })

//               }

            

//           });

//           });

//         }

//       }).then((result) => {

//         if (result.isConfirmed) {

//         //   var formu = document.getElementById("frmGuardar");

      

//         //   var data = new FormData(formu);

//         //   $.ajax({

//         //   url:URL+"functions/facturaventa/guardarfactura.php", 

//         //   type:"POST", 

//         //   data: data,

//         //   contentType:false, 

//         //   processData:false, 

//         //   dataType: "json",

//         //   cache:false 

//         //   }).done(function(msg){  

//         //     if(msg.msg){

//         //       Swal.fire(

//         //         {

//         //         icon: 'success',

//         //         title: 'Factura enviada!',

//         //         text: 'con exito',

//         //         closeOnConfirm: true,

//         //       }

//         //       ).then((result) => {

//         //        location.reload(); 

//         //       })

//         //     }else{

//         //        Swal.fire(

//         //         'Algo ha salido mal!',

//         //         'Verifique su conexión a internet',

//         //         'error'

//         //       ).then((result) => {

                

//         //       })

//         //     }

          

//         // });

//         } 



//        })



      

//           // swal({

//           //   title: 'Está seguro?',

//           //   text: 'Está a punto de crear una nueva factura de venta!',

//           //   icon: 'warning',

//           //   buttons: {

//           //       confirm : {text:'Si, Guardar!',className:'sweet-warning',closeModal:false},

//           //       cancel : 'Cancelar' 

//           //   },

//           //   dangerMode: true,

//           // })

//           //   .then((willDelete) => {

//           //     if (willDelete) {

//           //       var formu = document.getElementById("frmGuardar");

            

//           //       var data = new FormData(formu);

//           //       $.ajax({

//           //       url:URL+"functions/facturaventa/guardarfactura.php", 

//           //       type:"POST", 

//           //       data: data,

//           //       contentType:false, 

//           //       processData:false, 

//           //       dataType: "json",

//           //       cache:false 

//           //       }).done(function(msg){  

//           //         if(msg.msg){



//           //           swal({   

//           //             title: "Factura enviada!",   

//           //             text: "con exito",

//           //             type: "success",        

//           //             closeOnConfirm: true 

//           //             }).then((element)=>{

//           //               location.reload(); 

//           //             })

//           //         }else{

//           //           swal({   

//           //             title: "Algo ha salido mal!",   

//           //             text: "Verifique su conexión a internet",

//           //             type: "error",        

//           //             closeOnConfirm: true 

//           //             }).then((element)=>{

                        

//           //             });

//           //         }

                

//           //     });

//           //     } else {

                

//           //     }

//           //   });

            

       

//       }

//   })


autocompleteCuentas=function(){
  $( ".cuentaContable" ).autocomplete({
      minLength: 0,
      source: datos,
      focus: function( event, ui ) {
        var index=$(this).index(".cuentaContable");
        $( ".cuentaContable" ).eq(index).val( ui.item.label );
        $( ".idCuentaContable" ).eq(index).val( ui.item.value );
        $( ".naturaleza" ).eq(index).val( ui.item.naturaleza );
        return false;
      },
      select: function( event, ui ) {
        var index=$(this).index(".cuentaContable");
        $( ".cuentaContable" ).eq(index).val( ui.item.label );
        $( ".idCuentaContable" ).eq(index).val( ui.item.value );
        $( ".naturaleza" ).eq(index).val( ui.item.naturaleza );
        var id=ui.item.value;
        return false;
      },
      change: function(event, ui){
        var index=$(this).index(".cuentaContable");
        if(ui.item==null){
          $( ".idCuentaContable" ).eq(index).val('');
        }
        return false;
      }
    })
}



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

    $.ajax({
      url:URL+"functions/facturacompra/consultarretencion.php", 
      type:"POST", 
      data: {"empresa":$("[name='datos[idEmpresa]'").val(),"tipoFactura":'venta',"idImpuesto":idConcepto}, 
      dataType: "json",
      }).done(function(msg){

        if(msg.length==0){

          Swal.fire(
          {
            icon: 'error',
            title: "El impuesto no se encuentra parametrizado!",   
            text: "Por favor parametrice la cuenta contable",
            closeOnConfirm: true,
          })
        }
      })

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

      // base=eliminarMoneda(eliminarMoneda(eliminarMoneda(base,".",""),"$",""),",",".");
      base=eliminarMoneda(eliminarMoneda(base,".",""),"$","");

    }


    var valorMonedaF=eliminarMoneda(eliminarMoneda(valor,"$",""),".","");
    // var valorMoneda=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda(valor,"$",""),".",""),",","."));


    $("#tableDeducciones tbody:last").append("<tr>"

    +"<td><input type='hidden' name='impuesto["+cantidad+"][tipoDeduccion]' id='item["+cantidad+"][tipoDeduccion]' class='form-control tipoDeduccion' value='"+tipo+"' >"

    +"<input type='hidden' name='impuesto["+cantidad+"][concepto]' id='item["+cantidad+"][concepto]' class='form-control concepto' value='"+concepto+"' >"

    +"<input type='hidden' name='impuesto["+cantidad+"][idConcepto]' id='item["+cantidad+"][idConcepto]' class='form-control idConcepto' value='"+idConcepto+"' >"

    +"<input type='hidden' name='impuesto["+cantidad+"][baseImpuestos]' id='item["+cantidad+"][baseImpuestos]' class='form-control baseImpuestos' value='"+base+"' >"

    +"<input type='hidden' name='impuesto["+cantidad+"][valor]' id='item["+cantidad+"][valor]' class='form-control valor' value='"+valorMonedaF+"' >"+

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

    // $("#valor").attr("readonly","readonly"); 

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



   var base=parseInt(eliminarMoneda(eliminarMoneda(eliminarMoneda($(this).val(),".",""),"$",""),",","."))

   var subtotal=parseInt(eliminarMoneda(eliminarMoneda(eliminarMoneda($('[name="datos[subtotal]"]').val(),".",""),"$",""),",","."))

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


    // $("#valor").val(Math.round(valor)).trigger("change");
    $("#valor").val(valor).trigger("change");  
    $("#valor").formatCurrency({decimalSymbol:',',digitGroupSymbol:'.'}); 

  }

})

calcularDeduccion=function(){

  var valor=0;
  var pago = 0.0;

  $("#tableDeducciones .valor").each(function(index,element){

    // valor+=parseFloat($(element).val()); 
    var tipo=$("[name='impuesto["+index+"][tipoDeduccion]']").val();  
    var concepto =$("[name='impuesto["+index+"][idConcepto]']").val();  

    if (concepto!=33) {
      valor+=parseFloat(eliminarMoneda($(element).val(),",","."));
    }


  })

  var valorTotal=eliminarMoneda(eliminarMoneda(eliminarMoneda($("[name='datos[total]']").val(),".",""),"$",""),",","."); 

  // var amortizacion=eliminarMoneda(eliminarMoneda($("[name='datos[amortizacion]']").val(),".",""),"$",""); 
  // var valorF=eliminarMoneda(valor,".",",");
  $("[name='datos[totalDeduccion]']").val(valor).trigger("change");

  pago=valorTotal-valor; 
  // alert(valor);

  $("[name='datos[totalPago]']").val(pago).trigger("change");

}


// $("body").on("click","#btnAgregar",function(e){

//   var tipo=$("#tipoDeduccion").val(); 

//   var tipoDeduccion=$("#tipoDeduccion").find("option:selected").html(); 



//   var concepto=$("#conceptoText").val(); 

//   var idConcepto=''; 

//   var base=0; 

//   if($("#tipoDeduccion").val()==1||$("#tipoDeduccion").val()==2){

//     concepto=$("#conceptoSelect").find("option:selected").html()

//     idConcepto=$("#conceptoSelect").val(); 

//     base=$("#baseImpuestos").val(); 

//   }

//   var valor=$("#valor").val(); 

//   if(valor!=""){

//     var valorMoneda=parseFloat(eliminarMoneda(eliminarMoneda(valor,",",""),"$",""));

//   }

  

//   var cantidad=$("#tableDeducciones tbody tr").length; 

//   var totalDeduccion=0; 

//   var totalPago=parseFloat(eliminarMoneda(eliminarMoneda($("[name='datos[total]']").val(),",",""),"$",""));

//   if($("[name='datos[totalDeduccion]']").val()!=""){

//     totalDeduccion=parseFloat(eliminarMoneda(eliminarMoneda($("[name='datos[totalDeduccion]']").val(),",",""),"$",""));

//   }



//   if((totalDeduccion+valorMoneda)>totalPago){

//     Swal.fire(

//       {

//         icon: 'error',

//         title: 'Algo ha salido mal!',

//         text: 'El valor de las deducciones no puede superar el valor del pago',

//         closeOnConfirm: true,

//       }

//       ).then((result) => {

//        $("#valor").val("")

//       })

//       return false;

//   }

//   if(concepto!=""&&tipo!=""&&valor!=""){

    

//     if(base!=""){

//       base=eliminarMoneda(eliminarMoneda(base,",",""),"$","");

//     }



//     $("#tableDeducciones tbody:last").append("<tr>"

//     +"<td><input type='hidden' name='impuesto["+cantidad+"][tipoDeduccion]' id='item["+cantidad+"][tipoDeduccion]' class='form-control tipoDeduccion' value='"+tipo+"' >"

//     +"<input type='hidden' name='impuesto["+cantidad+"][concepto]' id='item["+cantidad+"][concepto]' class='form-control concepto' value='"+concepto+"' >"

//     +"<input type='hidden' name='impuesto["+cantidad+"][idConcepto]' id='item["+cantidad+"][idConcepto]' class='form-control idConcepto' value='"+idConcepto+"' >"

//     +"<input type='hidden' name='impuesto["+cantidad+"][baseImpuestos]' id='item["+cantidad+"][baseImpuestos]' class='form-control baseImpuestos' value='"+base+"' >"

//     +"<input type='hidden' name='impuesto["+cantidad+"][valor]' id='item["+cantidad+"][valor]' class='form-control valor' value='"+valorMoneda+"' >"+

//       tipoDeduccion+"</td>"

//     +"<td>"+concepto+"</td>"

//     +"<td>"+valor+"</td>"

//     +"<td><a href='javascript:void(0)' data-toggle='tooltip' id='eliminar' data-placement='top' title='Eliminar' class='btnEliminar btn btn-icon btn-sm btn-danger'><i class='fas fa-trash'></i></a></td>"

//     +"</tr>"); 



//     $("#tipoDeduccion").val(''); 

//     $("#conceptoText").val(''); 

//     $("#conceptoSelect").val('');

//     $("#valor").val('');

//     $("#baseImpuestos").val('');

//   }

//   calcularDeduccion(); 

// })





// $("body").on("change","#tipoDeduccion",function(e){

//   if($(this).val()==1||$(this).val()==2){

//     $(".concepto-select").removeClass("ocultar")

//     $(".baseimpuestos").removeClass("ocultar")

//     $(".concepto-texto").addClass("ocultar")

//     $(".boton-agregar").addClass("col-md-2").removeClass("col-md-3")

//     $(".valor").addClass("col-md-2").removeClass("col-md-3")

//     $("#valor").attr("readonly","readonly"); 

//      $.ajax({

//           url:URL+"functions/configuracion/listarretencioneica.php", 

//           type:"POST", 

//           data: {"tipo":$(this).val()}, 

//           dataType: "json",

//           }).done(function(msg){  

//             var sHtml="<option value=''>Seleccione una opción</option>"; 

//             msg.retenciones.forEach(function(element,index){

//               var ciudad=""; 

//               if(element.ciudad!=""){

//                 ciudad="("+element.ciudad+")"; 

//               }

//               sHtml+="<option porcentaje='"+element.valor+"' value='"+element.idRetencion+"'>"+element.valor+"% - "+element.descripcion+" "+ciudad+"</option>"; 

//             })



//             $("#conceptoSelect").html(sHtml);

//         });

//   }else{

//     $(".concepto-select").addClass("ocultar")

//     $(".baseimpuestos").addClass("ocultar")

//     $(".concepto-texto").removeClass("ocultar")

//     $(".boton-agregar").addClass("col-md-3").removeClass("col-md-2")

//     $(".valor").addClass("col-md-3").removeClass("col-md-2")

//     $("#valor").removeAttr("readonly")

    

//   }

// })

// $("body").on("change","#baseImpuestos",function(e){



//    var base=parseInt(eliminarMoneda(eliminarMoneda($(this).val(),",",""),"$",""))

//    var subtotal=parseInt(eliminarMoneda(eliminarMoneda($('[name="datos[subtotal]"]').val(),",",""),"$",""))

//    if(base>subtotal){

//     swal({   

//       title: "Algo ha salido mal!",   

//       text: "La base de impuestos no puede ser mayor al subtotal",

//       type: "error",        

//       closeOnConfirm: true 

//       }).then((element)=>{

//         $("#baseImpuestos").val("")

//       });

//       return false; 

//    }

//   if($("#conceptoSelect").val()!=""){

//     var porcentaje=parseFloat($("#conceptoSelect").find("option:selected").attr("porcentaje")); 

//     var valor=base*(porcentaje/100); 
//     valor=valor.toFixed(2);

//     $("#valor").val(valor).trigger("change"); 

//   }

// })

// calcularDeduccion=function(){

//   var valor=0;

//   $("#tableDeducciones .valor").each(function(index,element){

//     valor+=parseFloat($(element).val()); 

//   })

//   // var valorTotal=eliminarMoneda(eliminarMoneda($("[name='datos[total]']").val(),",",""),"$",""); 

//   // var amortizacion=eliminarMoneda(eliminarMoneda($("[name='datos[amortizacion]']").val(),",",""),"$",""); 
//   valor=valor.toFixed(2);

//   $("[name='datos[totalDeduccion]']").val(valor).trigger("change");

//   // pago=valorTotal-valor-amortizacion; 

//   // $("[name='datos[totalPago]']").val(pago).trigger("change");

// }



$("body").on("click touchstart",".btnEliminar",function(e){

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




$("body").on("change","[name='datos[formaPagoFactura]']",function(e){

  // alert($(this).val());

  if ($(this).val()==0) {
    $("#modalFormaPago").modal('show');
  }
    // if($("#radioNoEnlazar").is(':checked')){
    //   $("#divEnlazarFactura").css("display", "none");
    //   $("#enlazarFactura").removeAttr("required");
    // }
    // if($("#radioEnlazar").is(':checked')){
    //   $("#divEnlazarFactura").css("display", "block");
    //   $("#enlazarFactura").attr("required", "required");
    // }
})





$("body").on("click touchstart","#btnGuardarFormaPago",function(e){

    e.preventDefault();

      if(true === $("#frmGuardarFormaPago").parsley().validate()){

         Swal.fire({

        title: '¿Está seguro?',

        text: 'Está a punto de crear una nueva forma de pago!',

        icon: 'warning', 

        showCancelButton: true,

        showLoaderOnConfirm: true,

        confirmButtonText: `Si, Guardar!`,

        cancelButtonText:'Cancelar',

        preConfirm: function(result) {

          return new Promise(function(resolve) {

            var formu = document.getElementById("frmGuardarFormaPago");

      

            var data = new FormData(formu);

            $.ajax({

            url:URL+"functions/contable/guardarconfiguracioncontablebanco.php", 

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

                  title: 'Forma pago creada!',

                  text: 'con exito',

                  closeOnConfirm: true,

                }

                ).then((result) => {
                 var idEmpresa = $("[name='datos[idEmpresa]'").val();
                  console.log(idEmpresa);
                  $.ajax({
                    url:URL+"functions/facturaventa/cargarformapago.php", 
                    type:"POST", 
                    data: {"idEmpresa":idEmpresa}, 
                    dataType: "json",
                    }).done(function(msg){  
                      console.log(msg);

                      var  sHtmlC="<optgroup label='Crear forma de pago'><option value=''>Seleccione</option><option value='0'><i class='fas fa-plus-circle' >+ NUEVO</i></option></optgroup><optgroup label='Formas de pago existentes:'>"; 
                      msg.forEach(function(element,index){
                        sHtmlC+="<option value='"+element.idBancoCuentaContable+"'>"+element.nombre+"</option>"; 
                      })
                        sHtmlC+="</optgroup>"; 
                      $("#formaPagoFactura").html(sHtmlC);
                      $("#modalFormaPago").modal('hide');
                  });



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




$("body").on("change","[name='datos[tipoDocumento]']",function(e){
  var numero =$("#tipoDocumento").find("option:selected").attr("numeracion");
  console.log(numero);

  $("#numeroComprobante").val(numero);
});