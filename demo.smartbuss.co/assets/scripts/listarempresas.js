$(document).ready(function(e){
	dataTable("#tableEnterprise"); 
})

$("body").on("click",".ingresar",function(e){
	var id=$(this).attr("id"); 
	var texto=$(this).parents("tr").find("td").eq(3).html(); 
	Swal.fire({
          title: 'Está seguro?',
          text: 'Está a punto de ingresar al perfil de '+texto+'!',
          icon: 'warning', 
          showCancelButton: true,
          showLoaderOnConfirm: true,
          confirmButtonText: `Si, Ingresar!`,
          cancelButtonText:'Cancelar',
          preConfirm: function(result) {
          return new Promise(function(resolve) {
            
            var data = new FormData();
            data.append("id",id)
            $.ajax({
            url:URL+"functions/sesion/cambiarsesion.php", 
            type:"POST", 
            data: data,
            contentType:false, 
            processData:false, 
            dataType: "json",
            cache:false 
            }).done(function(msg){  
              if(msg.msg){
                 window.location.href="inicio"; 
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