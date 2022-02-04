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



$("body").on("change","[name='datos[nit]']",function(e){
    var id=$(this).val(); 

    var idEmpresa=$("#idEmpresa").val();
    if(id!=""){
      $.ajax({
        url:URL+"functions/terceros/consultarnit.php", 
        type:"POST", 
        data: {"nit":id,"idEmpresa":idEmpresa}, 
        dataType: "json",
        }).done(function(msg){  

          
            //evaluar si el tercero existe
          if (msg.tercero != null) {

            console.log(msg.tercero);
            console.log('no nulo');

            //llenar los datos del terceros en los input

            $("[name='datos[razonSocial]']").val(msg.tercero.razonSocial);

            if (msg.tercero.razonSocial!=0) {$("[name='datos[razonSocial]']").val(msg.tercero.razonSocial);}
            
            $("[name='datos[email]']").val(msg.tercero.email);
            $("[name='datos[telefono]']").val(msg.tercero.telefono);
            $("[name='datos[direccion]']").val(msg.tercero.direccion);
            $("[name='datos[periodoPago]']").val(msg.tercero.periodoPago);


            if (msg.tercero.responsableIva==1) {$("[name='datos[responsableIva]'] option:eq(1) ").prop('selected', true);}
            if (msg.tercero.responsableIva==2) {$("[name='datos[responsableIva]'] option:eq(2) ").prop('selected', true);}
            


            $("[name='datos[idDepartamento]'] option:eq("+msg.tercero.idDepartamento+")").prop('selected', true);

            var ciudadTercero=msg.tercero.idCiudad;
            // console.log(ciudadTercero);
            $.ajax({
              url:URL+"functions/generales/ciudades.php", 
              type:"POST", 
              data: {"idDepartamento":msg.tercero.idDepartamento}, 
              dataType: "json",
              }).done(function(msgC){  
                var sHtml="<option value=''>Seleccione una opción</option>"; 
                msgC.ciudades.forEach(function(element,index){
                    
                    // console.log(element.idCiudad);
                    // console.log('>>');
                    console.log(ciudadTercero);

                  if (element.idCiudad == ciudadTercero) {
                    sHtml+="<option value='"+element.idCiudad+"' selected>"+element.nombre+"</option>"; 
                  }
                  if (element.idCiudad != ciudadTercero) {

                    sHtml+="<option value='"+element.idCiudad+"'>"+element.nombre+"</option>"; 
                  }
                })

                $("[name='datos[idCiudad]']").html(sHtml);
            });

            //evaluar si el tercero existente esta asociado a esta empresa
            if (msg.terceroEmpresa.length>0) {

              Swal.fire(
                'El tercero ya existe',
                'asociado a la empresa',
                // 'danger'
              )

              // console.log(msg.terceroEmpresa);

            }
          }
            // sHtml+="<option value='"+element.idCiudad+"'>"+element.nombre+"</option>"; 
          // $("[name='datos[idCiudad]']").html(sHtml);
      });
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
    // var tipo = document.getElementById('datos[clasificacion]').value;
    // if (tipo==1) {
    //   var tipoGuardar ="functions/cliente/guardarcliente.php";

    // }
    // if (tipo==2) {
    //   var tipoGuardar ="functions/proveedor/guardarproveedor.php";

    // }
    // if (tipo==3) {
    //   var tipoGuardar ="functions/otro/guardarotro.php";

    // }

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