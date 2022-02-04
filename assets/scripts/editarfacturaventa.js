
$("body").on("click","#btnGuardar",function(e){

    e.preventDefault();

      if(true === $("#frmGuardar").parsley().validate()){

          Swal.fire({

          title: 'Está seguro?',

          text: 'Está a punto de editar los datos de la factura!',

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

            url:URL+"functions/facturaventa/editarfacturaventa.php", 

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

                  title: "Factura actualizada!",

                  text: 'con exito',

                  closeOnConfirm: true,

                }

                ).then((result) => {

                 window.history.back(); 

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

// $("body").on("change",".conceptoSelect",function(e){
//   var texto = $(this).find('option:selected').text();
//   var idConceptoSelect=$(this).attr("id");
//    var numeroConceptoSelect= idConceptoSelect.substring(15,16);
//    var conceptoSelectTexto="conceptoSelectTexto["+numeroConceptoSelect+"]";
//    inputConceptoSelectTexto=document.getElementById(conceptoSelectTexto).value=texto;

//    var baseId="baseImpuestos["+numeroConceptoSelect+"]";
//    var base=parseInt(eliminarMoneda(eliminarMoneda(eliminarMoneda(document.getElementById(baseId).value,"$",""),".",""),",","."));

//    var conceptoS="conceptoSelect["+numeroConceptoSelect+"]";
//    var valueConcepto=document.getElementById(conceptoS);

//    var valorS="valor["+numeroConceptoSelect+"]";
//    var valorF=document.getElementById(valorS);
//   if(valueConcepto.value !=""){
    
//     // var porcentaje=valueConcepto.getAttribute("porcentaje");
//     var porcentaje=valueConcepto.options[valueConcepto.selectedIndex].text;
//     var valorPorcentaje=parseFloat(porcentaje.split("%")[0]);
//     var valor=base*(valorPorcentaje/100); 
//     valorF.value=valor; 

//   }



//    sumar_columnas();
  
// });
$("body").on("change",".conceptoSelect",function(e){
  var texto = $(this).find('option:selected').text();
  var idConceptoSelect=$(this).attr("id");
   // var numeroConceptoSelect= idConceptoSelect.substring(15,16);
   // var conceptoSelectTexto="conceptoSelectTexto["+numeroConceptoSelect+"]";
   // inputConceptoSelectTexto=document.getElementById(conceptoSelectTexto).value=texto;

   // var baseId="baseImpuestos["+numeroConceptoSelect+"]";
   var base=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($(this).parents("tr").find(".baseImpuestos").val(),"$",""),".",""),",","."));

var porcentaje=$(this).parents("tr").find(".conceptoSelect option:selected").attr("porcentaje"); 
  var concepto=$(this).parents("tr").find(".conceptoSelect option:selected").text(); 
  $(this).parents("tr").find(".conceptoTexto").val(concepto).trigger("change"); 

  var  valor=base*(porcentaje/100);


  $(this).parents("tr").find(".valorDeduccion").val(valor).trigger("change");


   // var conceptoS="conceptoSelect["+numeroConceptoSelect+"]";
   // var valueConcepto=document.getElementById(conceptoS);

   // var valorS="valor["+numeroConceptoSelect+"]";
   // var valorF=document.getElementById(valorS);
  // if(valueConcepto.value !=""){
    
  //   // var porcentaje=valueConcepto.getAttribute("porcentaje");
  //   var porcentaje=valueConcepto.options[valueConcepto.selectedIndex].text;
  //   var valorPorcentaje=parseFloat(porcentaje.split("%")[0]);
  //   var valor=base*(valorPorcentaje/100); 
  //   valorF.value=valor; 

  // }



   sumar_columnas();
   calcularDeduccion();
  
});

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

$("body").on("change",".baseImpuestos",function(e){



   var base=parseInt(eliminarMoneda(eliminarMoneda(eliminarMoneda($(this).val(),"$",""),".",""),",","."));
   var idBase=$(this).attr("id");
   // var numero= idBase.substring(14,15);
   
   var subtotal=parseInt(eliminarMoneda(eliminarMoneda(eliminarMoneda($('[name="datos[subtotal]"]').val(),"$",""),".",""),",","."))

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
   var porcentaje=$(this).parents("tr").find(".conceptoSelect option:selected").attr("porcentaje"); 
  var concepto=$(this).parents("tr").find(".conceptoSelect option:selected").text(); 
  $(this).parents("tr").find(".conceptoTexto").val(concepto).trigger("change"); 

  var  valor=base*(porcentaje/100);


  $(this).parents("tr").find(".valorDeduccion").val(valor).trigger("change");

  sumar_columnas();
  calcularDeduccion();
})



$("#tableDeducciones").on("input", "input", function() {
  var input = $(this);

  sumar_columnas();
  
});



$("body").on("change","#amortizacion",function(e){



   var amortizacion=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($(this).val(),"$",""),".",""),",","."));
 
  sumar_columnas();
})



//esta funcion suma los valores que cambian en la columna de deducciones
function sumar_columnas(){
var sumDeducciones=0;
var cont=0;
var total=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($('[name="datos[totalFactura]"]').val(),"$",""),".",""),",","."));

var amortizacion=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($('[name="datos[amortizacion]"]').val(),"$",""),".",""),",","."));

    //itera cada input de clase .valorDeduccion y la suma
    $('.valorDeduccion').each(function() { 
      var valorDeduccion=eliminarMoneda(eliminarMoneda(eliminarMoneda($(this).val(),"$",""),".",""),",",".");
      sumDeducciones +=parseFloat(valorDeduccion);   
    }); 
    var totalPagar=total-sumDeducciones-amortizacion;
    $("#totalDeduccion").val(sumDeducciones).trigger("change");
    $("#totalPago").val(totalPagar).trigger("change");
}



$("body").on("change",".tipoDeduccion",function(e){

  if($(this).val()==1||$(this).val()==2){


    var idTipo=$(this).attr("id");
    var numeroTipo= idTipo.substring(14,15);
    
    var conceptoS="conceptoSelect["+numeroTipo+"]";
    var conceptoSelect=document.getElementById(conceptoS);


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



           conceptoSelect.innerHTML=sHtml;

        });

  }else{

    // $(".concepto-select").addClass("ocultar")

    // $(".baseimpuestos").addClass("ocultar")

    // $(".concepto-texto").removeClass("ocultar")

    // $(".boton-agregar").addClass("col-md-3").removeClass("col-md-2")

    // $(".valor").addClass("col-md-3").removeClass("col-md-2")

    // $("#valor").removeAttr("readonly")

    

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

  var totalPago=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($("[name='datos[totalPago]']").val(),"$",""),".",""),",","."));

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

    +"<input type='hidden' name='impuesto["+cantidad+"][valor]' id='item["+cantidad+"][valor]' class='form-control valorSumar' value='"+valorMonedaSumar+"' >"+

      tipoDeduccion+"</td>"

    +"<td>"+concepto+"</td>"

    +"<td>"+base+"</td>"

    +"<td>"+valor+"</td>"

    // +"<td><a href='javascript:void(0)' data-toggle='tooltip' id='eliminar' data-placement='top' title='Eliminar' class='btnEliminar btn btn-icon btn-sm btn-danger'><i class='fas fa-trash'></i></a></td>"

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
$('.decimales').keyup(function () { 
    this.value = this.value.replace(/[^0-9\,]/g,'');
    

});

$("body").on("change","#baseImpuestos",function(e){



   var base=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($(this).val(),"$",""),".",""),",","."));

   var subtotal=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($('[name="datos[subtotal]"]').val(),"$",""),".",""),",","."));

   if(base>subtotal){

    swal({   

      title: "Algo ha salido mal!",   

      text: "La base de impuestos no puede ser mayor al subtotal",

      type: "error",        

      closeOnConfirm: true 

      }).then((element)=>{

        $("#baseImpuestos").val("");

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

  $("#tableDeducciones .valorSumar").each(function(index,element){

    // parseFloat(.val()); 
    var tipo=$("[name='impuesto["+index+"][tipoDeduccion]']").val();  
    var concepto =$("[name='impuesto["+index+"][idConcepto]']").val();  

    if (concepto!=33) {
      valor+=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($(element).val(),"$",""),".",""),",",".")); 
    }
  })

 var valorTotal=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($("[name='datos[totalFactura]']").val(),"$",""),".",""),",",".")); 

  var amortizacion=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($("[name='datos[amortizacion]']").val(),"$",""),".",""),",",".")); 

  $("[name='datos[totalDeduccion]']").val(valor).trigger("change");

  pago=valorTotal-valor-amortizacion; 

  $("[name='datos[totalPago]']").val(pago).trigger("change");

}