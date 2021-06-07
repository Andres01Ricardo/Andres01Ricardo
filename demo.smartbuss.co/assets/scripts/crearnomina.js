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
          $("[name='datos[salario]']").val(msg.valorSalario).trigger("change");
          $("[name='datos[riesgo]']").val(msg.nivelRiesgo);
          $("[name='datos[diasTrabajados]']").val(msg.diasPago);
          var sHtmlA=""; 

          if(msg.adiciones!=null){
            msg.adiciones.forEach(function(element,index){
              sHtmlA+='<tr>'+
                      '<td class="text-center">'+(index+1)+'</td>'+
                      '<td><input type="text" name="adiciones['+index+'][producto]" id="adiciones['+index+'][producto]" class="form-control producto mayusculas" value="'+element.texto+'" required placeholder="Detalle">'+
                        '<input type="hidden" name="adiciones['+index+'][idProducto]" id="adiciones['+index+'][idProducto]" class="form-control idProducto" value="'+element.idTipo+'"></td>'+
                      '<td><input type="text" class="form-control moneda mayusculas valor" readonly value="'+element.valor+'" name="adiciones['+index+'][valor]" id="adiciones['+index+'][valor]" placeholder="valor" required></td>'+
                      '<td style="text-align:center"><a href="javascript:void(0)"  data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn btn-icon btn-sm btn-danger eliminar"><i class="fas fa-trash"></i></a></td>'+
                    '</tr>';  
            })
          }
          
          
          $("#tableAdiciones tbody").html(sHtmlA);

          var sHtmlL=""; 
          if(msg.deduccionesLey!=null){
            var i=0; 
            msg.deduccionesLey.forEach(function(element,index){
            clase=''; 
            if(element.oculto==1){
              clase='ocultar'; 
            }
            sHtmlL+='<tr class="'+clase+'">'+
                    '<td class="text-center">'+(i+1)+'</td>'+
                    '<td><input type="text" name="ley['+index+'][producto]" id="ley['+index+'][producto]" class="form-control producto mayusculas" value="'+element.descripcion+'" required placeholder="Detalle">'+
                      '<input type="hidden" name="ley['+index+'][tipoDeduccion]" id="ley['+index+'][tipoDeduccion]" class="form-control idProducto" value="'+element.oculto+'"></td>'+
                      '<input type="hidden" name="ley['+index+'][tipoConcepto]" id="ley['+index+'][tipoConcepto]" class="form-control idProducto" value="'+element.concepto+'"></td>'+
                    '<td><input type="text" class="form-control moneda mayusculas valor" readonly value="'+element.valor+'" name="ley['+index+'][valor]" id="ley['+index+'][valor]" placeholder="valor" required></td>'+
                    '<td style="text-align:center"><a href="javascript:void(0)"  data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn btn-icon btn-sm btn-danger eliminar"><i class="fas fa-trash"></i></a></td>'+
                  '</tr>';
              if(element.oculto==0){
                i++; 
              }
                
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
                    '<td><input type="text" class="form-control moneda mayusculas valor" readonly value="'+element.valor+'" name="deducciones['+index+'][valor]" id="deducciones['+index+'][valor]" placeholder="valor" required></td>'+
                    '<td style="text-align:center"><a href="javascript:void(0)"  data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn btn-icon btn-sm btn-danger eliminar"><i class="fas fa-trash"></i></a></td>'+
                  '</tr>'; 
          })
          }
          
          $("#tableDeducciones tbody").html(sHtmlD);

          $(".valor").trigger("change"); 
          calcularSalario(); 
      });
    }else{
    }
    
})

calcularSalario=function(){

  var salarioBase=parseFloat(eliminarMoneda(eliminarMoneda($("[name='datos[salario]']").val(),"$",""),",",""))
  var adiciones=0; 
  $("#tableAdiciones .valor").each(function(index,element){
    var valor=0; 
    if($(element).val()!=""){valor=parseFloat(eliminarMoneda(eliminarMoneda($(element).val(),"$",""),",","")); }
    adiciones+=valor
  })
  var ley=0; 
  $("#tableDeduccionesLey tr:not('[class*=ocultar]') .valor").each(function(index,element){
    var valor=0; 
    if($(element).val()!=""){valor=parseFloat(eliminarMoneda(eliminarMoneda($(element).val(),"$",""),",","")); }
    ley+=valor
  })

  var deducciones=0; 
  $("#tableDeducciones .valor").each(function(index,element){
    var valor=0; 
    if($(element).val()!=""){valor=parseFloat(eliminarMoneda(eliminarMoneda($(element).val(),"$",""),",","")); }
    deducciones+=valor
  })
  
  var total=salarioBase+adiciones-ley-deducciones; 
  
  $("[name='datos[valorPagar]']").val(total).trigger('change')
}

$("body").on("click",".eliminar",function(e){
  $(this).parents("tr").remove(); 
  calcularSalario(); 
})

$("body").on("click","#btnGuardar",function(e){
    
  e.preventDefault();
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
              Swal.fire(
                {
                icon: 'success',
                title: 'Nomina Registrada!',
                text: 'con exito',
                closeOnConfirm: true,
              }
              ).then((result) => {
               location.reload(); 
              })
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
              ).then((result) => {
                
              })
              }
               
            }
          
        });    
        });
      }
  }).then((result) => {
    if (result.isConfirmed) {
    } 

   })
  })