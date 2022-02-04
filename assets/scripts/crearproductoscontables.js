// $( document ).ready(function() {

// });
$( window ).on( "load", function() {
  var idEmpresa=$("#idEmpresa").val();
  // alert(idEmpresa);
    $.ajax({
      url:URL+"functions/cuentascontables/cargarcuentascontables.php", 
      type:"POST", 
      data: {"idEmpresa":idEmpresa}, 
      dataType: "json",
      }).done(function(msg){  
        // var $aDatos=[];
        console.log(msg);
        if (msg.length==0) {
          $(".cuentaContable").val('No hay cuentas contables creadas');
          $(".cuentaContable").attr('disabled','disabled');

        }
        if (msg.length!=0) {
          var sHtml='<option value="">Seleccione</option>';

        msg.forEach(function(element,index){
          sHtml+='<option value="'+element.idCuentaContable+'">'+element.codigoCuentaContable+' - '+element.nombre+'</option>';
          
        })
        // $("#idCuentaInventario").html(sHtml);
        $("#idCuentaCosto").html(sHtml);
        $("#idCuentaVenta").html(sHtml);
        // $("#idCuentaDevolucion").html(sHtml);
        // autocomplete(); 
      }
      }); 


      // $.ajax({
      //   url:URL+"functions/inventario/cargarlineainventario.php", 
      //   type:"POST", 
      //   data: {"idEmpresa":idEmpresa}, 
      //   dataType: "json",
      //   }).done(function(msg){  
      //     // var $aDatos=[];
      //     console.log(msg);
      //     if (msg.length==0) {
      //       var sHtml='<option value="">No hay lineas creadas</option>';

      //     }
      //     if (msg.length!=0) {
      //       var sHtml='<option value="">Seleccione</option>';

      //       msg.forEach(function(element,index){
      //         sHtml+='<option value="'+element.idLineaInventario+'">'+element.codigo+' - '+element.nombre+'</option>';
              
      //       })
      //       $("#idLineaInventario").html(sHtml);
            
      //     // autocomplete(); 
      //   }
      // }); 
  })

$("body").on("click touchstart","#btnGuardar",function(e){
    e.preventDefault();
      if(true === $("#frmGuardar").parsley().validate()){
          Swal.fire({
          title: '¿Está seguro?',
          text: 'Está a punto de crear un nuevo producto',
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
            url:URL+"functions/inventario/guardarproductocontable.php", 
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
                    title: "Producto creado!",
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
        })   
      }

  })


$("body").on("click","#btnAgregarCat",function(e){
  $("#modalCat").modal('show');
})


$("body").on("click touchstart","#btnGuardarCategoria",function(e){
    e.preventDefault();
      if(true === $("#frmGuardarCategoria").parsley().validate()){
        Swal.fire({
        title: '¿Está seguro?',
        text: 'Está a punto de agregar este nuevo grupo de inventario!',
        icon: 'warning', 
        showCancelButton: true,
        showLoaderOnConfirm: true,
        confirmButtonText: `Si, Guardar!`,
        cancelButtonText:'Cancelar',
        preConfirm: function(result) {
          return new Promise(function(resolve) {
            var formu = document.getElementById("frmGuardarCategoria");
            var data = new FormData(formu);
            $.ajax({
            url:URL+"functions/inventario/guardargrupoinventario.php", 
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
                    title: 'Grupo de inventario agregado!',
                    text: 'con exito',
                    closeOnConfirm: true,
                  }
                ).then((result) => {
                 var idEmpresa = $("[name='datos[idEmpresa]'").val();
                  console.log(idEmpresa);
                  $.ajax({
                    url:URL+"functions/inventario/cargargrupoinventario.php", 
                    type:"POST", 
                    data: {"idEmpresa":idEmpresa}, 
                    dataType: "json",
                    }).done(function(msg){  
                      var  sHtmlC="<option value=''>Seleccione</option>"; 
                      msg.forEach(function(element,index){
                        sHtmlC+="<option value='"+element.idGrupoInventario+"'>"+element.nombre+"</option>"; 
                      })
                      $("#grupo").html(sHtmlC);
                      $("#modalCat").modal('hide');
                  });
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


// $("#categoria").keypress(function(e) { 
//   var code = (e.keyCode ? e.keyCode : e.which); if(code == 13){ 

//     return false; 
//   } 
// });

$('[data-toggle="tooltip"]').tooltip();