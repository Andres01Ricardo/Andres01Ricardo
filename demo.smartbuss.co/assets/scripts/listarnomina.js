$(document).ready(function(e){
	dataTable("#tableNomina"); 
})

$("body").on("click",".finalizar",function(e){
	var id=$(this).attr("id");
	var periodo=$(this).parents("tr").find("td").eq(2).html();
	var empresa=$(this).parents("tr").find("td").eq(5).html();

	$("[name='datos[idNomina]']").val(id); 
	$("#titulo").html(periodo+" / "+empresa)
})

$("body").on("click","#btnGuardar",function(e){
    e.preventDefault();
      if(true === $("#frmFinalizar").parsley().validate()){
        Swal.fire({
          title: 'Está seguro?',
          text: 'Está a punto de finalizar la realización de esta nomina!',
          icon: 'warning', 
          showCancelButton: true,
          showLoaderOnConfirm: true,
          confirmButtonText: `Si, Continuar!`,
          cancelButtonText:'Cancelar',
          preConfirm: function(result) {
          return new Promise(function(resolve) {
            var formu = document.getElementById("frmFinalizar");
        
            var data = new FormData(formu);
            $.ajax({
            url:URL+"functions/nomina/finalizarnomina.php", 
            type:"POST", 
            data: data,
            contentType:false, 
            processData:false, 
            dataType: "json",
            cache:false 
            }).done(function(msg){  
              if(msg.msg){
                Swal.fire({
                  icon: 'success',
                  title: "Nomina finalizada!",
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
        }).then((result) => {
          if (result.isConfirmed) {

          } 

         })
 
       
      }
  })