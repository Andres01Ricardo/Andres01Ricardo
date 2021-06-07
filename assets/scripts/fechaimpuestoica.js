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



$("body").on("click touchstart","#btnGuardar",function(e){

    e.preventDefault();

      if(true === $("#frmGuardar").parsley().validate()){

        e.preventDefault();

        Swal.fire({

          title: 'Está seguro?',

          text: 'Está a punto de guardar una nueva fecha de pago ICA!',

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

                url:URL+"functions/calendarioimpuesto/guardarfechaimpuesto.php", 

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

                      title: 'Fecha Registrada!',

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



$("body").on("change","[name='datos[tipoConfiguracion]']",function(e){

    var id=$(this).val(); 

    if(id==1){

      $("#fechaUnica").removeClass("ocultar")

      $(".ultimoDigito").addClass("ocultar")

      $("[name='datos[fechaPago]']").attr("required","required")

      $(".digito").removeAttr("required")

    }else if(id==2){

      $("#fechaUnica").addClass("ocultar")

      $(".ultimoDigito").removeClass("ocultar")

      $("[name='datos[fechaPago]']").removeAttr("required")

      $(".digito").attr("required","required")

    }else{

      $("#fechaUnica").addClass("ocultar")

      $(".ultimoDigito").addClass("ocultar")

      $(".digito").removeAttr("required")

      $("[name='datos[fechaPago]']").removeAttr("required")

    }

    

})

