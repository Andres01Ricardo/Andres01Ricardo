var aDatos=[]; 
var aDatosGrupo=[]; 
var aDatosCuenta=[]; 
var aDatosSubcuenta=[]; 
var aDatosC=[]; 
var aDatosT=[]; 
var debito=0;


$(document).ready(function(e){

  var divNombreComprobante =$("#divNombreComprobante");
  divNombreComprobante.css('display','none');
  var tabla = document.getElementById('tabla');
  if ($("#idEmpresa").val()== null) {
    tabla.style.display="none";
  }

  if ($("#idEmpresa").val()!= null) {
    aDatos=[]; 
    aDatosC=[]; 
    aDatosT=[]; 
    
    var idEmpresa=$("#idEmpresa").val();
    if (idEmpresa =="") {
      tabla.style.display="none";
    }
    if (idEmpresa !="") {
      tabla.style.display="block";
    }
    

    $.ajax({

        url:URL+"functions/cuentascontables/cargarcuentascontables.php", 

        type:"POST", 

        data: {"idEmpresa":idEmpresa}, 

        dataType: "json",

        }).done(function(msg){  

          msg.forEach(function(element,index){

            aDatos.push({

                value: element.idCuentaContable,

                label: element.codigoCuentaContable+" - "+element.nombre,

                naturaleza: element.naturaleza,

                tercero:element.tercero,

                centroCosto:element.centroCosto,

                detalle:element.detalle,

                porcentajeRetencion:element.porcentajeRetencion,

              })

          })

          autocomplete(); 


      }); 

      $.ajax({

        url:URL+"functions/centrocosto/cargarcentrocosto.php", 

        type:"POST", 

        data: {"idEmpresa":idEmpresa}, 

        dataType: "json",

        }).done(function(msg){  

          msg.forEach(function(element,index){

            aDatosC.push({

                value: element.idCentroCosto,

                label: element.codigoCentroCosto+'-'+element.centroCosto,

              })

          })

          autocompleteC(); 


      }); 
      $.ajax({
        url:URL+"functions/comprobantes/cargarcomprobantesguardados.php", 
        type:"POST", 
        data: {"idEmpresa":idEmpresa}, 
        dataType: "json",
        }).done(function(msg){  
          // console.log(msg);
          var sHtml="<option value=''>Seleccione una opción</option>"; 
          msg.forEach(function(element,index){
            sHtml+="<option value='"+element.idComprobanteRecurrente+"'>"+element.nombre+"</option>"; 
          })

          // autocompleteC(); 
          $("[name='datos[idComprobanteRecurrente]']").html(sHtml);
      }); 





var tipoDetalle=3;
// var idEmpresa=$("#idEmpresa").val();

aDatosT=[];

  $.ajax({

      url:URL+"functions/terceros/cargarterceros.php", 

      type:"POST", 

      data: {"idEmpresa":idEmpresa,"tipoDetalle":tipoDetalle}, 

      dataType: "json",

      }).done(function(msg){
      // console.log(msg);
       

        msg.forEach(function(element,index){
          if (element.idCliente !=null) {
               var tipo='c'; 
              }
              if (element.idProveedor !=null) {
               var tipo='p';
              }
              if (element.idEmpleado !=null) {
               var tipo='e';
              }
          aDatosT.push({

              value: element[0],

              label: element.nit+" - "+element.razonSocial,

              tipo: tipo,
               
            })

        })

        autocompleteT(); 


    }); 
    }

    if ($("#idCOmprobante").val()!="") {
      sumar_columnas();
    }


  $("#divPorcentajeRetencion").css("display","none");
  // idEmpresa=0;
  $.ajax({
      url:URL+"functions/cuentascontables/cargargrupos.php", 
      type:"POST", 
      data: {"idEmpresa":0}, 
      dataType: "json",
      }).done(function(msg){
        // console.log(msg);
        msg.forEach(function(element,index){
          aDatosGrupo.push({
              value: element.idGrupo,
              label: element.codigo+" - "+element.denominacion,
            })
        })
        autocompleteGrupo(); 
    }); 
})


$("body").on("change","#idComprobanteRecurrente",function(e){
  var idComprobanteRecurrente=$("#idComprobanteRecurrente").val();
  $.ajax({
        url:URL+"functions/comprobantes/cargarcomprobanteitems.php", 
        type:"POST", 
        data: {"idComprobanteRecurrente":idComprobanteRecurrente}, 
        dataType: "json",
        }).done(function(msg){  
          // console.log(msg);
          $("#tableProductos tbody tr").remove(); 
          var sHtml='';  
          msg.forEach(function(element,index){
          //   sHtml+="<option value='"+element.idComprobanteRecurrente+"'>"+element.nombre+"</option>"; 
          sHtml+='<tr>';
          var num=index+1;
          sHtml+='<td>'+num+'</td>';
sHtml+='<td><input type="text" name="item['+index+'][cuentaContable]" id="item['+index+'][cuentaContable]" class="form-control cuentaContable mayusculas" required placeholder="Cuenta" value="'+element.codigoCuenta+' - '+element.cuentaContable+'">';
sHtml+='<span name="item['+index+'][letreroCuentaContable]" id="item['+index+'][letreroCuentaContable]" class="ocultar letreroCuentaContable" style="color: red;">Cuenta no seleccionada correctamente</span><input type="hidden" name="item['+index+'][idCuentaContable]" id="item['+index+'][idCuentaContable]" class="form-control idCuentaContable"  required value="'+element.idCuentaContable+'"></td>';
if (element.codigoCentroCosto != null) {
sHtml+='<td><input type="text" class="form-control centroCosto mayusculas" name="item['+index+'][centroCosto]" id="item['+index+'][centroCosto]" placeholder="centro costo" value="'+element.codigoCentroCosto+'-'+element.centroCosto+'" ><input type="hidden" name="item['+index+'][idCentroCosto]" id="item['+index+'][idCentroCosto]" class="form-control idCentroCosto" value="'+element.idCentroCosto+'" ><span name="item['+index+'][letreroCentroCosto]" id="item['+index+'][letreroCentroCosto]" class="ocultar letreroCentroCosto" style="color: red;">Centro costo no seleccionado correctamente</span></td>';
}
if (element.codigoCentroCosto == null) {
  sHtml+='<td><input type="text" class="form-control centroCosto mayusculas" name="item['+index+'][centroCosto]" id="item['+index+'][centroCosto]" placeholder="centro costo" " ><input type="hidden" name="item['+index+'][idCentroCosto]" id="item['+index+'][idCentroCosto]" class="form-control idCentroCosto" ><span name="item['+index+'][letreroCentroCosto]" id="item['+index+'][letreroCentroCosto]" class="ocultar letreroCentroCosto" style="color: red;">Centro costo no seleccionado correctamente</span></td>';
}
if (element.codigoSubcentroCosto!=null) {
  sHtml+='<td><input type="text" class="form-control subcentroCosto mayusculas" name="item['+index+'][subcentroCosto]" id="item['+index+'][subcentroCosto]" placeholder="subcentro costo" value="'+element.codigoSubcentroCosto+'-'+element.subcentroCosto+'" ><input type="hidden" name="item['+index+'][idSubcentroCosto]" id="item['+index+'][idSubcentroCosto]" class="form-control idSubcentroCosto" value="'+element.idSubcentroCosto+'" ><span name="item['+index+'][letreroSubcentroCosto]" id="item['+index+'][letreroSubcentroCosto]" class="ocultar letreroSubcentroCosto" style="color: red;">Subcentro costo no seleccionado correctamente</span></td>';
}
if (element.codigoSubcentroCosto==null) {
  sHtml+='<td><input type="text" class="form-control subcentroCosto mayusculas" name="item['+index+'][subcentroCosto]" id="item['+index+'][subcentroCosto]" placeholder="subcentro costo" ><input type="hidden" name="item['+index+'][idSubcentroCosto]" id="item['+index+'][idSubcentroCosto]" class="form-control idSubcentroCosto"><span name="item['+index+'][letreroSubcentroCosto]" id="item['+index+'][letreroSubcentroCosto]" class="ocultar letreroSubcentroCosto" style="color: red;">Subcentro costo no seleccionado correctamente</span> </td>';
}
sHtml+='<td><input type="text" class="form-control  nit" name="item['+index+'][nit]" id="item['+index+'][nit]" placeholder="NIT" value="'+element.nit+' - '+element.razonSocial+'" ><input type="hidden" name="item['+index+'][idTercero]" id="item['+index+'][idTercero]" class="form-control idTercero" required value="'+element.idTercero+'" > <span name="item['+index+'][letreroTercero]" id="item['+index+'][letreroTercero]" class="ocultar letreroTercero" style="color: red;">Tercero no seleccionado correctamente</span><input type="hidden" name="item['+index+'][tipoTercero]" id="item['+index+'][tipoTercero]" class="form-control tipoTercero" ></td>';
sHtml+='<td><input type="text" class="form-control  descripcion mayusculas" name="item['+index+'][descripcion]" id="item['+index+'][descripcion]" placeholder="Descripción" required  value="'+element.descripcion+'"></td>';
if (element.base!="0") {
sHtml+='<td><input type="text" class="form-control  base moneda mayusculas" name="item['+index+'][base]" id="item['+index+'][base]" placeholder="Base/cruce" readonly value="'+element.base+'"></td>';
}
if (element.base=="0") {
sHtml+='<td><input type="text" class="form-control  base moneda mayusculas" name="item['+index+'][base]" id="item['+index+'][base]" placeholder="Base/cruce" readonly ></td>';
}
if (element.saldoDebito!="0") {
  sHtml+='<td><input type="text" class="form-control decimales moneda debito mayusculas" name="item['+index+'][debito]" id="item['+index+'][debito]" placeholder="Débito" value="'+element.saldoDebito+'"  ></td>';
}
if (element.saldoDebito=="0") {
  sHtml+='<td><input type="text" class="form-control decimales moneda debito mayusculas" name="item['+index+'][debito]" id="item['+index+'][debito]" placeholder="Débito" disabled  ></td>';
}
if (element.saldoCredito!="0") {
  sHtml+='<td><input type="text" class="form-control decimales moneda  credito mayusculas" name="item['+index+'][credito]" id="item['+index+'][credito]" placeholder="Crédito" value="'+element.saldoCredito+'" ></td>';          
}
if (element.saldoCredito=="0") {
  sHtml+='<td><input type="text" class="form-control decimales moneda  credito mayusculas" name="item['+index+'][credito]" id="item['+index+'][credito]" placeholder="Crédito" disabled ></td>';          
}
 sHtml+='<td class="centrar"><a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn btn-icon btn-sm btn-danger eliminar"><i class="fas fa-trash"></i></a></td>';
          sHtml+='</tr>';
})
    $("#tableProductos tbody").append(sHtml); 
    sumar_columnas();
  }); 


  $.ajax({
    url:URL+"functions/comprobantes/cargarcomprobante.php", 
    type:"POST", 
    data: {"idComprobanteRecurrente":idComprobanteRecurrente}, 
    dataType: "json",
    }).done(function(msg){  
      // console.log(msg);
      var sHtml="<option value=''>Seleccione una opción</option>"; 
      msg.forEach(function(element,index){
        sHtml+="<option value='"+element.idComprobanteRecurrente+"'>"+element.nombre+"</option>"; 
      })

      // autocompleteC(); 
      $("[name='datos[idComprobanteRecurrente]']").html(sHtml);
  });



})


$("body").on("change","#radioComprobanteRecurrente",function(e){
  if ($(this).is(':checked')) {
    $("#divNombreComprobante").css('display','block');
    $("#nombreComprobante").attr('required','required');
  }else{
    $("#divNombreComprobante").css('display','none');
    $("#nombreComprobante").removeAttr('required');
  }

    
})
  // console.log(tipoDocumento);
  // console.log(comprobante);
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
$("body").on("change","[name='datos[baseModal]'],[name='datos[porcentajeRetencion]']",function(e){

   
   var totalRetencion=(( parseFloat(eliminarMoneda($("#porcentajeRetencion").val(),",",".")) * parseFloat(eliminarMoneda($(this).val(),",",".")) ) / 100);
   $("#retencionModal").val(totalRetencion.toFixed(2));

})
$("body").on("change","[name='datos[idEmpresa]']",function(e){


  

  aDatos=[]; 
  aDatosC=[]; 
  aDatosT=[]; 
  
  var idEmpresa=$(this).val();
  if (idEmpresa =="") {
    tabla.style.display="none";
  }
  if (idEmpresa !="") {
    tabla.style.display="block";
  }
  

  $.ajax({

      url:URL+"functions/cuentascontables/cargarcuentascontables.php", 

      type:"POST", 

      data: {"idEmpresa":idEmpresa}, 

      dataType: "json",

      }).done(function(msg){  

        msg.forEach(function(element,index){

          aDatos.push({

              value: element.idCuentaContable,

              label: element.codigoCuentaContable+" - "+element.nombre,

              naturaleza: element.naturaleza,

              tercero:element.tercero,

              centroCosto:element.centroCosto,

              detalle:element.detalle,

              porcentajeRetencion:element.porcentajeRetencion,

            })

        })

        autocomplete(); 


    }); 

    $.ajax({

      url:URL+"functions/centrocosto/cargarcentrocosto.php", 

      type:"POST", 

      data: {"idEmpresa":idEmpresa}, 

      dataType: "json",

      }).done(function(msg){  

        msg.forEach(function(element,index){

          aDatosC.push({

              value: element.idCentroCosto,

              label: element.codigoCentroCosto+'-'+element.centroCosto,

            })

        })

        autocompleteC(); 


    });   


 

});


autocomplete=function(){

  $( ".cuentaContable" ).autocomplete({

      minLength: 0,

      source: aDatos,

      focus: function( event, ui ) {

        var index=$(this).index(".cuentaContable");

        // $( ".cuentaContable" ).eq(index).val( ui.item.label );

        $( ".idCuentaContable" ).eq(index).val( ui.item.value );

        $( ".naturaleza" ).eq(index).val( ui.item.naturaleza );

        if (ui.item.tercero=='2') {
          $( ".nit" ).eq(index).attr("disabled","true");
          $( ".nit" ).eq(index).removeAttr("required");
          
        }

        if (ui.item.centroCosto=='0' ) {
          $( ".centroCosto" ).eq(index).attr("disabled","true");
          $( ".centroCosto" ).eq(index).removeAttr("required");
          $( ".idCentroCosto" ).eq(index).attr("r","0");

          $( ".subcentroCosto" ).eq(index).attr("disabled","true");
          $( ".subcentroCosto" ).eq(index).removeAttr("required");
          $( ".idSubcentroCosto" ).eq(index).attr("r","0");
        }
        if (ui.item.centroCosto==null) {
          $( ".centroCosto" ).eq(index).removeAttr("required");
          $( ".centroCosto" ).eq(index).removeAttr("required");
        }
        if (ui.item.tercero=='1' || ui.item.tercero=='3') {
          $( ".nit" ).eq(index).removeAttr("disabled");
          $( ".nit" ).eq(index).attr("required","true");
        }
        if (ui.item.centroCosto=='1' ) {
          $( ".centroCosto" ).eq(index).removeAttr("disabled");
          $( ".centroCosto" ).eq(index).attr("required","true");
          $( ".subcentroCosto" ).eq(index).removeAttr("disabled");
          
          $( ".idCentroCosto" ).eq(index).attr("r","1");
          $( ".idSubcentroCosto" ).eq(index).attr("r","1");
          // $( ".centroCosto" ).eq(index).attr("required","true");
        }

        return false;
      },

      select: function( event, ui ) {

        var index=$(this).index(".cuentaContable");

        $( ".cuentaContable" ).eq(index).val( ui.item.label );

        $( ".idCuentaContable" ).eq(index).val( ui.item.value );

        $( ".naturaleza" ).eq(index).val( ui.item.naturaleza );
        $( ".letreroCuentaContable" ).eq(index).addClass('ocultar');
        if (ui.item.tercero=='2') {
          $( ".nit" ).eq(index).attr("disabled","true");
          $( ".nit" ).eq(index).removeAttr("required")
        }
        
        if (ui.item.centroCosto=='0') {
          $( ".centroCosto" ).eq(index).attr("disabled","true");
          $( ".centroCosto" ).eq(index).removeAttr("required");
          $( ".subcentroCosto" ).eq(index).attr("disabled","true");
          $( ".subcentroCosto" ).eq(index).removeAttr("required");

          $( ".idCentroCosto" ).eq(index).attr("r","0");
          $( ".idSubcentroCosto" ).eq(index).attr("r","0");
        }

        if (ui.item.tercero=='1' || ui.item.tercero=='3') {
          $( ".nit" ).eq(index).removeAttr("disabled");
          $( ".nit" ).eq(index).attr("required","true");
        }

        if ( ui.item.tercero=='3') {
          $("#porcentajeRetencion").val(ui.item.porcentajeRetencion);
          $('#exampleModal').modal('show');  
          // $( ".base" ).eq(index).removeAttr("disabled");

        }

        

        if (ui.item.centroCosto=='1') {
          $( ".centroCosto" ).eq(index).removeAttr("disabled");
          $( ".centroCosto" ).eq(index).attr("required","required");
          $( ".subcentroCosto" ).eq(index).removeAttr("disabled");
          $( ".idCentroCosto" ).eq(index).attr("r","1");
          $( ".idSubcentroCosto" ).eq(index).attr("r","1");
        }

        var id=ui.item.value;

        $("#index").val(index);

 //--------------------------------------------------------------------------------------------------------


  if (index>0) {
    var idTercero=$("#item[0][idTercero]").val(); 
    var idEmpresa=$("#idEmpresa").val();
    var idTipoDocumento=$("#tipoDocumento").val();
    if(idTipoDocumento!=""){
    
        if (idTipoDocumento==7 || idTipoDocumento==15) {

          $("#index").val(index);
          $.ajax({
            url:URL+"functions/comprobantes/consultarfacturacruceTercero.php", 
            type:"POST", 
            data: {"idTercero":idTercero,"idEmpresa":idEmpresa,"idTipoDocumento":idTipoDocumento}, 
            dataType: "json",
            }).done(function(msg){
              // console.log(msg);
              // console.log('**');
              // console.log(msg.facturas);
              if (idTipoDocumento==7) {
                var idFacturaCompra=0;
                var  sHtmlC='<optgroup label="Pendiente por pagar"><option value="">Seleccione</option>'; 
                msg.facturas.forEach(function(element,index){
                  idFacturaCompra=parseInt(element.idFacturaCompra);
                  sHtmlC+='<option value="'+idFacturaCompra+'" saldo="'+element.saldo+'" nroFactura="'+element.nroFactura+'" tercero="'+element.razonSocial+'">Nro Factura: '+element.nroFactura+'   |        SALDO: '+element.saldo+'       |           Tercero: '+element.razonSocial+'</option>'; 
                });
              }
              if (idTipoDocumento==15) {
                var  sHtmlC='<optgroup label="Pendiente por cobrar"><option value="">Seleccione</option>'; 
                    msg.facturas.forEach(function(element,index){
                      idFacturaVenta=parseInt(element.idFacturaVenta);
                    sHtmlC+='<option value="'+idFacturaVenta+'" saldo="'+element.saldo+'"  nroFactura="'+element.nroFactura+'" tercero="'+element.razonSocial+'" >Nro Factura: '+element.nroFactura+'   |        SALDO: '+element.saldo+'       |           Tercero: '+element.razonSocial+'</option>'; 
                  })
              }
                  sHtmlC+="</optgroup>"; 
                $("[name='factura[0][cruceFactura]']").html(sHtmlC);
                // $("[name='factura[0][cruceFactura]']").attr("required",true);

                // $('#facturaCruce').modal('show');
          });
        }
    }
  }





 if (ui.item.detalle=='1') {
    var tipoDetalle=1;
 }
 if (ui.item.detalle=='2') {
    var tipoDetalle=2;
 }
 if (ui.item.detalle=='3') {
    var tipoDetalle=3;
 }
var idEmpresa=$("#idEmpresa").val();

aDatosT=[];

  $.ajax({

      url:URL+"functions/terceros/cargarterceros.php", 

      type:"POST", 

      data: {"idEmpresa":idEmpresa,"tipoDetalle":tipoDetalle}, 

      dataType: "json",

      }).done(function(msg){
      // console.log(msg);
       

        msg.forEach(function(element,index){
          if (element.idCliente !=null) {
               var tipo='c'; 
              }
              if (element.idProveedor !=null) {
               var tipo='p';
              }
              if (element.idEmpleado !=null) {
               var tipo='e';
              }
          aDatosT.push({

              value: element[0],

              label: element.nit+" - "+element.razonSocial,

              tipo: tipo,
               

            })

        })

        autocompleteT(); 


    });  
      $( "#btnGuardarRetencion" ).click(function() {
        var indexG = $("#index").val();
        var totalR=$("#retencionModal").val();
        var baseM=$("#baseModal").val();
        if ($("#debito").is(':checked')) {
          $( ".debito" ).eq(indexG).val( totalR ).trigger('change');
          $( ".base" ).eq(indexG).val( baseM ).trigger('change');
          $( ".credito" ).eq(indexG).attr("disabled","disabled");
          // alert(baseM);
        }
        if ($("#credito").is(':checked')) {
          $( ".credito" ).eq(indexG).val( totalR ).trigger('change');
          $( ".base" ).eq(indexG).val( baseM ).trigger('change');
          // alert($( ".base" ).eq(indexG).val());
          $( ".debito" ).eq(indexG).attr("disabled","disabled");
          // alert(baseM);
        }
        sumar_columnas();
        $('#exampleModal').modal('hide'); 
        $("#frmRetencion")[0].reset();
      });

        return false;

      },

      change: function(event, ui){

        var index=$(this).index(".cuentaContable");

        if(ui.item==null){

          $( ".idCuentaContable" ).eq(index).val('');
          $( ".letreroCuentaContable" ).eq(index).removeClass('ocultar');

        }

        return false;

      }

    })

}

$("body").on("click","#btnAgregarTercero",function(e){
  $("#modalTercero").modal('show');

})
$("body").on("click","#btnAgregarCuenta",function(e){
  $("#modalCuenta").modal('show');

})

 $("#filter").keyup(function(){
        // Recupera el texto del campo de entrada y restablece el conteo a cero
        var filter = $(this).val(), count = 0;
        // Recorrer la tabla de respuestas
        $("#table tr td").each(function(){
            // Si el elemento de la tabla no contiene la frase de texto, difumína.
            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                $(this).fadeOut();
            // Mostrar el elemento de la tabla si la frase coincide e incrementa el contador a 1
            } else {
                $(this).show();
                count++;
            }
        });
        // Actualiza el contador
        var numberItems = count;
        // Esto solo muestra en numero de coincidencias
        $("#filter-count").text("Coincidencias = "+count);
    });


autocompleteC=function(){

  $( ".centroCosto" ).autocomplete({

      minLength: 0,

      source: aDatosC,

      focus: function( event, ui ) {

        var index=$(this).index(".centroCosto");

        // $( ".centroCosto" ).eq(index).val( ui.item.label );
        // $( ".idCentroCosto" ).eq(index).val( ui.item.value );
        return false;

      },

      select: function( event, ui ) {

        var index=$(this).index(".centroCosto");

        $( ".centroCosto" ).eq(index).val( ui.item.label );

        $( ".idCentroCosto" ).eq(index).val( ui.item.value );
        $( ".letreroCentroCosto" ).eq(index).addClass('ocultar');
        
        var id=ui.item.value;
        aDatosSC=[];
        $.ajax({
          url:URL+"functions/centrocosto/cargarsubcentrocosto.php", 
          type:"POST", 
          data: {"idCentroCosto":id}, 
          dataType: "json",
          }).done(function(msg){  
            console.log(msg);
            msg.forEach(function(element,index){
              aDatosSC.push({
                  value: element.idSubcentroCosto,
                  label: element.codigoSubcentroCosto+' - '+element.subcentroCosto,
                })
            })
            autocompleteSC(); 
        });   
        return false;

      },

      change: function(event, ui){

        var index=$(this).index(".centroCosto");

        if(ui.item==null){

          $( ".idCentroCosto" ).eq(index).val('');

        }

        return false;

      }

    })

}



autocompleteSC=function(){

  $( ".subcentroCosto" ).autocomplete({
      minLength: 0,
      source: aDatosSC,
      focus: function( event, ui ) {
        var index=$(this).index(".subcentroCosto");
        // $( ".subcentroCosto" ).eq(index).val( ui.item.label );
        // $( ".idSubcentroCosto" ).eq(index).val( ui.item.value );
        return false;
      },
      select: function( event, ui ) {
        var index=$(this).index(".subcentroCosto");
        $( ".subcentroCosto" ).eq(index).val( ui.item.label );
        $( ".idSubcentroCosto" ).eq(index).val( ui.item.value );
        $( ".letreroSubcentroCosto" ).eq(index).addClass('ocultar');
        var id=ui.item.value;
         
        return false;
      },
      change: function(event, ui){
        var index=$(this).index(".subcentroCosto");
        if(ui.item==null){
          $( ".idSubcentroCosto" ).eq(index).val('');
        }
        return false;
      }
    })
}



autocompleteT=function(){
  $( ".nit" ).autocomplete({
      minLength: 0,
      source: aDatosT,
      

      focus: function( event, ui ) {
        var index=$(this).index(".nit");
        // $( ".nit" ).eq(index).val( ui.item.label );
        // $( ".idTercero" ).eq(index).val( ui.item.value );
        // $( ".tipoTercero" ).eq(index).val( ui.item.tipo );
        return false;
      },
      select: function( event, ui ) {
        var index=$(this).index(".nit");
        $( ".nit" ).eq(index).val( ui.item.label );
        $( ".idTercero" ).eq(index).val( ui.item.value );
        $( ".tipoTercero" ).eq(index).val( ui.item.tipo );
        $( ".letreroTercero" ).eq(index).addClass('ocultar');
        var id=ui.item.value;


        
    var idTercero=ui.item.value; 
    var idEmpresa=$("#idEmpresa").val();
    var idTipoDocumento=$("#tipoDocumento").val();
    if(idTipoDocumento!=""){
    
        if (idTipoDocumento==7 || idTipoDocumento==15) {

          $("#index").val(index);
          $.ajax({
            url:URL+"functions/comprobantes/consultarfacturacruceTercero.php", 
            type:"POST", 
            data: {"idTercero":idTercero,"idEmpresa":idEmpresa,"idTipoDocumento":idTipoDocumento}, 
            dataType: "json",
            }).done(function(msg){
              // console.log(msg);
              // console.log('**');
              // console.log(msg.facturas);
              if (idTipoDocumento==7) {
                var idFacturaCompra=0;
                var  sHtmlC='<optgroup label="Pendiente por pagar"><option value="">Seleccione</option>'; 
                msg.facturas.forEach(function(element,index){
                  idFacturaCompra=parseInt(element.idFacturaCompra);
                  sHtmlC+='<option value="'+idFacturaCompra+'" saldo="'+element.saldo+'" nroFactura="'+element.nroFactura+'" tercero="'+element.razonSocial+'">Nro Factura: '+element.nroFactura+'   |        SALDO: '+element.saldo+'       |           Tercero: '+element.razonSocial+'</option>'; 
                });
              }
              if (idTipoDocumento==15) {
                var  sHtmlC='<optgroup label="Pendiente por cobrar"><option value="">Seleccione</option>'; 
                    msg.facturas.forEach(function(element,index){
                      idFacturaVenta=parseInt(element.idFacturaVenta);
                    sHtmlC+='<option value="'+idFacturaVenta+'" saldo="'+element.saldo+'"  nroFactura="'+element.nroFactura+'" tercero="'+element.razonSocial+'" >Nro Factura: '+element.nroFactura+'   |        SALDO: '+element.saldo+'       |           Tercero: '+element.razonSocial+'</option>'; 
                  })
              }
                  sHtmlC+="</optgroup>"; 
                $("[name='factura[0][cruceFactura]']").html(sHtmlC);
                // $("[name='factura[0][cruceFactura]']").attr("required",true);

                // $('#facturaCruce').modal('show');
          });
        }
    }else{
      $("[name='datos[comprobante]']").html("<option value=''>Seleccione una opción</option>");
    }

        return false;
      },
      change: function(event, ui){
        var index=$(this).index(".nit");
        if(ui.item==null){
          $( ".idTercero" ).eq(index).val('');
          $( ".letreroTercero" ).eq(index).removeClass('ocultar');
        }
        return false;
      }
    })
}


$("[name='datos[cruce]']").on('change',function(){
  // alert($(this).val());
  if ($(this).val()==0) {
    $("#btnGuardarCruce").removeClass('ocultar');
    $("#cerrarModal").addClass('ocultar');
    $("#divCruzar").css("display","block");
  }
  if ($(this).val()==1) {
    $("#divCruzar").css("display","none"); 
    $("#cerrarModal").removeClass('ocultar');
    $("#btnGuardarCruce").addClass('ocultar');
  }

})




$("body").on("click","#btnGuardarCruce",function(e){

var cant=$("#tableCruzar tbody tr").length; 
var sHtml=' <td><input type="hidden" name="cruce['+cant+'][idFactura]" id="cruce['+cant+'][idFactura]" value="'+$("#cruceFactura option:selected").val()+'"><input type="hidden" name="cruce['+cant+'][index]" id="cruce['+cant+'][index]" value="'+$("#index").val()+'"><input type="text" class="form-control mayusculas" name="cruce['+cant+'][nroFactura]" id="cruce['+cant+'][nroFactura]" value="'+$("#cruceFactura option:selected").attr("nroFactura")+'" readonly></td>';

sHtml+='<td><input type="text" class="form-control mayusculas" name="cruce['+cant+'][tercero]" id="cruce['+cant+'][tercero]" value="'+$("#cruceFactura option:selected").attr("tercero")+'" readonly></td>';
sHtml+='<td><input type="text" class="form-control mayusculas moneda saldo" name="cruce['+cant+'][saldo]" id="cruce['+cant+'][saldo]" value="'+$("#cruceFactura option:selected").attr("saldo")+'" readonly></td>';







if ($("#tipoDocumento").val()==7) {
  //debito
// [name='factura[0][cruceFactura]']

  $("[name='item["+$("#index").val()+"][debito]']").val($("#cruceFactura option:selected").attr("saldo")).trigger('change');
  $("[name='item["+$("#index").val()+"][credito]']").attr("disabled","disabled");

  // saldoF.value=;

}

if ($("#tipoDocumento").val()==15) {
//credito
  $("[name='item["+$("#index").val()+"][credito]']").val($("#cruceFactura option:selected").attr("saldo")).trigger('change');
  $("[name='item["+$("#index").val()+"][debito]']").attr("disabled","disabled");
  // var saldoF=document.getElementById("item["+$("#index").val()+"][credito]");
  // saldoF.value=$("#cruceFactura option:selected").attr("saldo");

}



  $("#tableCruzar tbody").append("<tr>"+sHtml+"</tr>"); 
  $(".saldo").formatCurrency({decimalSymbol:',',digitGroupSymbol:'.'});
  $('#facturaCruce').modal('hide');
  $("#divTablaCruzar").css("display","block");
})

// autocompleteTer=function(){

  // $("")

  // $( ".nit" ).autocomplete({  
      
      
  //     select: function( event, ui ) {
  //       var index=$(this).index(".nit");
  //       $( ".nit" ).eq(index).val( ui.item.label );
  //       $( ".idTercero" ).eq(index).val( ui.item.value );
  //       $( ".tipoTercero" ).eq(index).val( ui.item.tipo );
  //       $( ".letreroTercero" ).eq(index).addClass('ocultar');
  //       var id=ui.item.value;
  //       return false;
  //     }

  //   })
// }

// totalDebito

// $("body").on("keyup",".total",function(e){
//   var valor=$(this).val();
//   
  

// })
$('.decimales').keyup(function () { 
    this.value = this.value.replace(/[^0-9\,]/g,'');


});

// $('.idCuentaContable').change(function(){
//   if (this.val()!='') {
//     var nomb=this.attr('name');
//     alert(nomb);
//   }
// })

// $("body").on("change",".idCuentaContable",function(e){
//   alert(this.attr(id));
// })

$("body").on("change","[name='datos[tipoDocumento]']",function(e){
    var id=$(this).val(); 
    var idEmpresa=$("#idEmpresa").val();
    if(id!=""){
      $.ajax({
        url:URL+"functions/comprobantes/parametrosdocumentos.php", 
        type:"POST", 
        data: {"idTipoDocumento":id,"idEmpresa":idEmpresa}, 
        dataType: "json",
        }).done(function(msg){  
          var sHtml="<option value=''>Seleccione una opción</option>"; 
          msg.comprobante.forEach(function(element,index){
            sHtml+="<option value='"+element.comprobante+"'>"+element.comprobante+' - '+element.descripcion+"</option>"; 
          })
          $("[name='datos[comprobante]']").html(sHtml);
      });
        // if (id==7 || id==15) {
        //   $.ajax({
        //     url:URL+"functions/comprobantes/consultarfacturacruce.php", 
        //     type:"POST", 
        //     data: {"idTipoDocumento":id,"idEmpresa":idEmpresa}, 
        //     dataType: "json",
        //     }).done(function(msg){
        //       console.log(msg);
        //       console.log('**');
        //       console.log(msg.facturas);
        //       if (id==7) {
        //         var idFacturaCompra=0;
        //         var  sHtmlC='<optgroup label="Pendiente por pagar"><option value="">Seleccione</option>'; 
        //         msg.facturas.forEach(function(element,index){
        //           idFacturaCompra=parseInt(element.idFacturaCompra);
        //           sHtmlC+='<option value="'+idFacturaCompra+'" saldo="'+element.saldo+'" >Nro Factura: '+element.nroFactura+'   |        SALDO: '+element.saldo+'       |           Tercero: '+element.razonSocial+'</option>'; 
        //         });
        //       }
        //       if (id==15) {
        //         var  sHtmlC='<optgroup label="Pendiente por cobrar"><option value="">Seleccione</option>'; 
        //             msg.facturas.forEach(function(element,index){
        //               idFacturaVenta=parseInt(element.idFacturaVenta);
        //             sHtmlC+='<option value="'+idFacturaVenta+'" saldo="'+element.saldo+'" >Nro Factura: '+element.nroFactura+'   |        SALDO: '+element.saldo+'       |           Tercero: '+element.razonSocial+'</option>'; 
        //           })
        //       }
        //           sHtmlC+="</optgroup>"; 
        //         $("#cruceFactura").html(sHtmlC);
        //         $("#cruceFactura").attr("required",true);
        //   });
        // }
    }else{
      $("[name='datos[comprobante]']").html("<option value=''>Seleccione una opción</option>");
    }
});




$("#tableProductos").on("input", "input", function() {
  var input = $(this);
  // var columns = input.closest("tr").children();
  // var dc = columns.eq(7).text();
  // var calculated = input.val() * price;
  // columns.eq(5).text(calculated.toFixed(2));
  
  sumar_columnas();
  
  
});

function sumar_columnas(){
var sumDebito=0;
var sumCredito=0;
var cont=0;
var contC=0;
var restarDebito=0;

    //itera cada input de clase .subtotal y la suma
    $('.debito').each(function() { 
      // var naturaleza=document.getElementById("item["+cont+"][naturaleza]").value;
      var debito=document.getElementById("item["+cont+"][debito]");
      var credito=document.getElementById("item["+cont+"][credito]");
      var cuentaContable=document.getElementById("item["+cont+"][cuentaContable]");
      var valorDebito=(eliminarMoneda(eliminarMoneda(eliminarMoneda($(this).val(),"$",""),".",""),",","."));
      if (valorDebito=="" || valorDebito==null) {
        valorDebito=0;
        
      }
      if (debito.value !="" && credito.value =="") {
        credito.disabled=true;
      }
      if (debito.value =="" && credito.value !="") {
        debito.disabled=true;
      }
      if (debito.value =="" && credito.value =="") {
        credito.disabled=false;
        debito.disabled=false;
      }   
      
      // if (valorCuentaContable.substring(0,4)=='1592') {
      //   sumDebito -=parseFloat(valorDebito);
      // }
      
        sumDebito +=parseFloat(valorDebito);

         

            // if (naturaleza=="debito") {
              
            //   sumDebito +=parseFloat(valorDebito);
            // }
            // if (naturaleza=="credito") {
              
            //   sumCredito +=parseFloat(valorDebito);
            // }  
            cont++;                    
    }); 
      $('.credito').each(function() { 
      // var naturaleza=document.getElementById("item["+cont+"][naturaleza]");
      // var debito=document.getElementById("item["+cont+"][debito]");
      // var credito=document.getElementById("item["+cont+"][credito]");
      var valorCredito=(eliminarMoneda(eliminarMoneda(eliminarMoneda($(this).val(),"$",""),".",""),",","."));
      var cuentaContable=document.getElementById("item["+contC+"][cuentaContable]");
      if (valorCredito=="" || valorCredito==null) {
        valorCredito=0;
        
      } 
       
      var valorCuentaContable=cuentaContable.value;
      
      // if (valorCuentaContable.substring(0,4)=='1592') {
      //   restarDebito +=parseFloat(valorCredito);
      // }else{
        sumCredito +=parseFloat(valorCredito); 
      // }
        contC++; 
    }); 
    //cambia valor del total y lo redondea a la segunda decimal
    var totalD=sumDebito-restarDebito;
    // var totalC=
    $('#totalDebito').val(totalD.toFixed(2));
    $('#totalCredito').val(sumCredito.toFixed(2));
    var diferencia=totalD - sumCredito;
    $('#totalDiferencia').val(diferencia.toFixed(2));

}
// $(document).ready(function(e){

// })

  function verificar_id_cuenta_contable(){
    var cuenta=0;
    var estado=true;
    $('.idCuentaContable').each(function() { 

        var cuentaContable=document.getElementById('item['+cuenta+'][cuentaContable]');
        var idCuentaContable=document.getElementById('item['+cuenta+'][idCuentaContable]');
        var letreroCuentaContable=document.getElementById('item['+cuenta+'][letreroCuentaContable]');

        if ($(this).val()=='') {
          letreroCuentaContable.classList.remove("ocultar");
          estado= false;
        }


        cuenta++;
    });
    return estado;
  }

  function verificar_id_tercero(){
    var cuenta=0;
    var estado=true;
    $('.idTercero').each(function() { 

        var cuentaContable=document.getElementById('item['+cuenta+'][nit]');
        var idCuentaContable=document.getElementById('item['+cuenta+'][idTercero]');
        var letreroCuentaContable=document.getElementById('item['+cuenta+'][letreroTercero]');

        if ($(this).val()=='') {
          letreroCuentaContable.classList.remove("ocultar");
          estado= false;
        }


        cuenta++;
    });
    return estado;
  }

  function verificar_centro_costo(){
    var cuenta=0;
    var estado=true;
    $('.idCentroCosto').each(function() { 

        // var cuentaContable=document.getElementById('item['+cuenta+'][nit]');
        var centroCosto=document.getElementById('item['+cuenta+'][centroCosto]');
        var idCentroCosto=document.getElementById('item['+cuenta+'][idCentroCosto]');
        var letreroCentroCosto=document.getElementById('item['+cuenta+'][letreroCentroCosto]');



      // if (centroCosto.attr('required')=='required') {
      //   alert('si');
      // }
      // if (centroCosto.attr('required')!='required') {
      //   alert('no');
      // }
      // if ($(this).parsley().validate()) {
      //     letreroCentroCosto.classList.remove("ocultar");
      //     estado= false;
      // }


      // if ($(this).attr('required')) {
      //   alert('requerido');
      // }
      // alert($(this).attr('r'));
      if ($(this).attr('r')==1) {
        if ($(this).val()=='') {
          letreroCentroCosto.classList.remove("ocultar");
          estado= false;
        }
      }

        


        cuenta++;
    });
    return estado;
  }


  function verificar_subcentro_costo(){
    var cuenta=0;
    var estado=true;
    $('.idSubcentroCosto').each(function() { 

        // var cuentaContable=document.getElementById('item['+cuenta+'][nit]');
        var idCuentaContable=document.getElementById('item['+cuenta+'][idSubcentroCosto]');
        var letreroCuentaContable=document.getElementById('item['+cuenta+'][letreroSubcentroCosto]');

        // if ($(this).parsley().validate()) {
        //     letreroCuentaContable.classList.remove("ocultar");
        //     estado= false;  
        // }


        // alert($(this).attr('r'));

        if ($(this).attr('r')==1) {
          if ($(this).val()=='') {
            letreroCuentaContable.classList.remove("ocultar");
            estado= false;
          }  
        }

        


        cuenta++;
    });
    return estado;
  }
  

$("body").on("click","#agregar",function(e){



  $('select.flexselect').removeData("flexselect");

  var sHtml=$("#tableProductos tbody tr:first").html(); 

  var cant=$("#tableProductos tbody tr").length; 
  if (cant>=249) {
    $(this).hide();
    // alert('mas 10');
  }

  $("#tableProductos tbody").append("<tr>"+sHtml+"</tr>"); 

  $("#tableProductos tbody tr:last").find("td").eq(0).html(cant+1);
  $("#tableProductos tbody tr:last").find(".cuentaContable").attr("id","item["+cant+"][cuentaContable]").attr("name","item["+cant+"][cuentaContable]").val("");
  $("#tableProductos tbody tr:last").find(".idCuentaContable").attr("id","item["+cant+"][idCuentaContable]").attr("name","item["+cant+"][idCuentaContable]").val("");
  $("#tableProductos tbody tr:last").find(".letreroCuentaContable").attr("id","item["+cant+"][letreroCuentaContable]").addClass('ocultar').val("");
  $("#tableProductos tbody tr:last").find(".centroCosto").attr("id","item["+cant+"][centroCosto]").attr("name","item["+cant+"][centroCosto]").val(""); 
  $("#tableProductos tbody tr:last").find(".idCentroCosto").attr("id","item["+cant+"][idCentroCosto]").attr("name","item["+cant+"][idCentroCosto]").attr("r","1").val(""); 
  $("#tableProductos tbody tr:last").find(".letreroCentroCosto").attr("id","item["+cant+"][letreroCentroCosto]").addClass('ocultar').val("");

  $("#tableProductos tbody tr:last").find(".subcentroCosto").attr("id","item["+cant+"][subcentroCosto]").attr("name","item["+cant+"][subcentroCosto]").val(""); 
  $("#tableProductos tbody tr:last").find(".idSubcentroCosto").attr("id","item["+cant+"][idSubcentroCosto]").attr("name","item["+cant+"][idSubcentroCosto]").attr("r","1").val(""); 
  $("#tableProductos tbody tr:last").find(".letreroSubcentroCosto").attr("id","item["+cant+"][letreroSubcentroCosto]").addClass('ocultar').val("");


  var num=cant-1;
  var ter=document.getElementById('item['+num+'][nit]').value;



  $("#tableProductos tbody tr:last").find(".nit").attr("id","item["+cant+"][nit]").attr("name","item["+cant+"][nit]").val(ter); 
  $("#tableProductos tbody tr:last").find(".idTercero").attr("id","item["+cant+"][idTercero]").attr("name","item["+cant+"][idTercero]"); 
  $("#tableProductos tbody tr:last").find(".letreroTercero").attr("id","item["+cant+"][letreroTercero]").addClass('ocultar').val("");
  $("#tableProductos tbody tr:last").find(".tipoTercero").attr("id","item["+cant+"][tipoTercero]").attr("name","item["+cant+"][tipoTercero]"); 
  $("#tableProductos tbody tr:last").find(".descripcion").attr("id","item["+cant+"][descripcion]").attr("name","item["+cant+"][descripcion]").val(""); 
  $("#tableProductos tbody tr:last").find(".base").attr("id","item["+cant+"][base]").attr("name","item["+cant+"][base]").val(""); 
  $("#tableProductos tbody tr:last").find(".naturaleza").attr("id","item["+cant+"][naturaleza]").attr("name","item["+cant+"][naturaleza]").val(''); 
  $("#tableProductos tbody tr:last").find(".debito").removeAttr("disabled").attr("id","item["+cant+"][debito]").attr("name","item["+cant+"][debito]").val('');
  $("#tableProductos tbody tr:last").find(".credito").removeAttr("disabled").attr("id","item["+cant+"][credito]").attr("name","item["+cant+"][credito]").val('');

  autocomplete(); 
  autocompleteC();
  autocompleteT();

})





$("body").on("click",".eliminar",function(e){



  var cant=$("#tableProductos tbody tr").length; 

  if(cant>1){

    $('select.flexselect').removeData("flexselect");

    $(this).parents("tr").remove(); 

    $("#tableProductos tbody tr").each(function(index,element){

      $(element).find("td").eq(0).html(index+1); 

      $(element).find(".cuentaContable").attr("id","item["+index+"][cuentaContable]").attr("name","item["+index+"][cuentaContable]");
      $(element).find(".idCuentaContable").attr("id","item["+index+"][idCuentaContable]").attr("name","item["+index+"][idCuentaContable]");
      $(element).find(".letreroCuentaContable").attr("id","item["+index+"][letreroCuentaContable]").addClass('ocultar');
      $(element).find(".centroCosto").attr("id","item["+index+"][centroCosto]").attr("name","item["+index+"][centroCosto]");
      $(element).find(".idCentroCosto").attr("id","item["+index+"][idCentroCosto]").attr("name","item["+index+"][idCentroCosto]");
      $(element).find(".subcentroCosto").attr("id","item["+index+"][subcentroCosto]").attr("name","item["+index+"][subcentroCosto]");
      $(element).find(".idSubcentroCosto").attr("id","item["+index+"][idSubcentroCosto]").attr("name","item["+index+"][idSubcentroCosto]");
      $(element).find(".nit").attr("id","item["+index+"][nit]").attr("name","item["+index+"][nit]");
      $(element).find(".idTercero").attr("id","item["+index+"][idTercero]").attr("name","item["+index+"][idTercero]");
      $(element).find(".letreroTercero").attr("id","item["+index+"][letreroTercero]").addClass('ocultar');
      $(element).find(".tipoTercero").attr("id","item["+index+"][tipoTercero]").attr("name","item["+index+"][tipoTercero]");
      $(element).find(".descripcion").attr("id","item["+index+"][descripcion]").attr("name","item["+index+"][descripcion]");
      $(element).find(".base").attr("id","item["+index+"][base]").attr("name","item["+index+"][base]");
      $(element).find(".naturaleza").attr("id","item["+index+"][naturaleza]").attr("name","item["+index+"][naturaleza]");
      $(element).find(".debito").removeAttr("disabled").attr("id","item["+index+"][debito]").attr("name","item["+index+"][debito]");
      $(element).find(".credito").removeAttr("disabled").attr("id","item["+index+"][credito]").attr("name","item["+index+"][credito]");

    })

    

    autocomplete(); 
    sumar_columnas();

  }
  if (cant<=250) {
    $("#agregar").show();
    // alert('menos 10');
  }

  

})

verificar_factura=function (){
  var control=true;
  // if ($("#cruceFactura").val()!="") {
    // control=false;
  // }
  return control;
}


$("body").on("click","#btnGuardarTercero",function(e){
  e.preventDefault();

    if(true === $("#frmTercero").parsley().validate()){
       Swal.fire({
        title: '¿Está seguro?',
        text: 'Está a punto de guardar este tercero!',
        icon: 'warning', 
        showCancelButton: true,
        showLoaderOnConfirm: true,
        confirmButtonText: `Si, Guardar!`,
        cancelButtonText:'Cancelar',
        preConfirm: function(result) {
          return new Promise(function(resolve) {
            var formu = document.getElementById("frmTercero");
            var data = new FormData(formu);
            $.ajax({
            url:URL+"functions/terceros/guardartercero.php", 
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
                  title: 'tercero guardado!',
                  text: 'con exito',
                  closeOnConfirm: true,
                }
              ).then((result) => {
                    var tipoDetalle=3;
                    var idEmpresa=$("[name='datos[idEmpresa]']").val();
                    aDatosT=[];
                      $.ajax({
                          url:URL+"functions/terceros/cargarterceros.php", 
                          type:"POST", 
                          data: {"idEmpresa":idEmpresa,"tipoDetalle":tipoDetalle}, 
                          dataType: "json",
                          }).done(function(msg){
                          // console.log(msg);
                            msg.forEach(function(element,index){
                              if (element.idCliente !=null) {
                                   var tipo='c'; 
                                  }
                                  if (element.idProveedor !=null) {
                                   var tipo='p';
                                  }
                                  if (element.idEmpleado !=null) {
                                   var tipo='e';
                                  }
                              aDatosT.push({
                                  value: element[0],
                                  label: element.nit+" - "+element.razonSocial,
                                  tipo: tipo,
                                })
                            })
                            autocompleteT(); 
                        });  
                       $("#modalTercero").modal('hide');
                       var idEmpresa=$("[name='datos[idEmpresa]']").val();
                       $("#modalTercero").find("input,textarea,select").val("");
                       $("[name='datos[terceroEmpresa]']").val(idEmpresa);
                       $("#modalTercero input[type='checkbox']").prop('checked', false).change();

              })
            }else{
               Swal.fire(
                'Algo ha salido mal!',
                'El tercero ya está creado',
                'error'
              )
            }
          });
        });
      }
    })
  }
})



$("body").on("click","#btnGuardarCuentaContable",function(e){
  e.preventDefault();

    if(true === $("#frmGuardarCuentaContable").parsley().validate()){
       Swal.fire({
        title: '¿Está seguro?',
        text: 'Está a punto de guardar esta cuenta contable!',
        icon: 'warning', 
        showCancelButton: true,
        showLoaderOnConfirm: true,
        confirmButtonText: `Si, Guardar!`,
        cancelButtonText:'Cancelar',
        preConfirm: function(result) {
          return new Promise(function(resolve) {
            var formu = document.getElementById("frmGuardarCuentaContable");
            var data = new FormData(formu);
            $.ajax({
            url:URL+"functions/cuentascontables/guardarcuentacontable.php", 
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
                title: 'cuenta contable guardada!',
                text: 'con exito',
                closeOnConfirm: true,
              }
              ).then((result) => {
                    
                    var idEmpresa=$("[name='datos[idEmpresa]']").val();
                    aDatos=[];
                    $.ajax({
                      url:URL+"functions/cuentascontables/cargarcuentascontables.php", 
                      type:"POST", 
                      data: {"idEmpresa":idEmpresa}, 
                      dataType: "json",
                      }).done(function(msg){  
                        msg.forEach(function(element,index){
                          aDatos.push({
                              value: element.idCuentaContable,
                              label: element.codigoCuentaContable+" - "+element.nombre,
                              naturaleza: element.naturaleza,
                              tercero:element.tercero,
                              centroCosto:element.centroCosto,
                              detalle:element.detalle,
                              porcentajeRetencion:element.porcentajeRetencion,
                            })
                        })
                        autocomplete(); 
                    }); 

                       $("#modalCuenta").modal('hide');
                       var idEmpresaCuenta=$("#idEmpresaCuenta").val();
                       $("#modalCuenta").find("input,textarea,select").val("");
                       $("[name='datos[terceroEmpresa]']").val(idEmpresaCuenta);
                       $("#modalCuenta input[type='checkbox']").prop('checked', false).change();
              })
            }else{
               Swal.fire(
                'Algo ha salido mal!',
                'falló la creación de la cuenta',
                'error'
              )
            }
          });
        });
      }
    })
  }
})


$("body").on("change","[name='datos[idDepartamento]']",function(e){
    var id=$(this).val(); 
    if(id!=""){
      $.ajax({
        url:URL+"functions/generales/ciudades.php", 
        type:"POST", 
        data: {"idDepartamento":id}, 
        dataType: "json",
        }).done(function(msg){  
          var sHtml="<option value=''>Seleccione una opción</option>"; 
          msg.ciudades.forEach(function(element,index){
            sHtml+="<option value='"+element.idCiudad+"'>"+element.nombre+"</option>"; 
          })
          $("[name='datos[idCiudad]']").html(sHtml);
      });
    }else{
      $("[name='datos[idCiudad]']").html("<option value=''>Seleccione una opción</option>");
    }
})

$("body").on("change","[name='datos[tipoPersona]']",function(e){

  if($(this).val()==1){

    $("[name='datos[digitoVerificador]']").attr("readonly","readonly");

    $("[name='datos[digitoVerificador]']").removeAttr("required");

  }else{

    $("[name='datos[digitoVerificador]']").attr("required",true);

    $("[name='datos[digitoVerificador]']").removeAttr("readonly");

  }

})


$("body").on("click","#btnGuardar",function(e){
    e.preventDefault();
    var diferencia= document.getElementById('totalDiferencia');
    var diferenciaTotal=eliminarMoneda(eliminarMoneda(diferencia.value,"$",""),",","");  
    if (diferenciaTotal!=0) {
      Swal.fire(
          'Algo ha salido mal!',
          'debitos y creditos no coinciden',
          'error'
        )
      diferencia.style.color='red';
    }else{
      if (verificar_id_cuenta_contable()) {
        if (verificar_id_tercero()) {
          // alert('ingreso');
          if (verificar_centro_costo()) {
            if (verificar_subcentro_costo()) {
              if(true === $("#frmGuardar").parsley().validate()){
                if ($("#tipoDocumento").val()==7 || $("#tipoDocumento").val()==15) {
                  

                  
                  var cant=$("#tableCruzar tbody tr").length; 
                  if (cant!=0) {
                    var saldos =[];

                    for (let i = 0; i < cant; i++) {
                      // 0[i]
                      let nroF=$("[name='cruce["+i+"][nroFactura]']").val();
                      let saldo=$("[name='cruce["+i+"][saldo]']").val();
                      // let saldoFactura = parseFloat(saldo.replace(",","."));
                      let saldoFactura =parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda(saldo,"$",""),".",""),",","."));

                      // console.log('saldo:');
                      // console.log(saldo);
                      
                      let index=$("[name='cruce["+i+"][index]']").val();
                      // console.log('index:');
                      // console.log(index);
                      var debito=$("[name='item["+index+"][debito]']").val();
                      
                      // console.log('length');
                        // console.log(debito.length); 
                        // console.log('paso');
                      // if ($("[name='item["+index+"][debito]']").val().length!=0) {
                      if (debito.length >0) {


                        var total=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda(debito,"$",""),".",""),",","."));
                        // console.log('debito:');
                      }
                      if (debito.length==0) {
                        var total='';
                      }
                      // console.log($("[name='item["+index+"][debito]']").val());
                      // console.log(total);
                      if (total==0 || total=='' ) {
                        var credito=$("[name='item["+index+"][credito]']").val();

                        total=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda(credito,"$",""),".",""),",","."));
                        // console.log('credito:');
                      }

                        // console.log(total);
                      let pagoFactura = saldoFactura-total;
                      
                        // console.log('saldo:');
                        // console.log(saldoFactura);
                        // console.log('total:');
                        // console.log(pagoFactura);

                      saldos.push(nroF,pagoFactura);
                    }

                  }
                  // $("#tableCruzar tbody").append("<tr>"+sHtml+"</tr>");





                  Swal.fire({
                    title: '¿Está seguro?',
                    // text: 'Está a punto de contabilizar el comprobante, queda un saldo pendiente en la(s) factura(s) de: '+saldos,
                    text: 'Está a punto de contabilizar el comprobante',
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
                        url:URL+"functions/comprobantes/guardarcomprobante.php", 
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
                            title: 'comprobante contabilizado!',
                            text: 'con exito',
                            closeOnConfirm: true,
                          }
                          ).then((result) => {
                           location.reload(); 
                           // location.href="vercomprobante"+msg.idComprobante; 
                          })
                        }else{
                           Swal.fire(
                            'El número de comprobante ya existe!',
                            'Verifiquelo y vuelva a contabilizarlo',
                            'error'
                          )
                        }
                      });
                    });
                  }
                })

                }else{

                    Swal.fire({
                        title: '¿Está seguro?',
                        text: 'Está a punto de contabilizar el comprobante!',
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
                            url:URL+"functions/comprobantes/guardarcomprobante.php", 
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
                                title: 'comprobante contabilizado!',
                                text: 'con exito',
                                closeOnConfirm: true,
                              }
                              ).then((result) => {
                               location.reload();
                                // location.href="vercomprobante"+msg.idComprobante; 
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


        // ---------------------------------------------------------
              }
            }else{
            Swal.fire(
                'Verifique los subcentros de costo',
                'deben quedar seleccionados de la lista desplegable',
                'error'
              )
          }
          }else{
            Swal.fire(
                'Verifique los centros de costo',
                'deben quedar seleccionados de la lista desplegable',
                'error'
              )
          }
        }else{
          Swal.fire(
          'Verifique los terceros',
          'deben quedar seleccionados de la lista desplegable',
          'error'
          )
        }
      }else{
        Swal.fire(

          'Verifique las cuentas contables',

          'deben quedar seleccionadas de la lista desplegable',

          'error'

        )
      }
    }
  });









autocompleteGrupo=function(){

  $( ".grupo" ).autocomplete({

      minLength: 0,

      source: aDatosGrupo,

      appendTo: "#modalCuenta",

      focus: function( event, ui ) {

        var index=$(this).index(".grupo");

        $( ".grupo" ).eq(index).val( ui.item.label );

        $( ".idGrupo" ).eq(index).val( ui.item.value );

        

        return false;

      },

      select: function( event, ui ) {

        var index=$(this).index(".grupo");

        $( ".grupo" ).eq(index).val( ui.item.label );

        $( ".idGrupo" ).eq(index).val( ui.item.value );
        
        var id=ui.item.value;
        aDatoSubcuenta=[];
        aDatosCuenta=[];

         $.ajax({

        url:URL+"functions/cuentascontables/cargarcuentas.php", 

        type:"POST", 

        data: {"id":id}, 

        dataType: "json",

        }).done(function(msg){  

        msg.forEach(function(element,index){

          aDatosCuenta.push({

              value: element.idCuenta,

              label: element.codigo+" - "+element.denominacion,

            })

        })

        autocompleteCuenta(); 

    }); 



        return false;

      },

      change: function(event, ui){

        var index=$(this).index(".grupo");

        if(ui.item==null){

          $( ".idGrupo" ).eq(index).val('');

        }

        return false;

      }

    })

}




autocompleteCuenta=function(){

  $( ".cuenta" ).autocomplete({

      minLength: 0,

      source: aDatosCuenta,
      appendTo: "#modalCuenta",

      focus: function( event, ui ) {

        var index=$(this).index(".cuenta");

        $( ".cuenta" ).eq(index).val( ui.item.label );

        $( ".idCuenta" ).eq(index).val( ui.item.value );

        

        return false;

      },

      select: function( event, ui ) {

        var index=$(this).index(".cuenta");

        $( ".cuenta" ).eq(index).val( ui.item.label );

        $( ".idCuenta" ).eq(index).val( ui.item.value );

        var ids=ui.item.value;

        $.ajax({

        url:URL+"functions/cuentascontables/cargarsubcuentas.php", 

        type:"POST", 

        data: {"id":ids}, 

        dataType: "json",

        }).done(function(msg){  

        msg.forEach(function(element,index){

          aDatoSubcuenta.push({

              value: element.idSubcuenta,

              label: element.codigo+" - "+element.denominacion,

            })

        })

        autocompleteSubcuenta(); 

    }); 


        return false;

      },

      change: function(event, ui){

        var index=$(this).index(".cuenta");

        if(ui.item==null){

          $( ".idCuenta" ).eq(index).val('');

        }

        return false;

      }

    })

}



autocompleteSubcuenta=function(){

  $( ".subcuenta" ).autocomplete({

      minLength: 0,

      source: aDatoSubcuenta,
      appendTo: "#modalCuenta",

      focus: function( event, ui ) {

        var index=$(this).index(".subcuenta");

        $( ".subcuenta" ).eq(index).val( ui.item.label );

        $( ".idSubcuenta" ).eq(index).val( ui.item.value );

        

        return false;

      },

      select: function( event, ui ) {

        var index=$(this).index(".subcuenta");

        $( ".subcuenta" ).eq(index).val( ui.item.label );

        $( ".idSubcuenta" ).eq(index).val( ui.item.value );

        return false;

      },

      change: function(event, ui){

        var index=$(this).index(".subcuenta");

        if(ui.item==null){

          $( ".idSubcuenta" ).eq(index).val('');

        }

        return false;

      }

    })
}





$("#checkauxiliar").on( 'change', function() {
    if( $(this).is(':checked') ) {
        $( "#idAuxiliar" ).removeAttr("readonly","readonly");
        $("#idAuxiliar").removeAttr('disabled');
        $( "#auxiliar" ).removeAttr("readonly","readonly");
        $("#auxiliar").removeAttr('disabled');
        $("#checksubauxiliar").removeAttr('disabled');
        
        $( "#idAuxiliar" ).attr("required","required");
        $( "#auxiliar" ).attr("required","required");
    } else {
        $( "#idAuxiliar" ).attr("readonly","readonly");
        $("#idAuxiliar").attr('disabled','disabled');
        $( "#auxiliar" ).attr("readonly","readonly");
        $("#auxiliar").attr('disabled','disabled');
        $("#checksubauxiliar").attr('disabled','disabled');

        $( "#idAuxiliar" ).removeAttr("required","required");
        $( "#auxiliar" ).removeAttr("required","required");
    }
});


$("#checksubauxiliar").on( 'change', function() {
    if( $(this).is(':checked') ) {
        $( "#idSubauxiliar" ).removeAttr("readonly","readonly");
        $("#idSubauxiliar").removeAttr('disabled');
        $( "#subauxiliar" ).removeAttr("readonly","readonly");
        $("#subauxiliar").removeAttr('disabled');

        $( "#idSubauxiliar" ).attr("required","required");
        $( "#subauxiliar" ).attr("required","required");
    } else {
        $( "#idSubauxiliar" ).attr("readonly","readonly");
        $("#idSubauxiliar").attr('disabled','disabled');
        $( "#subauxiliar" ).attr("readonly","readonly");
        $("#subauxiliar").attr('disabled','disabled');

        $( "#idSubauxiliar" ).removeAttr("required","required");
        $( "#subauxiliar" ).removeAttr("required","required");
    }
});
$("#checksubcuenta").on( 'change', function() {
    if( $(this).is(':checked') ) {
        $( "#descripcionSubcuenta" ).removeAttr("readonly","readonly");
        $("#descripcionSubcuenta").removeAttr('disabled');
        // $( "#subauxiliar" ).removeAttr("readonly","readonly");
        // $("#subauxiliar").removeAttr('disabled');

        // $( "#idSubauxiliar" ).attr("required","required");
        // $( "#subauxiliar" ).attr("required","required");
    } else {
        $( "#descripcionSubcuenta" ).attr("readonly","readonly");
        $("#descripcionSubcuenta").attr('disabled','disabled');
        // $( "#subauxiliar" ).attr("readonly","readonly");
        // $("#subauxiliar").attr('disabled','disabled');

        // $( "#idSubauxiliar" ).removeAttr("required","required");
        // $( "#subauxiliar" ).removeAttr("required","required");
    }
});







$("#tercero").on( 'change', function() {
    if ($(this).val()=='3') {
      $("#divPorcentajeRetencion").css("display","block");
      $("#divPorcentajeRetencion").attr("required","required");
    }else{
      $("#divPorcentajeRetencion").css("display","none");
      $("#divPorcentajeRetencion").removeAttr("required");
    }
});



$('.decimales').keyup(function () { 
    this.value = this.value.replace(/[^0-9\,]/g,'');


});


$('[data-toggle="tooltip"]').tooltip();





$("body").on("change","[name='datos[numeroComprobante]']",function(e){

      var idEmpresa=$("#idEmpresa").val();
      var tipoDocumento=$("#tipoDocumento").val();
      var comprobante=$("#comprobante").val();
      var numero=$(this).val();

      console.log(idEmpresa);
      console.log(tipoDocumento);
      console.log(comprobante);
      console.log(numero);
    
      $.ajax({
        url:URL+"functions/comprobantes/consultarcomprobante.php", 
        type:"POST", 
        data: {"tipoDocumento":tipoDocumento,"idEmpresa":idEmpresa,"comprobante":comprobante,"numero":numero}, 
        dataType: "json",

        }).done(function(msg){  
            

          if (msg.comprobante==false) {
            // $("#tabla").css("display","none");
            // $("#divBtnGuardar").css("display","none");
            Swal.fire({
                icon:'error',
                title:"El comprobante ya existe",
                text:"verifique en listar comprobantes",
                closeOnConfirm:true,
              }).then((result)=>{

              })
            }else{
              $("#tabla").css("display","block");
              $("#divBtnGuardar").css("display","block");
            }
      });    

});