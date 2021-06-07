$("body").on("change","[name='datos[idEmpresa]']",function(e){
  $("[name='datos[periodo]']").val("");
  $("#tableCuentas > tbody").empty();
})
$("body").on("change","[name='datos[periodo]']",function(e){
  $("#tableCuentas > tbody").empty();
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
                total=0;
          			if(element.numeroCuenta==undefined){
          				sHtml+='<td colspan="2" class="negrita text-center">'+element.titulo+'</td>';
          			}else{
          				sHtml+='<td>'+element.numeroCuenta+'</td>';
          				sHtml+='<td>'+element.nombreCuenta+'</td>';	
          			}
          			
          			for (var i = 1; i <= 12; i++) {
          				if(element[i]!=undefined){
          					sHtml+='<td class="text-center">'+element[i].valor+'</td>';
                    
                    total=parseFloat(total)+parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda(element[i].valor,"$",""),",",""),".",","));
          				}else{
							sHtml+='<td class="text-center">-</td>';
          				}
          			}
                // total.format(2);
                totalAcumulado=new Intl.NumberFormat().format(total);
          			sHtml+='</tr>';
          		})
          		console.log(sHtml)
          	   $("#tableCuentas tbody").append(sHtml); 
          }
          
      });
    }else{
      $("#tableCuentas > tbody").empty();
    }
})