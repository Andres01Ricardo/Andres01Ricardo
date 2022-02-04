
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






// $("body").on("change","#concepto",function(e){
  
  
//    $.ajax({
//         url:URL+"functions/exogena/consultarformato.php", 
//         type:"POST", 
//         data: {"idConceptoExogena":$(this).val()}, 
//         dataType: "json",
//         }).done(function(msg){  
//           if (msg.msg) {

//             $("#formato").val(msg.formato.formato);
//             $("#idFormato").val(msg.formato.idFormatoExogena);
          
//             var sHtml="<option value=''> Seleccione</option>"; 
//             msg.categoria.forEach(function(element,index){
              
//               sHtml+="<option value='"+element.idCategoriaExogena+"'>"+element.descripcion+"</option>"; 
//             })
//             $("#categoria").html(sHtml);


//           }

          
//     }); 
// })

$("body").on("click touchstart","#btnGuardar",function(e){

    e.preventDefault();
    // var idEmpresa=$("#idEmpresa").val();

      if(true === $("#frmGuardar").parsley().validate()){
         Swal.fire({
          title: '¿Está seguro?',
          text: 'Está a punto de guardar los topes para la generación de las exogenas!',
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
              url:URL+"functions/exogena/guardartopes.php", 
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
                    title: 'Se guardaron correctamente los topes!',
                    text: 'con exito',
                    closeOnConfirm: true,
                  }
                  ).then((result) => {
                   // window.history.back();
                    location.reload(); 
                  })
                }else{
                   Swal.fire(
                    'Se modicaron los topes',
                    'correctamente',
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