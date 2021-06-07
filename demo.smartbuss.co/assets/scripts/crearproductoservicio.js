$("body").on("change","[name='datos[grupo]']",function(e){
    var id=$(this).val(); 
    if(id!=""){
        var tipo=$(this).find("option:selected").attr("tipo");
        $("[name='datos[tipo]']").val(tipo); 
        $.ajax({
          url:URL+"functions/productosservicios/segmentos.php", 
          type:"POST", 
          data: {"idgrupo":id}, 
          dataType: "json",
          }).done(function(msg){  
            var sHtml="<option value=''>Seleccione una opción</option>"; 
            msg.segmentos.forEach(function(element,index){
              sHtml+="<option value='"+element.idSegmento+"'>"+element.codigo+" - "+element.nombre+"</option>"; 
            })

            $("[name='datos[segmento]']").html(sHtml);
        });
    }else{
      $("[name='datos[tipo]']").val(""); 
      $("[name='datos[segmento]']").html("<option value=''>Seleccione una opción</option>");
    }
    
})

$("body").on("change","[name='datos[segmento]']",function(e){
    var id=$(this).val(); 
    if(id!=""){
        $.ajax({
          url:URL+"functions/productosservicios/familias.php", 
          type:"POST", 
          data: {"idsegmento":id}, 
          dataType: "json",
          }).done(function(msg){  
            var sHtml="<option value=''>Seleccione una opción</option>"; 
            msg.familias.forEach(function(element,index){
              sHtml+="<option value='"+element.idFamilia+"'>"+element.codigo+" - "+element.nombre+"</option>"; 
            })

            $("[name='datos[familia]']").html(sHtml);
        });
    }else{
      $("[name='datos[familia]']").html("<option value=''>Seleccione una opción</option>");
    }
    
})

$("body").on("change","[name='datos[familia]']",function(e){
    var id=$(this).val(); 
    if(id!=""){
        $.ajax({
          url:URL+"functions/productosservicios/clases.php", 
          type:"POST", 
          data: {"idfamilia":id}, 
          dataType: "json",
          }).done(function(msg){  
            var sHtml="<option value=''>Seleccione una opción</option>"; 
            msg.clases.forEach(function(element,index){
              sHtml+="<option value='"+element.idClase+"'>"+element.codigo+" - "+element.nombre+"</option>"; 
            })

            $("[name='datos[clase]']").html(sHtml);
        });
    }else{
      $("[name='datos[clase]']").html("<option value=''>Seleccione una opción</option>");
    }
    
})

$("body").on("change","[name='datos[clase]']",function(e){
    var id=$(this).val(); 
    if(id!=""){
        $.ajax({
          url:URL+"functions/productosservicios/bienservicio.php", 
          type:"POST", 
          data: {"idclase":id,"tipo":$("[name='datos[tipo]']").val()}, 
          dataType: "json",
          }).done(function(msg){  
            var sHtml="<option value=''>Seleccione una opción</option>"; 
            msg.bienes.forEach(function(element,index){
              var valor=element.idServicio; 
              if($("[name='datos[tipo]']").val()==1){
                valor=element.idBienes; 
              }
              sHtml+="<option value='"+valor+"'>"+element.codigo+" - "+element.nombre+"</option>"; 
            })

            $("[name='datos[bien]']").html(sHtml);
        });
    }else{
      $("[name='datos[bien]']").html("<option value=''>Seleccione una opción</option>");
    }
    
})

$("body").on("click","#btnGuardar",function(e){
    e.preventDefault();
      if(true === $("#frmGuardar").parsley().validate()){
        var texto="Servicio"; 
          if($("[name='datos[tipo]']").val()==1){
            var texto="Producto"; 
          }

          Swal.fire({
          title: 'Está seguro?',
          text: 'Está a punto de guardar un nuevo '+texto+'!',
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
            url:URL+"functions/productosservicios/guardarproductoservicio.php", 
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
                  title: texto+" creado!",
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
          //   var formu = document.getElementById("frmGuardar");
        
          //   var data = new FormData(formu);
          //   $.ajax({
          //   url:URL+"functions/productosservicios/guardarproductoservicio.php", 
          //   type:"POST", 
          //   data: data,
          //   contentType:false, 
          //   processData:false, 
          //   dataType: "json",
          //   cache:false 
          //   }).done(function(msg){  
          //     if(msg.msg){
          //       Swal.fire(
          //         {
          //         icon: 'success',
          //         title: texto+" creado!",
          //         text: 'con exito',
          //         closeOnConfirm: true,
          //       }
          //       ).then((result) => {
          //        location.reload(); 
          //       })
          //     }else{
          //        Swal.fire(
          //         'Algo ha salido mal!',
          //         'Verifique su conexión a internet',
          //         'error'
          //       ).then((result) => {
                  
          //       })
          //     }
            
          // });
          } 

         })


          
          // swal({
          //   title: 'Está seguro?',
          //   text: 'Está a punto de guardar un nuevo '+texto+'!',
          //   icon: 'warning',
          //   buttons: {
          //       confirm : {text:'Si, Guardar!',className:'sweet-warning',closeModal:false},
          //       cancel : 'Cancelar' 
          //   },
          //   dangerMode: true,
          // })
          //   .then((willDelete) => {
          //     if (willDelete) {
          //       var formu = document.getElementById("frmGuardar");
            
          //       var data = new FormData(formu);
          //       $.ajax({
          //       url:URL+"functions/productosservicios/guardarproductoservicio.php", 
          //       type:"POST", 
          //       data: data,
          //       contentType:false, 
          //       processData:false, 
          //       dataType: "json",
          //       cache:false 
          //       }).done(function(msg){  
          //         if(msg.msg){

          //           swal({   
          //             title: texto+" creado!",   
          //             text: "con exito",
          //             type: "success",        
          //             closeOnConfirm: true 
          //             }).then((element)=>{
          //               location.reload(); 
          //             })
          //         }else{
          //           swal({   
          //             title: "Algo ha salido mal!",   
          //             text: "Revise su conexión a internet",
          //             type: "error",        
          //             closeOnConfirm: true 
          //             }).then((element)=>{
                        
          //             });
          //         }
                
          //     });
          //     } else {
                
          //     }
          //   });
            
       
      }
  })