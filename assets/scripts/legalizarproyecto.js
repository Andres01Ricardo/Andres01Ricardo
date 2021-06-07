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


$("body").on("click","#btnRegresar",function(e){
  window.history.back();
})



$("body").on("click","#btnGuardar",function(e){

    e.preventDefault();

      if(true === $("#frmGuardar").parsley().validate()){

          Swal.fire({

          title: 'Está seguro?',

          text: 'Está a punto de guardar una legalizacion en el proyecto!',

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

            url:URL+"functions/legalizaciones/guardarlegalizacionalimentacion.php", 

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

                  title: "Legalizacion creada en el proyecto!",

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