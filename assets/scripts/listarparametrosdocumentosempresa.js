$(document).ready(function(e){

	dataTable("#tableEnterprise"); 


});



$("body").on("click touchstart",".parametro",function(e){

	$("#frmGuardar")[0].reset(); 

	

	var tipo=$(this).parents("tr").find("td").eq(3).html();

    var comprobante=$(this).parents("tr").find("td").eq(4).html();
    

    var numeracionActual=$(this).parents("tr").find("td").eq(6).html();

    var id = $(this).attr("id");
  
	$("[name='datos[numeracionActual]']").val(numeracionActual); 

	$("#idParametrosDocumentos").val(id); 
	

	$("#comprobante").val(tipo+'-'+comprobante); 



})





$("body").on("click touchstart","#btnGuardar",function(e){
    e.preventDefault();
      if(true === $("#frmGuardar").parsley().validate()){
        Swal.fire({
        title: '¿Está seguro?',
        text: 'Está a punto de modificar la numeración actual del '+$("#comprobante").val(),
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
            url:URL+"functions/parametrosdocumentos/editarnumeracion.php", 
            type:"POST", 
            data: data,
            contentType:false, 
            processData:false, 
            dataType: "json",
            cache:false 
            }).done(function(msg){  
              if(msg.msg){
                Swal.fire(
                 {icon: 'success',
                  title: 'Numeración editada!',
                  text: 'con exito',
                  closeOnConfirm: true,
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
      })
      }
  })