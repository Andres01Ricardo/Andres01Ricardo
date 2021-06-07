$(document).ready(function(e){
	dataTable("#tableImpuestos"); 
})

$("body").on("change","[name='datos[tipo]']",function(e){
  if($(this).val()==1){
    $(".ica").addClass("ocultar");
    $("[name='datos[idDepartamento]']").removeAttr("required");
    $("[name='datos[idCiudad]']").removeAttr("required");
  }else if($(this).val()==2){
    $(".ica").removeClass("ocultar");
    $("[name='datos[idDepartamento]']").attr("required",true);
    $("[name='datos[idCiudad]']").attr("required",true);
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

$("body").on("click touchstart","#btnGuardar",function(e){
    e.preventDefault();
      if(true === $("#frmGuardar").parsley().validate()){
            var formu = document.getElementById("frmGuardar");
            
            var data = new FormData(formu);
            $.ajax({
            url:URL+"functions/configuracion/guardarretenciones.php", 
            type:"POST", 
            data: data,
            contentType:false, 
            processData:false, 
            dataType: "json",
            cache:false 
            }).done(function(msg){  
              if(!msg.error){
                if(msg.msg){

                  Swal.fire(
                  {
                    icon: 'success',
                    title: "Retencion registrada!",
                    text: 'con exito',
                    closeOnConfirm: true,
                  }
                  ).then((result) => {
                   $("#limpiar").trigger("click"); 
                        var sHtml=""; 
                        msg.lista.forEach(function(element,index){
                           var cont=index+1; 
                           var descripcion=element.tipo==1?'RETENCIONES':'ICA'; 
                           sHtml+="<tr>"+
                           "<td>"+cont+"</td>"+
                           "<td>"+descripcion+"</td>"+
                           "<td>"+element.descripcion+"</td>"+
                           "<td>"+element.valor+"%</td>"+
                           "<td>"; 
                           if(element.tipo!=1){
                            sHtml+=element.ciudad; 
                           }
                           sHtml+="</td>"+
                           "<td class='centrar'>"+
                           '<a href="javascript:void(0)" name="'+element.idRetencion+'" class="btn btn-icon btn-sm btn-warning editar" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>'; 
                           if(element.estado==1){
                            sHtml+='<a href="javascript:void(0)" class="btn btn-icon btn-sm btn-danger inactivar" accion="1" name="'+element.idRetencion+'" data-toggle="tooltip" data-placement="top" title="Desactivar"><i class="fas fa-times"></i></a>'; 
                           }else{
                            sHtml+='<a href="javascript:void(0)" class="btn btn-icon btn-sm btn-success activar" data-toggle="tooltip" data-placement="top" title="Activar" accion="2" name="'+element.idRetencion+'"><i class="fas fa-check"></i></a>'; 
                           }
                           "</td>"+
                          "</tr>"; 
                        })
                        $("#tableImpuestos tbody").html(sHtml);
                  })

                    
                  }else{
                     Swal.fire(
                      'Algo ha salido mal!',
                      'Verifique su conexión a internet',
                      'error'
                    ).then((result) => {
                      
                    })
                  }
              }else{
                location.href=msg.msg; 
              }
            
          });
       
      }
  })

$("body").on("click touchstart",".editar",function(e){
	var id=$(this).attr("name")
	$.ajax({
        url:URL+"functions/configuracion/verretencion.php", 
        type:"POST", 
        data: {"id":id}, 
        dataType: "json",
        }).done(function(msg){  

          var sHtml="<option value=''>Seleccione una opción</option>"; 
          msg.ciudades.forEach(function(element,index){
            sHtml+="<option value='"+element.idCiudad+"'>"+element.nombre+"</option>"; 
          })

          $("[name='datos[idCiudad]']").html(sHtml);

          $("[name='datos[tipo]']").val(msg.datos.tipo)
          $("[name='datos[descripcion]']").val(msg.datos.descripcion)
          $("[name='datos[valor]']").val(msg.datos.valor)
          $("[name='datos[idDepartamento]']").val(msg.datos.idDepartamento)
          $("[name='datos[idCiudad]']").val(msg.datos.idCiudad)
          $("#id").val(msg.datos.idRetencion)
          if(msg.datos.tipo==1){
          	$(".ica").addClass("ocultar");
            $("[name='datos[idDepartamento]']").removeAttr("required");
            $("[name='datos[idCiudad]']").removeAttr("required");
          }else{
          	$(".ica").removeClass("ocultar");
            $("[name='datos[idDepartamento]']").attr("required",true);
            $("[name='datos[idCiudad]']").attr("required",true);
          }
      });
})

$("body").on("click touchstart","#limpiar",function(e){
	$("#frmGuardar")[0].reset();
	$(".ica").addClass("ocultar");
})

$("body").on("click touchstart",".activar,.inactivar",function(e){
  var elemento=this;
  var tipo=$(this).attr("accion"); 
  var id=$(this).attr("name"); 
  var mensaje=tipo==1?"Desactivar":"Activar"; 
   e.preventDefault();
   Swal.fire({
          title: 'Está seguro?',
          text: 'Está a punto de '+mensaje+' esta deducción?',
          icon: 'warning', 
          showCancelButton: true,
          showLoaderOnConfirm: true,
          confirmButtonText: `Si, Continuar!`,
          cancelButtonText:'Cancelar',
          preConfirm: function(result) {
          return new Promise(function(resolve) {
             $.ajax({
              url:URL+"functions/configuracion/activardesactivarretencion.php", 
              type:"POST", 
              data: {"idRetencion":id,"accion":tipo},
              dataType: "html",
              }).done(function(msg){  
                if(!msg.msg){

                  var sConfirmacion=tipo==1?"Desactivada":"Activada"
                  Swal.fire(
                      {
                        icon: 'success',
                        title: "Retencion "+sConfirmacion,
                        text: 'con exito',   
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
  })