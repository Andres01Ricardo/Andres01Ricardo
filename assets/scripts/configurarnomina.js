var datos=[];





$( window ).on( "load", function() {
  var idEmpresa=$("#idEmpresaConfigurar").val();
  // alert('ingreso');
    $.ajax({
      url:URL+"functions/cuentascontables/cargarcuentascontables.php", 
      type:"POST", 
      data: {"idEmpresa":idEmpresa}, 
      dataType: "json",
      }).done(function(msg){  
        // var $aDatos=[];
        msg.forEach(function(element,index){
          datos.push({
              value: element.idCuentaContable,
              label: element.codigoCuentaContable+" - "+element.nombre,
              naturaleza: element.naturaleza,
            })
        })
        autocomplete(); 
      }); 
  })
autocomplete=function(){
  $( ".cuentaContable" ).autocomplete({
      minLength: 0,
      source: datos,
      focus: function( event, ui ) {
        var index=$(this).index(".cuentaContable");
        $( ".cuentaContable" ).eq(index).val( ui.item.label );
        $( ".idCuentaContable" ).eq(index).val( ui.item.value );
        $( ".naturaleza" ).eq(index).val( ui.item.naturaleza );
        return false;
      },
      select: function( event, ui ) {
        var index=$(this).index(".cuentaContable");
        $( ".cuentaContable" ).eq(index).val( ui.item.label );
        $( ".idCuentaContable" ).eq(index).val( ui.item.value );
        $( ".naturaleza" ).eq(index).val( ui.item.naturaleza );
        var id=ui.item.value;
        return false;
      },
      change: function(event, ui){
        var index=$(this).index(".cuentaContable");
        if(ui.item==null){
          $( ".idCuentaContable" ).eq(index).val('');
        }
        return false;
      }
    })
}


$("body").on("click touchstart","#btnGuardar",function(e){
    e.preventDefault();
    var idEmpresa=$("#idEmpresa").val();
      if(true === $("#frmGuardar").parsley().validate()){
        Swal.fire({
        title: '¿Está seguro?',
        text: 'Está a punto de agregar esta parametrización contable de la nómina!',
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
            url:URL+"functions/contable/guardarconfiguracionnomina.php", 
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
                  title: 'parametrización realizada!',
                  text: 'con exito',
                  closeOnConfirm: true,
                }
                ).then((result) => {
                 // window.history.back();
                  location.reload(); 
                })
              }else{
                 Swal.fire(
                  'El concepto de nómina ya se encuentra parametrizado!',
                  'Verifique en la lista',
                  'error'
                )
              }
            });
          });
        }
      })
      }
  });


$("body").on("click touchstart",".eliminar",function(e){
    e.preventDefault();
    var idEliminar=$(this).attr("value");
    // alert(idEliminar);
      // if(true === $("#frmGuardar").parsley().validate()){
         Swal.fire({
        title: '¿Está seguro?',
        text: 'Está a punto de eliminar esta parametrización contable de nómina!',
        icon: 'warning', 
        showCancelButton: true,
        showLoaderOnConfirm: true,
        confirmButtonText: `Si, Eliminar!`,
        cancelButtonText:'Cancelar',
        preConfirm: function(result) {
          return new Promise(function(resolve) {
            var formu = document.getElementById("frmGuardar");
            var data = new FormData(formu);
            $.ajax({
            url:URL+"functions/contable/eliminarconfiguracionnomina.php", 
            type:"POST", 
            data: {"idEliminar":idEliminar},
            dataType: "json",
            cache:false 
            }).done(function(msg){  
              if(msg.msg){
                Swal.fire(
                  {
                  icon: 'success',
                  title: 'parametrización eliminada!',
                  text: 'con exito',
                  closeOnConfirm: true,
                }
                ).then((result) => {
                 // window.history.back();
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
      // }
  });