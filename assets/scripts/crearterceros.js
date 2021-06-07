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



$("body").on("change","[name='datos[tipoPersona]']",function(e){

  if($(this).val()==1){

    $("[name='datos[digitoVerificador]']").attr("readonly","readonly");

    $("[name='datos[digitoVerificador]']").removeAttr("required");

  }else{

    $("[name='datos[digitoVerificador]']").attr("required",true);

    $("[name='datos[digitoVerificador]']").removeAttr("readonly");

  }

})



$("body").on("click touchstart","#btnGuardar",function(e){

    e.preventDefault();
    var tipo = document.getElementById('datos[clasificacion]').value;
    if (tipo==1) {
      var tipoGuardar ="functions/cliente/guardarcliente.php";

    }
    if (tipo==2) {
      var tipoGuardar ="functions/proveedor/guardarproveedor.php";

    }
    if (tipo==3) {
      var tipoGuardar ="functions/otro/guardarotro.php";

    }

      if(true === $("#frmGuardar").parsley().validate()){

          Swal.fire({

          title: 'Está seguro?',

          text: 'Está a punto de crear un tercero!',

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

            // url:URL+tipoGuardar, 
            url:URL+"functions/terceros/guardartercero.php", 

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

                  title: "Tercero creado!",

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