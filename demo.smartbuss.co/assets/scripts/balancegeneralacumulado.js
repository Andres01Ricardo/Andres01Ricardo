$("body").on("change","[name='datos[idEmpresa]'], [name='datos[periodo]']",function(e){
	var idEmpresa=$("[name='datos[idEmpresa]']").val();
	var anio=$("[name='datos[periodo]']").val();
	
    if(idEmpresa!=""&&anio!=""){
      $.ajax({
        url:URL+"functions/dashboard/verbalancegeneralanual.php", 
        type:"POST", 
        data: {"idEmpresa":idEmpresa,"anio":anio}, 
        dataType: "json",
        }).done(function(msg){  

          console.log(msg); 
          if(msg!=null){
          		var sHtml=''; 

          		msg.forEach(function(element,index){
          			sHtml+='<tr>';
          			if(element.numeroCuenta==undefined){
          				sHtml+='<td colspan="2" class="negrita text-center">'+element.titulo+'</td>';
          			}else{
          				sHtml+='<td>'+element.numeroCuenta+'</td>';
          				sHtml+='<td>'+element.nombreCuenta+'</td>';	
          			}
          			
          			for (var i = 1; i <= 12; i++) {
          				if(element[i]!=undefined){
          					sHtml+='<td class="text-center">'+element[i].valor+'</td>';
          				}else{
							sHtml+='<td class="text-center">-</td>';
          				}
          			}
          			sHtml+='</tr>';
          		})
          		console.log(sHtml)
          	   $("#tableCuentas tbody").append(sHtml); 
          }
          
      });
    }else{
      $("[name='datos[idCiudad]']").html("<option value=''>Seleccione una opción</option>");
    }
})