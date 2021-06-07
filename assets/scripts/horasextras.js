$("body").on("click touchstart","#btnGuardar",function(e){

    e.preventDefault();

      if(true === $("#frmGuardar").parsley().validate()){

            var formu = document.getElementById("frmGuardar");

            

            var data = new FormData(formu);

            $.ajax({

            url:URL+"functions/configuracion/guardarhorasextras.php", 

            type:"POST", 

            data: data,

            contentType:false, 

            processData:false, 

            dataType: "json",

            cache:false 

            }).done(function(msg){  

              if(!msg.error){

                if(msg.msg){

                  Swal.fire(

                    icon: 'success',

                    title: 'Gestión realizada!',

                    text: 'con exito',

                    closeOnConfirm: true,

                  ).then((result) => {

                    $("#limpiar").trigger("click"); 

                        var sHtml=""; 

                        msg.lista.forEach(function(element,index){

                           sHtml+="<tr>"+

                           "<td>"+(index+1)+"</td>"+

                           "<td>"+element.anio+"</td>"+

                           "<td>"+element.diurna+"%</td>"+

                           "<td>"+element.nocturna+"%</td>"+

                           "<td>"+element.diurnaDominical+"%</td>"+

                           "<td>"+element.nocturnaDominical+"%</td>"+

                          "</tr>"; 

                        })

                        $("#tableImpuestos tbody").html(sHtml);

                  })



                  }else{

                    Swal.fire(

                      'Algo ha salido mal!',

                      'Verifique su conexión a internet',

                      'error'

                    ).then((result) => {

                      

                    })

                  }

              }else{

                location.href=msg.msg; 

              }

            

          });

       

      }

  })



$("body").on("click touchstart","#limpiar",function(e){

  $("#frmGuardar")[0].reset();

})