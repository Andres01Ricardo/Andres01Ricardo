// var datos=[];





// $( window ).on( "load", function() {
//   var idEmpresa=$("#idEmpresaConfigurar").val();

//     $.ajax({
//       url:URL+"functions/cuentascontables/cargarcuentascontables.php", 
//       type:"POST", 
//       data: {"idEmpresa":idEmpresa}, 
//       dataType: "json",
//       }).done(function(msg){  
//         // var $aDatos=[];
//         console.log(msg);
//         if (msg.length==0) {
//           $(".cuentaContable").val('No hay cuentas contables creadas');
//           $(".cuentaContable").attr('disabled','disabled');

//         }
//         if (msg.length!=0) {
//           var sHtml='<option value="">Seleccione</option>';

//         msg.forEach(function(element,index){
//           sHtml+='<option value="'+element.idCuentaContable+'">'+element.codigoCuentaContable+' - '+element.nombre+'</option>';
//           datos.push({
//               value: element.idCuentaContable,
//               label: element.codigoCuentaContable+" - "+element.nombre,
              
//             })
//         })
//         $("#idCuentaInventario").html(sHtml);
//         $("#idCuentaCosto").html(sHtml);
//         $("#idCuentaVenta").html(sHtml);
//         $("#idCuentaDevolucion").html(sHtml);
//         // autocomplete(); 
//       }
//       }); 




//       $.ajax({
//         url:URL+"functions/inventario/cargarlineainventario.php", 
//         type:"POST", 
//         data: {"idEmpresa":idEmpresa}, 
//         dataType: "json",
//         }).done(function(msg){  
//           // var $aDatos=[];
//           console.log(msg);
//           if (msg.length==0) {
//             var sHtml='<option value="">No hay lineas creadas</option>';

//           }
//           if (msg.length!=0) {
//             var sHtml='<option value="">Seleccione</option>';

//             msg.forEach(function(element,index){
//               sHtml+='<option value="'+element.idLineaInventario+'">'+element.codigo+' - '+element.nombre+'</option>';
              
//             })
//             $("#idLineaInventario").html(sHtml);
            
//           // autocomplete(); 
//         }
//       }); 
//   })




$("body").on("click touchstart","#btnGuardar",function(e){
    e.preventDefault();
    var idEmpresa=$("#idEmpresaConfigurar").val();
      if(true === $("#frmGuardar").parsley().validate()){
         Swal.fire({
          title: '¿Está seguro?',
          text: 'Está a punto de editar este grupo!',
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
            url:URL+"functions/inventario/editargrupo.php", 
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
                  title: 'Grupo editado!',
                  text: 'con exito',
                  closeOnConfirm: true,
                }
                ).then((result) => {
                 window.history.back();
                  // location.reload(); 
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
  });


// $("body").on("click touchstart",".eliminarCuenta",function(e){
//     e.preventDefault();
//     var idEliminar=$(this).attr("value");
//     // alert(idEliminar);
//       // if(true === $("#frmGuardar").parsley().validate()){
//          Swal.fire({
//         title: '¿Está seguro?',
//         text: 'Está a punto de eliminar la parametrización contable de este centro de costo!',
//         icon: 'warning', 
//         showCancelButton: true,
//         showLoaderOnConfirm: true,
//         confirmButtonText: `Si, Eliminar!`,
//         cancelButtonText:'Cancelar',
//         preConfirm: function(result) {
//           return new Promise(function(resolve) {
//             var formu = document.getElementById("frmGuardar");
//             var data = new FormData(formu);
//             $.ajax({
//             url:URL+"functions/contable/eliminarcentrocosto.php", 
//             type:"POST", 
//             data: {"idEliminar":idEliminar},
//             dataType: "json",
//             cache:false 
//             }).done(function(msg){  
//               if(msg.msg){
//                 Swal.fire(
//                   {
//                     icon: 'success',
//                     title: 'parametrización eliminada!',
//                     text: 'con exito',
//                     closeOnConfirm: true,
//                   }
//                 ).then((result) => {
//                  // window.history.back();
//                   location.reload(); 
//                 })
//               }else{
//                  Swal.fire(
//                   'Algo ha salido mal!',
//                   'Verifique su conexión a internet',
//                   'error'
//                 )
//               }
//             });
//           });
//         }
//       })
//       // }
//   });