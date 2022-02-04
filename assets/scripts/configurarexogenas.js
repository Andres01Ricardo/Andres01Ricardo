
$( window ).on( "load", function() {
  // var idEmpresa=$("#idEmpresaConfigurar").val();
  // // alert('ingreso');
  //   $.ajax({
  //     url:URL+"functions/cuentascontables/cargarcuentascontables.php", 
  //     type:"POST", 
  //     data: {"idEmpresa":idEmpresa}, 
  //     dataType: "json",
  //     }).done(function(msg){  
  //       // var $aDatos=[];
  //       msg.forEach(function(element,index){
          
  //       })
  //     }); 
  })


// autocomplete=function(){
//   $( ".cuentaContable" ).autocomplete({
//       minLength: 0,
//       source: datos,
//       focus: function( event, ui ) {
//         var index=$(this).index(".cuentaContable");
//         $( ".cuentaContable" ).eq(index).val( ui.item.label );
//         $( ".idCuentaContable" ).eq(index).val( ui.item.value );
//         $( ".naturaleza" ).eq(index).val( ui.item.naturaleza );
//         return false;
//       },
//       select: function( event, ui ) {
//         var index=$(this).index(".cuentaContable");
//         $( ".cuentaContable" ).eq(index).val( ui.item.label );
//         $( ".idCuentaContable" ).eq(index).val( ui.item.value );
//         $( ".naturaleza" ).eq(index).val( ui.item.naturaleza );
//         var id=ui.item.value;
//         return false;
//       },
//       change: function(event, ui){
//         var index=$(this).index(".cuentaContable");
//         if(ui.item==null){
//           $( ".idCuentaContable" ).eq(index).val('');
//         }
//         return false;
//       }
//     })
// }



$("body").on("change","#concepto",function(e){
  var idConcepto=$(this).val();
  // if (idConcepto==) {

     $.ajax({
          url:URL+"functions/exogena/consultarformato.php", 
          type:"POST", 
          data: {"idConceptoExogena":idConcepto}, 
          dataType: "json",
          }).done(function(msg){  
            if (msg.msg) {

              $("#formato").val(msg.formato.formato);
              $("#idFormato").val(msg.formato.idFormatoExogena);
            
              if (msg.categoria==0) {
                var sHtml="<option value='0'>  </option>"; 
                $("#categoriaOculta").removeClass('ocultar');
                $("#categoria").prop('readonly', 'readonly');
                // $(".select2").css("display","none");
              }else{
                var sHtml="<option value='0'> Seleccione</option>"; 
                msg.categoria.forEach(function(element,index){
                  
                  sHtml+="<option value='"+element.idCategoriaExogena+"'>"+element.descripcion+"</option>"; 
                })
              }
                $("#categoria").html(sHtml);


            }
        
      }); 

  // }
})

$("body").on("click touchstart","#btnGuardar",function(e){

    e.preventDefault();
    // var idEmpresa=$("#idEmpresa").val();

      if(true === $("#frmGuardar").parsley().validate()){
         Swal.fire({
          title: '¿Está seguro?',
          text: 'Está a punto de guardar esta configuracion para la exogena!',
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
              url:URL+"functions/exogena/guardarconfiguracionexogena.php", 
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
                    title: 'configuracion guardada!',
                    text: 'con exito',
                    closeOnConfirm: true,
                  }
                  ).then((result) => {
                   // window.history.back();
                    location.reload(); 
                  })
                }else{
                   Swal.fire(
                    'Se modifico la configuracion de la cuenta contable!',
                    'Correctamente para el presente año gravable',
                    'success'
                  ).then((result) => {
                   // window.history.back();
                    location.reload(); 
                  })
                }
              });
            });
          }
        })
      }
  });




$("body").on("click touchstart",".eliminar",function(e){

    e.preventDefault();

      var idEliminar=$(this).attr('value');
// alert(idEliminar);
        Swal.fire({
        title: '¿Está seguro?',
        text: 'Está a punto de eliminar esta configuración de la exogena!',
        icon: 'warning', 
        showCancelButton: true,
        showLoaderOnConfirm: true,
        confirmButtonText: `Si, Eliminar!`,
        cancelButtonText:'Cancelar',
        preConfirm: function(result) {
          return new Promise(function(resolve) {
            // var formu = document.getElementById("frmEliminar");
            // var data = new FormData(formu);
            $.ajax({
            url:URL+"functions/exogena/eliminarconfiguracionexogena.php", 
            type:"POST", 
            data:  {"idEliminar":idEliminar},
            dataType: "json"
            }).done(function(msg){  
              if(msg.msg){
                Swal.fire(
                 {icon: 'success',
                  title: 'Configuracion exogena eliminada!',
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
  })