var datos=[];





$( window ).on( "load", function() {
  var idEmpresa=$("#idEmpresaConfigurar").val();

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
        msg.forEach(function(element,index){
          datos.push({
              value: element.idCuentaContable,
              label: element.codigoCuentaContable+" - "+element.nombre,
              // naturaleza: element.naturaleza,
            })
        })
        autocomplete(); 
      }
      }); 
  })



$("body").on("change","#idCentroCosto",function(e){
  var idCentroCosto=$(this).val();
  if (idCentroCosto=="") {
    $("#idSubcentroCosto").html("<option value=''>Seleccione una opción</option>");
  }
  if (idCentroCosto!="") {
    $.ajax({
      url:URL+"functions/centrocosto/cargarsubcentrocosto.php", 
      type:"POST", 
      data: {"idCentroCosto":idCentroCosto}, 
      dataType: "json",
      }).done(function(msg){  
        // var $aDatos=[];
        console.log(msg);
        var sHtml='<option value="">Seleccione una opción</option>';
        if (msg.length!=0) {
        msg.forEach(function(element,index){
          sHtml+="<option value='"+element.idSubcentroCosto+"'>"+element.codigoSubcentroCosto+" - "+element.subcentroCosto+"</option>";
        })
        $("#idSubcentroCosto").html(sHtml);
      }
      });
  }
})


autocomplete=function(){
  $( ".cuentaContable" ).autocomplete({
      minLength: 0,
      source: datos,
      focus: function( event, ui ) {
        var index=$(this).index(".cuentaContable");
        $( ".cuentaContable" ).eq(index).val( ui.item.label );
        $( ".idCuentaContable" ).eq(index).val( ui.item.value );
        // $( ".naturaleza" ).eq(index).val( ui.item.naturaleza );
        return false;
      },
      select: function( event, ui ) {
        var index=$(this).index(".cuentaContable");
        $( ".cuentaContable" ).eq(index).val( ui.item.label );
        $( ".idCuentaContable" ).eq(index).val( ui.item.value );
        // $( ".naturaleza" ).eq(index).val( ui.item.naturaleza );
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
    var idEmpresa=$("#idEmpresaConfigurar").val();

      if(true === $("#frmGuardar").parsley().validate()){

         Swal.fire({

          title: '¿Está seguro?',

          text: 'Está a punto de parametrizar este centro de costo!',

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

            url:URL+"functions/contable/guardarconfiguracioncontablecentrocosto.php", 

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


$("body").on("click touchstart",".eliminarCuenta",function(e){
    e.preventDefault();
    var idEliminar=$(this).attr("value");
    // alert(idEliminar);
      // if(true === $("#frmGuardar").parsley().validate()){
         Swal.fire({
        title: '¿Está seguro?',
        text: 'Está a punto de eliminar la parametrización contable de este centro de costo!',
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
            url:URL+"functions/contable/eliminarcentrocosto.php", 
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