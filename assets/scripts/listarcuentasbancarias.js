$("body").on("click touchstart",".cargarextracto",function(e){

	var id=$(this).attr("id"); 

  // alert(id);
	// var nombre=$(this).parents("tr").find("td").eq(2).html()

	// var empresa=$(this).parents("tr").find("td").eq(5).html()

	$("[name='datos[idCuenta]']").val(id); 

	// $("#titulo").html(nombre+" - "+empresa); 

})



$("body").on("click touchstart","#btnGuardar",function(e){

    

  e.preventDefault();

  if(true === $("#frmGuardar").parsley().validate()){

    Swal.fire({

      title: 'Está seguro?',

      text: 'Está a punto de guardar este extracto bancario a esta cuenta!',

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

            url:URL+"functions/cuentabancaria/guardarextracto.php", 

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

                  title: 'Cambios realizados!',

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