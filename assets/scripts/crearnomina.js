$(document).ready(function(e){
  if ($("#idEmpresa").val()!="") {
      var id=$("#idEmpresa").val();

      $("#periodoPago").val($(this).find("option:selected").attr("pago"));
      if($(this).find("option:selected").attr("pago")==1){

        $("[name='datos[tiempoPago]']").removeAttr("required"); 

        $("[name='datos[tiempoPago]']").attr("disabled","disabled"); 

        $("[name='datos[tiempoPago]']").val(''); 

      }else if($(this).find("option:selected").attr("pago")==2){

        $("[name='datos[tiempoPago]']").attr("required","required"); 

        $("[name='datos[tiempoPago]']").removeAttr("disabled"); 

      }

      $.ajax({

        url:URL+"functions/nomina/empleados.php", 

        type:"POST", 

        data: {"idEmpresa":id}, 

        dataType: "json",

        }).done(function(msg){  

          var sHtml="<option value=''>Seleccione una opción</option>"; 

          msg.lista.forEach(function(element,index){

            sHtml+="<option value='"+element.idEmpleado+"'>"+element.nombre+" "+element.apellido+"</option>"; 

          })



          $("[name='datos[idEmpleado]']").html(sHtml);

      });



       $.ajax({

        url:URL+"functions/nomina/consultarparametrizacionnomina.php", 

        type:"POST", 

        data: {"idEmpresa":id}, 

        dataType: "json",

        }).done(function(msg){  

          console.log(msg);

          if (msg.msg==false) {
            Swal.fire({
              icon: 'error',
              title: "Faltan cosas por parametrizar en la nómina!",
              text: 'Por favor revise la parametrización',
              closeOnConfirm: true,
            }).then((result) => {

             location.href="configurarcontableempresas";
             // location.href="http://www.pagina2.com";

            })
          }


      });

  }
})





$("body").on("change","[name='datos[idEmpresa]']",function(e){

    var id=$(this).val(); 



    if(id!=""){

      $("#periodoPago").val($(this).find("option:selected").attr("pago"));



      if($(this).find("option:selected").attr("pago")==1){

        $("[name='datos[tiempoPago]']").removeAttr("required"); 

        $("[name='datos[tiempoPago]']").attr("disabled","disabled"); 

        $("[name='datos[tiempoPago]']").val(''); 

      }else if($(this).find("option:selected").attr("pago")==2){

        $("[name='datos[tiempoPago]']").attr("required","required"); 

        $("[name='datos[tiempoPago]']").removeAttr("disabled"); 

      }

      $.ajax({

        url:URL+"functions/nomina/empleados.php", 

        type:"POST", 

        data: {"idEmpresa":id}, 

        dataType: "json",

        }).done(function(msg){  

          var sHtml="<option value=''>Seleccione una opción</option>"; 

          msg.lista.forEach(function(element,index){

            sHtml+="<option value='"+element.idEmpleado+"'>"+element.nombre+" "+element.apellido+"</option>"; 

          })



          $("[name='datos[idEmpleado]']").html(sHtml);

      });

    }else{

      $("[name='datos[idEmpleado]']").html("<option value=''>Seleccione una opción</option>");

    }

    

})



$("body").on("change","[name='datos[idEmpleado]'], [name='datos[periodo]']",function(e){

    var idEmpleado=$("[name='datos[idEmpleado]']").val(); 

    var idPeriodo=$("[name='datos[periodo]']").val();

    var idEmpresa=$("[name='datos[idEmpresa]']").val(); 

    var periodoPago=$("#periodoPago").val(); 

    if(idEmpleado!=""&&idPeriodo!=""){
      

      


      $.ajax({

        url:URL+"functions/nomina/informacionempleado.php", 

        type:"POST", 

        data: {"idEmpresa":idEmpresa,"idEmpleado":idEmpleado,"idPeriodo":idPeriodo,"tiempo":periodoPago}, 

        dataType: "json",

        }).done(function(msg){ 

          console.log(msg);

          $("[name='datos[salario]']").val(msg.valorSalario).trigger("change");

          $("[name='datos[riesgo]']").val(msg.nivelRiesgo);

          $("[name='datos[diasTrabajados]']").val(msg.diasPago);
          $("[name='datos[auxilioTransporteInicial]']").val(msg.auxilioTransporte);

          $("#vacacionesControl").val(msg.vacaciones);
          // $("#salarioIncapacidad").val(msg.vacaciones);
          var vacacionesControl=msg.vacaciones;
          // var incapacidadControl=msg.incapacidad;

          var permiso =msg.permiso;

          $("[name='datos[permiso]']").val(msg.permiso);

          var sHtmlA=""; 



          if(msg.adiciones!=null){

            msg.adiciones.forEach(function(element,index){

              $("#salarioIncapacidad").val(element.valorIncapacidad);

              $("#diasIncapacidad").val(element.diasIncapacidad);

              console.log(element.valorIncapacidad);
              if (element.idTipo==4) {
              var incluir ='<td><input type="text" name="adiciones['+index+'][cuentaContable]" id="adiciones['+index+'][cuentaContable]" readonly required value="no aplica">';

            }
            if (element.idTipo!=4) {
              var incluir ='<td><select class="form-control select2 cuentaContable " name="adiciones['+index+'][cuentaContable]" id="adiciones['+index+'][cuentaContable]" required ></select>';

            }
    sHtmlA+='<tr>'+

            '<td class="text-center">'+(index+1)+'</td>'+

            '<td><input type="text" name="adiciones['+index+'][producto]" id="adiciones['+index+'][producto]" class="form-control producto mayusculas" value="'+element.texto+'" required placeholder="Detalle">'+

              '<input type="hidden" name="adiciones['+index+'][idProducto]" id="adiciones['+index+'][idProducto]" class="form-control idProducto" value="'+element.idTipo+'"></td>'+
              '<input type="hidden" name="adiciones['+index+'][idNovedad]" id="adiciones['+index+'][idNovedad]" class="form-control idNovedad" value="'+element.idNovedad+'"></td>'+

            '<td><input type="text" class="form-control moneda mayusculas valor" readonly value="'+element.valor+'" name="adiciones['+index+'][valor]" id="adiciones['+index+'][valor]" placeholder="valor" required></td>'+
            
            incluir+



            '<td style="text-align:center"><a href="javascript:void(0)"  data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn btn-icon btn-sm btn-danger eliminar"><i class="fas fa-trash"></i></a></td>'+

          '</tr>';  

            })

          }
// <input type="text" class="form-control moneda mayusculas valor" readonly value="'+element.valor+'" name="adiciones['+index+'][valor]" id="adiciones['+index+'][valor]" placeholder="valor" required></td>
          

          $("#tableAdiciones tbody").html(sHtmlA);



          var sHtmlL=""; 

          if(msg.deduccionesLey!=null){

            var i=0; 

            msg.deduccionesLey.forEach(function(element,index){

            clase=''; 

            if(element.oculto==1){

              clase='empleador'; 

            }
            if (element.concepto==3 ) {
              // alert('ingreso');
              element.valor=(element.valor/30)*msg.diasPago;
              // alert(element.valor);
            }

            sHtmlL+='<tr class="'+clase+'">'+

                    '<td class="text-center">'+(i+1)+'</td>'+

                    '<td><input type="text" name="ley['+index+'][producto]" id="ley['+index+'][producto]" class="form-control producto mayusculas" value="'+element.descripcion+'" required placeholder="Detalle">'+

                      '<input type="hidden" name="ley['+index+'][tipoDeduccion]" id="ley['+index+'][tipoDeduccion]" class="form-control idProducto" value="'+element.oculto+'"></td>'+

                      '<input type="hidden" name="ley['+index+'][tipoConcepto]" id="ley['+index+'][tipoConcepto]" class="form-control idProducto" value="'+element.concepto+'"></td>'+


                    '<td><input type="text" class="form-control moneda mayusculas valor '+clase+'" readonly value="'+element.valor+'" name="ley['+index+'][valor]" id="ley['+index+'][valor]" placeholder="valor" required></td>'+
                      
                    '<td><select class="form-control terceroCargar" name="ley['+index+'][tercero]" id="ley['+index+'][tercero]" required ></select>'+

                    '<td style="text-align:center"><a href="javascript:void(0)"  data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn btn-icon btn-sm btn-danger eliminar"><i class="fas fa-trash"></i></a></td>'+

                  '</tr>';

                i++; 
              // if(element.oculto==0){
              // }

                

          })

          }

          

          $("#tableDeduccionesLey tbody").html(sHtmlL);



          var sHtmlD=""; 

          if(msg.deducciones!=null){

            msg.deducciones.forEach(function(element,index){

            sHtmlD+='<tr>'+

                    '<td class="text-center">'+(index+1)+'</td>'+

                    '<td><input type="text" name="deducciones['+index+'][producto]" id="deducciones['+index+'][producto]" class="form-control producto mayusculas" value="'+element.texto+'" required placeholder="Detalle">'+

                      '<input type="hidden" name="deducciones['+index+'][idProducto]" id="deducciones['+index+'][idProducto]" class="form-control idProducto" value="'+element.idTipo+'"></td>'+
                      '<input type="hidden" name="deducciones['+index+'][idNovedad]" id="deducciones['+index+'][idNovedad]" class="form-control idNovedad" value="'+element.idNovedad+'"></td>'+

                    '<td><input type="text" class="form-control moneda mayusculas valor" readonly value="'+element.valor+'" name="deducciones['+index+'][valor]" id="deducciones['+index+'][valor]" placeholder="valor" required></td>'+

                    '<td style="text-align:center"><a href="javascript:void(0)"  data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn btn-icon btn-sm btn-danger eliminar"><i class="fas fa-trash"></i></a></td>'+
                  '</tr>'; 
          })
          }

          $("#tableDeducciones tbody").html(sHtmlD);
          $(".valor").trigger("change"); 
          calcularSalario(); 
          calcularProvisiones();

          cargarCuentas();

          cargarTerceros();
      });
    }else{
    }
})


cargarCuentas=function(){
  // var salarioBase=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($("[name='datos[salario]']").val(),"$",""),".",""),",","."));
  
  var idEmpresa=$("[name='datos[idEmpresa]'").val();
  console.log(idEmpresa);

      $.ajax({
        url:URL+"functions/cuentascontables/cargarcuentascontables.php", 
        type:"POST", 
        data: {"idEmpresa":idEmpresa}, 
        dataType: "json",
        }).done(function(msg){  
          // var $aDatos=[];
          console.log(msg);
          if (msg.length==0) {
            $(".cuentaContable").val('No hay cuentas contables creadas');
            $(".cuentaContable").attr('disabled','disabled');

          }
          if (msg.length!=0) {
            var sHtmlC='<option value="">Seleccione</option>';

          msg.forEach(function(element,index){
            sHtmlC+='<option value="'+element.idCuentaContable+'">'+element.codigoCuentaContable+' - '+element.nombre+'</option>';
            
          })
          $(".cuentaContable").attr("required","required");
          $(".cuentaContable").select2();
          $(".cuentaContable").html(sHtmlC);
          
          // autocomplete(); 
        }
      }); 

}


$("body").on("change",".cuentaContable",function(e){
  if ($(this).val()!="") {
  
    $(this).removeAttr("required");
  
  }

  if ($(this).val()=="") {
  
    $(this).attr("required","required");
  
  }
  
})


cargarTerceros=function(){
  // var salarioBase=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($("[name='datos[salario]']").val(),"$",""),".",""),",","."));  
  var idEmpresa=$("[name='datos[idEmpresa]'").val();
  console.log(idEmpresa);

          $.ajax({
            url:URL+"functions/terceros/cargarterceros.php", 
            type:"POST", 
            data: {"idEmpresa":idEmpresa}, 
            dataType: "json",
            }).done(function(msg){
            // console.log(msg);
            var sHtmlT='<option value="">Seleccione</option>';
              msg.forEach(function(element,index){
                  sHtmlT+='<option value="'+element[0]+'">'+element.nit+' - '+element.razonSocial+'</option>';
              })
              // $(".terceroCargar").addClass("select2");
              $(".terceroCargar").attr("required","required");
              $('.terceroCargar').select2();
              $(".terceroCargar").html(sHtmlT).trigger("change");
        }); 
  }
      

$("body").on("change",".terceroCargar",function(e){
  if ($(this).val()!="") {
  
    $(this).removeAttr("required");
  
  }

  if ($(this).val()=="") {
  
    $(this).attr("required","required");
  
  }
  
})



calcularProvisiones=function(){
  var salarioBase=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($("[name='datos[salario]']").val(),"$",""),".",""),",","."));
  if ($("#vacacionesControl").val() ==0) {
    var diasTrabajados=$("#diasTrabajados").val();

  }
  if ($("#vacacionesControl").val() ==1 || $("#vacacionesControl").val() ==2) {
    var diasTrabajados=30;
  }

  if ($("#diasIncapacidad").val()!="") {
    diasTrabajados=parseInt($("#diasTrabajados").val())+parseInt($("#diasIncapacidad").val());
  }
  var salarioDias= (salarioBase/30)*diasTrabajados;
  salarioDias=Math.round(salarioDias);
  
  var auxilioTransporte=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($("#auxilioTransporteInicial").val(),"$",""),".",""),",","."));
  var valorAuxilioTransporte=(auxilioTransporte/30)*diasTrabajados;
  valorAuxilioTransporte=Math.round(valorAuxilioTransporte);
  

  var cesantias=((salarioDias+valorAuxilioTransporte)*8.333)/100;
  cesantias=Math.round(cesantias);
  var interesesCesantias=((cesantias))/100;
  interesesCesantias=Math.round(interesesCesantias);

  var permiso =$("#permiso").val();
  // console.log(permiso);
  if (permiso==0) {

    var prima=((salarioDias+valorAuxilioTransporte)*8.333)/100;
  }

  if (permiso!=0) {
      var diaPrima=parseInt(diasTrabajados)+parseInt(permiso);
      var salarioDiasPermiso= (salarioBase/30)*(diaPrima);
      salarioDiasPermiso=Math.round(salarioDiasPermiso);
      console.log('salarioBase:');
      console.log(salarioBase);

      console.log('diasTrabajados:');
      console.log(diasTrabajados);

      console.log('permiso:');
      console.log(permiso);

      console.log('salarioDiasPermiso:');
      console.log(salarioDiasPermiso);
      
      var valorAuxilioTransportePermiso=(auxilioTransporte/30)*(diaPrima);
      valorAuxilioTransportePermiso=Math.round(valorAuxilioTransportePermiso);

      console.log('valorAuxilioTransportePermiso:');
      console.log(valorAuxilioTransportePermiso);
      
      var prima=((salarioDiasPermiso+valorAuxilioTransportePermiso)*8.333)/100;
  }

  prima=Math.round(prima);
  var vacaciones=((salarioDias)*4.166)/100;
  vacaciones=Math.round(vacaciones);
  
  $("#cesantias").val(cesantias).trigger('change');
  $("#interesesCesantias").val(interesesCesantias).trigger('change');
  $("#prima").val(prima).trigger('change');
  $("#vacaciones").val(vacaciones).trigger('change');
}


calcularSalario=function(){



  var salarioBase=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($("[name='datos[salario]']").val(),"$",""),".",""),",","."));

  var adiciones=0; 
  var diasTrabajados=$("#diasTrabajados").val();
  var salarioDias= (salarioBase/30)*diasTrabajados;
  var auxilioTransporte=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($("#auxilioTransporteInicial").val(),"$",""),".",""),",","."));
  var valorAuxilioTransporte=(auxilioTransporte/30)*diasTrabajados;
  $("#auxilioTransporte").val(valorAuxilioTransporte).trigger('change');
  $("#tableAdiciones .valor").each(function(index,element){

    var valor=0; 
    console.log($("[name='adiciones["+index+"][idProducto]']").val());
    if ($("[name='adiciones["+index+"][idProducto]']").val()!=4) {

      if($(element).val()!=""){valor=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($(element).val(),"$",""),".",""),",",".")); }

      adiciones+=valor
    
    }

  })
// alert(adiciones);
  var ley=0; 

  $("#tableDeduccionesLey tr:not('[class*=empleador]') .valor").each(function(index,element){

    var valor=0; 

    if($(element).val()!=""){valor=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($(element).val(),"$",""),".",""),",",".")); }

    ley+=valor

  })



  var deducciones=0; 

  $("#tableDeducciones .valor").each(function(index,element){

    var valor=0; 

    if($(element).val()!=""){valor=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($(element).val(),"$",""),".",""),",",".")); }

    deducciones+=valor

  })

  

  var total=salarioDias+valorAuxilioTransporte+adiciones-ley-deducciones; 

    

  $("[name='datos[valorPagar]']").val(total).trigger('change')

}

$("body").on("keyup","#diasTrabajados",function(e){
  var cantidadDias= $(this).val();
  if (cantidadDias!="") {
    calcularSalario();
    calcularProvisiones();

  }
})
$("body").on("keyup","#diasSeguridadSocial",function(e){
  var cantidadDiasSeguridadSocial= $(this).val();
  var cantidadDiasIncapacidad=$("#diasIncapacidad").val();
  var inputSalud=document.getElementById("ley[0][producto]").value;
  var inputARL=document.getElementById("ley[2][producto]").value;
  var inputCajaCompensacion=document.getElementById("ley[3][producto]").value;
  var inputSaludEmpleador=document.getElementById("ley[4][producto]").value;
  var inputPensionEmpleador=document.getElementById("ley[5][producto]").value;
  var inputValorSalud=document.getElementById("ley[0][valor]");
  var inputValorPension=document.getElementById("ley[1][valor]");
  var inputValorARL=document.getElementById("ley[2][valor]");
  var inputValorCajaCompensacion=document.getElementById("ley[3][valor]");
  var inputValorSaludEmpleador=document.getElementById("ley[4][valor]");
  var inputValorPensionEmpleador=document.getElementById("ley[5][valor]");
  var porcentajeSalud=inputSalud.substring(6,7);
  var porcentajeSalud=inputSalud.substring(6,7);

  var porcentajeARL=inputARL.split(' ');
  var porcentajeARL2=porcentajeARL[3].split('%');


  var porcentajeCajaCompensacion=inputCajaCompensacion.split(' ');
  var porcentajeCajaCompensacion2=porcentajeCajaCompensacion[2].split('%');

  var porcentajeSaludEmpleador=inputSaludEmpleador.split(' ');
  var porcentajeSaludEmpleador2=porcentajeSaludEmpleador[1].split('%');


  var porcentajePensionEmpleador=inputPensionEmpleador.split(' ');
  var porcentajePensionEmpleador2=porcentajePensionEmpleador[1].split('%');


  var salarioBase=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($("[name='datos[salario]']").val(),"$",""),".",""),",","."));
  
  if ($("#salarioIncapacidad").val()!="") {
    var diasTotalS=parseInt(cantidadDiasSeguridadSocial)+parseInt(cantidadDiasIncapacidad);
    // alert(diasTotalS);
    var valorSeguridadSocial =((($("#salarioIncapacidad").val()*parseFloat(porcentajeSalud))/100)/30)*diasTotalS;  

    var valorPensionEmpleador =(((salarioBase*parseFloat(porcentajePensionEmpleador2))/100)/30)*diasTotalS;

  }
  if ($("#salarioIncapacidad").val()=="") {
    var valorSeguridadSocial =(((salarioBase*parseFloat(porcentajeSalud))/100)/30)*cantidadDiasSeguridadSocial;  

    var valorPensionEmpleador =(((salarioBase*parseFloat(porcentajePensionEmpleador2))/100)/30)*cantidadDiasSeguridadSocial;
  }
  
  var valorARL =(((salarioBase*parseFloat(porcentajeARL2))/100)/30)*cantidadDiasSeguridadSocial;
  var valorCajaCompensacion =(((salarioBase*parseFloat(porcentajeCajaCompensacion2))/100)/30)*cantidadDiasSeguridadSocial;
  var valorSaludEmpleador =(((salarioBase*parseFloat(porcentajeSaludEmpleador2))/100)/30)*cantidadDiasSeguridadSocial;
  var valorPensionEmpleador =(((salarioBase*parseFloat(porcentajePensionEmpleador2))/100)/30)*cantidadDiasSeguridadSocial;
  // alert(valorSeguridadSocial);
  // inputValorSalud.value=valorSeguridadSocial.toFixed(3);
  // inputValorPension.value=valorSeguridadSocial.toFixed(3);
  
  // inputValorSalud.value=valorSeguridadSocial.toFixed(3);
  $("[name='ley[0][valor]']").val(valorSeguridadSocial.toFixed(3)).trigger('change');
  $("[name='ley[1][valor]']").val(valorSeguridadSocial.toFixed(3)).trigger('change');
  $("[name='ley[2][valor]']").val(valorARL.toFixed(3)).trigger('change');
  $("[name='ley[3][valor]']").val(valorCajaCompensacion.toFixed(3)).trigger('change');
  $("[name='ley[4][valor]']").val(valorSaludEmpleador.toFixed(3)).trigger('change');
  $("[name='ley[5][valor]']").val(valorPensionEmpleador.toFixed(3)).trigger('change');
  calcularSalario();
  // calcularSalario();
})





$("body").on("keyup","#valorSeguridadSocial",function(e){
  var salarioBase= $(this).val();
  var cantidadDiasSeguridadSocial= $("#diasSeguridadSocial").val();
  if (cantidadDiasSeguridadSocial=="") {
    cantidadDiasSeguridadSocial= $("#diasTrabajados").val();
  }
  var cantidadDiasIncapacidad=$("#diasIncapacidad").val();
  var inputSalud=document.getElementById("ley[0][producto]").value;
  var inputARL=document.getElementById("ley[2][producto]").value;
  var inputCajaCompensacion=document.getElementById("ley[3][producto]").value;
  var inputSaludEmpleador=document.getElementById("ley[4][producto]").value;
  var inputPensionEmpleador=document.getElementById("ley[5][producto]").value;
  var inputValorSalud=document.getElementById("ley[0][valor]");
  var inputValorPension=document.getElementById("ley[1][valor]");
  var inputValorARL=document.getElementById("ley[2][valor]");
  var inputValorCajaCompensacion=document.getElementById("ley[3][valor]");
  var inputValorSaludEmpleador=document.getElementById("ley[4][valor]");
  var inputValorPensionEmpleador=document.getElementById("ley[5][valor]");
  var porcentajeSalud=inputSalud.substring(6,7);
  var porcentajeSalud=inputSalud.substring(6,7);

  var porcentajeARL=inputARL.split(' ');
  var porcentajeARL2=porcentajeARL[3].split('%');

  var porcentajeCajaCompensacion=inputCajaCompensacion.split(' ');
  var porcentajeCajaCompensacion2=porcentajeCajaCompensacion[2].split('%');

  var porcentajeSaludEmpleador=inputSaludEmpleador.split(' ');
  var porcentajeSaludEmpleador2=porcentajeSaludEmpleador[1].split('%');

  var porcentajePensionEmpleador=inputPensionEmpleador.split(' ');
  var porcentajePensionEmpleador2=porcentajePensionEmpleador[1].split('%');
  // var salarioBase=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($("[name='datos[salario]']").val(),"$",""),".",""),",","."));

  if ($("#salarioIncapacidad").val()!="") {
    var diasTotalS=parseInt(cantidadDiasSeguridadSocial)+parseInt(cantidadDiasIncapacidad);
    var valorSeguridadSocial =((($("#salarioIncapacidad").val()*parseFloat(porcentajeSalud))/100)/30)*diasTotalS;  
    var valorPensionEmpleador =(((salarioBase*parseFloat(porcentajePensionEmpleador2))/100)/30)*diasTotalS;
  }
  if ($("#salarioIncapacidad").val()=="") {
    var valorSeguridadSocial =(((salarioBase*parseFloat(porcentajeSalud))/100)/30)*cantidadDiasSeguridadSocial;  
    var valorPensionEmpleador =(((salarioBase*parseFloat(porcentajePensionEmpleador2))/100)/30)*cantidadDiasSeguridadSocial;
  }
  var valorARL =(((salarioBase*parseFloat(porcentajeARL2))/100)/30)*cantidadDiasSeguridadSocial;
  var valorCajaCompensacion =(((salarioBase*parseFloat(porcentajeCajaCompensacion2))/100)/30)*cantidadDiasSeguridadSocial;
  var valorSaludEmpleador =(((salarioBase*parseFloat(porcentajeSaludEmpleador2))/100)/30)*cantidadDiasSeguridadSocial;
  var valorPensionEmpleador =(((salarioBase*parseFloat(porcentajePensionEmpleador2))/100)/30)*cantidadDiasSeguridadSocial;
  
  $("[name='ley[0][valor]']").val(valorSeguridadSocial.toFixed(3)).trigger('change');
  $("[name='ley[1][valor]']").val(valorSeguridadSocial.toFixed(3)).trigger('change');
  $("[name='ley[2][valor]']").val(valorARL.toFixed(3)).trigger('change');
  $("[name='ley[3][valor]']").val(valorCajaCompensacion.toFixed(3)).trigger('change');
  $("[name='ley[4][valor]']").val(valorSaludEmpleador.toFixed(3)).trigger('change');
  $("[name='ley[5][valor]']").val(valorPensionEmpleador.toFixed(3)).trigger('change');
  calcularSalario();
  // calcularSalario();
})






$("body").on("click touchstart",".eliminar",function(e){

  $(this).parents("tr").remove(); 

  calcularSalario(); 

})



$("body").on("click touchstart","#btnGuardar",function(e){

    

  e.preventDefault();

  var adicionRequerido=0;
  var terceroRequerido=0;
  $('.cuentaContable').each(function() { 

    if ($(this).attr('required')=='required') {
      adicionRequerido=1;
    }

  })

  $('.terceroCargar').each(function() { 

    if ($(this).attr('required')=='required') {
      terceroRequerido=1;

      console.log('falta tercero')
    }

  })


    if (adicionRequerido==0) {
      if (terceroRequerido==0) {


        Swal.fire({
          title: 'Está seguro?',
          text: 'Está a punto de registrar la nomina de este empleado!',
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
                url:URL+"functions/nomina/crearnomina.php", 
                type:"POST", 
                data: data,
                contentType:false, 
                processData:false, 
                dataType: "json",
                cache:false 
                }).done(function(msg){  
                  if(msg.msg){
                    if (msg.empleado!=0 && msg.empleador!=0 && msg.provisiones!=0) {
                        Swal.fire({
                          icon: 'success',
                          title: "Nómina creada con exito!",
                          text: 'comprobantes: '+msg.empleado+' , '+msg.empleador+' , '+msg.provisiones,
                          closeOnConfirm: true,
                        }
                        ).then((result) => {
                         location.reload();  
                        })
                       }
                      else{
                        Swal.fire({
                          icon: 'success',
                          title: "Nomina creada con exito!",
                          text: 'no se pudo crear los comprobantes faltan cosas por parametrizar ',
                          closeOnConfirm: true,
                        }).then((result) => {
                         location.reload();  
                        })
                       }
                  }else{
                    if(msg.tipo==1){
                      Swal.fire(
                      'Algo ha salido mal!',
                        'La nomina de este mes ya fué finalizada',
                        'error'
                      ).then((result) => {
                      })
                    }else{
                      Swal.fire(
                      'Algo ha salido mal!',
                      'Ya se ha registrado la nomina a este empleado',
                      'error'
                    )
                    }
                  }
              });    
              });
            }
        })
      }else{
      Swal.fire(
        'Falta terceros por seleccionar en las deducciones de ley!',
          'por favor seleccione los terceros antes de continuar',
          'error'
        )
    }
    }else{
      Swal.fire(
        'Falta cuentas contables por seleccionar en las adiciones!',
          'por favor seleccione las cuenta antes de continuar',
          'error'
        )
    }
  })




$("body").on("change","[name='datos[tipoDocumento]']",function(e){
  var numero =$("#tipoDocumento").find("option:selected").attr("numeracion");
  console.log(numero);

  $("#numeroComprobante").val(numero);
});