$(document).ready(function(e){
	dataTable("#tableMove");
	dataTable("#tableExtracto"); 
})

$("body").on("change","#fechaInicio",function(e){

	var fechaInicio=$("#fechaInicio").val(); 
	var fechaFin=$("#fechaFin").val(); 
	var ONE_DAY = 1000 * 60 * 60 * 24;

	if(fechaInicio!=""){
		firstDate = new Date(fechaInicio);
	    var date1_ms = firstDate.getTime();
	    var date2_ms = new Date().getTime();
	    
	    var difference_ms = Math.abs(date1_ms - date2_ms);
	    
	    if(date1_ms>=date2_ms){
	    	min=(Math.round(difference_ms/ONE_DAY)+1);
	    }else{
	    	min=(Math.round(difference_ms/ONE_DAY)-1)*-1;
	    }
	    
	    $("#fechaFin").datepicker("destroy").removeClass("hasDatepicker");
		$("#fechaFin").datepicker({ minDate:min, dateFormat:'yy-mm-dd' });
		$("#fechaFin").val('');
	} 
})

$("body").on("change","#fechaFin",function(e){

	var fechaInicio=$("#fechaInicio").val(); 
	var fechaFin=$("#fechaFin").val(); 
	var ONE_DAY = 1000 * 60 * 60 * 24;

	if(fechaFin!=""){
    	firstDate = new Date(fechaFin);
	    var date1_ms = firstDate.getTime();
	    var date2_ms = new Date().getTime();
	    
	    var difference_ms = Math.abs(date2_ms - date1_ms);
	    if(date2_ms>=date1_ms){
	    	max=(Math.round(difference_ms/ONE_DAY)-1)*-1;
	    }else{
	    	max=Math.round(difference_ms/ONE_DAY)+1;
	    }
	    
	    
	    $("#fechaInicio").datepicker("destroy").removeClass("hasDatepicker");
		$("#fechaInicio").datepicker({ maxDate:max, dateFormat:'yy-mm-dd' });
		getMovimientos(); 
    }  
})

function getMovimientos(){
	var fechaInicio=$("#fechaInicio").val();
	var fechaFin=$("#fechaFin").val();
	var id=$("#idCuenta").val(); 
    if(fechaFin!=""&&fechaInicio!=""){
      $.ajax({
        url:URL+"functions/cuentabancaria/vermovimientos.php", 
        type:"POST", 
        data: {"idCuentaBancaria":id,"fechaInicio":fechaInicio,"fechaFin":fechaFin}, 
        dataType: "json",
        }).done(function(msg){  

          if(msg!=null){
          	  var sHtml="";
          	  $("#tableMove").dataTable().fnDestroy();
	          msg.forEach(function(element,index){
	          	sHtml+="<tr>"; 
	          	sHtml+="<td>"+(index+1)+"</td>"; 
	            sHtml+="<td>"+element.fechaRegistro+"</td>"; 
	            sHtml+="<td>"+element.tipoMovimiento+"</td>"; 
	            sHtml+="<td>"+element.movimiento+"</td>"; 
	            sHtml+="<td>"+element.saldoActual+"</td>"; 
	            sHtml+="<td>"+element.saldoAnterior+"</td>"; 
	            sHtml+="</tr>"; 

	          })
	          
	          $("#tableMove tbody").html(sHtml);
	          dataTable("#tableMove"); 
          }
          
      });
    }else{
      $("[name='datos[idCiudad]']").html("<option value=''>Seleccione una opción</option>");
    }
}