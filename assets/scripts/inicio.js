$(document).ready(function(e){
	$('.select2').select2(); 
	$('.datatooltip').tooltip(); 
	$( ".datepicker" ).datepicker({ dateFormat:'yy-mm-dd' });
	



	function changeNumber() {
        // value = $('#value').text();
        $.ajax({
            type: "POST",
            url:"functions/sesion/verificarsesion.php", 
            success: function(data) {
                // $('#value').text(data);
                if (data==false) {
                	location.reload();
                }
                console.log(data);
                // alert('funciona');
            }
        });
        
    }
	setInterval(changeNumber, 120000);
	// setInterval(changeNumber, 5000);
})


    
    

function dataTable($elemento){
	$($elemento).dataTable({
	  "columnDefs": [
	  ]
	});
}

function eliminarMoneda(valor,buscar,reemplazar){
	return valor.split(buscar).join(reemplazar); 
}
// $("body").on("keyup, change",".moneda",function(e){
// 	$('.moneda').formatCurrency({roundToDecimalPlace:0});
// })

$("body").on(" change",".moneda",function(e){

	$(this).formatCurrency({decimalSymbol:',',digitGroupSymbol:'.'});

// var v=$(this).val();	


})
$("body").on("keyup",".numero",function(e){
	this.value = this.value.replace(/[^0-9]/g,'');
})
$("body").on("change",".decimal",function(e){
	
	$('.decimal').formatCurrency({roundToDecimalPlace:1, symbol: ''});

})

$("body").on("change",".custom-file-input",function(e){
  var filename = $(this)[0].files.length ? $(this)[0].files[0].name : "Seleccionar archivo";
  $(this).parents(".custom-file").find(".custom-file-label").html(filename)
})