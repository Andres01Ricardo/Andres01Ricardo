$("body").on("change","[name='datos[idDepartamentoResidencia]']",function(e){

    var id=$(this).val();

    if(id!=""){

      $.ajax({

        url:"functions/generales/ciudades.php", 

        type:"POST", 

        data: {"idDepartamento":id}, 

        dataType: "json",

        }).done(function(msg){  

          var sHtml="<option value=''>Seleccione una opción</option>"; 

          msg.ciudades.forEach(function(element,index){

            sHtml+="<option value='"+element.idCiudad+"'>"+element.nombre+"</option>"; 

          })



          $("[name='datos[idCiudadResidencia]']").html(sHtml);

      });

    } else{

      $("[name='datos[idCiudadResidencia]']").html("<option value=''>Seleccione una opción</option>");

    }

    

})



$("body").on("click touchstart","#btnGuardar",function(e){
    e.preventDefault();
      if(true === $("#frmGuardar").parsley().validate()){
          Swal.fire({
          title: 'Está seguro?',
          text: 'Está a punto de guardar un nuevo usuario!',
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
            url:URL+"functions/usuario/guardarusuario.php", 
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
                  title: "Usuario creado!",
                  text: 'con exito',
                  closeOnConfirm: true,
                }
                ).then((result) => {
                 if(msg.idUsuario==null){
                      location.href=URL+"listarusuarios";
                    }else{
                      location.href=URL+"asociarusuarios/"+msg.idUsuario;   
                    }
                })
              }else{
                 Swal.fire(
                  'Algo ha salido mal!',
                  'ya existe un registro con este numero de cedula',
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



$("body").on("change","[name='datos[idRol]']",function(e){

    var id=$(this).val();

    if(id==2){

      $("#ingresoEmpresa").removeClass("ocultar")

    } else{

      $("#ingresoEmpresa").addClass("ocultar")

    }

    

})