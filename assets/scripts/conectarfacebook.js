$(document).ready(function(e){
	$("#divCampana").css("display","none");
	$("#divParametros").css("display","none");
})


$("body").on("change","#pagina",function(e){
	
	if ($(this).val()!="") {
		$("#divCampana").css("display","block");
		
	}
	if ($(this).val()=="") {
		$("#divCampana").css("display","none");
		$("#divParametros").css("display","none");
	}
});

$("body").on("change","#campana",function(e){
	if ($(this).val()!="") {
		$("#divParametros").css("display","block");	
	}
	if ($(this).val()=="") {
		$("#divParametros").css("display","none");
	}
});

$("body").on("click touchstart","#btnGuardar",function(e){
    e.preventDefault();
      if(true === $("#frmGuardar").parsley().validate()){
        Swal.fire({
        title: 'Está seguro?',
        text: 'Está a punto de guardar la configuración de Facebook leads!',
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
            url:URL+"functions/crm/configuracionfacebook.php", 
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
                  title: 'Guardado!',
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
                )
              }
          });
          });
        }
      })
      }
  })
