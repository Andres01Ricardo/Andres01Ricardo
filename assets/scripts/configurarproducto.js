var datos=[];
var aDatos=[];





$( window ).on( "load", function() {
  var table = $('#tableProductos').DataTable({
      orderCellsTop: true,
       fixedHeader: true,
    });

    //Creamos una fila en el head de la tabla y lo clonamos para cada columna
    $('#tableProductos thead tr').clone(true).appendTo( '#tableProductos thead' );

    $('#tableProductos thead tr:eq(1) th').each( function (i) {
        var title = $(this).text(); //es el nombre de la columna
        $(this).html( '<input type="text"  class="form-control" style="heigth:25%;" />' );
 
        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );

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
        console.log(datos);
        autocomplete(); 
      }); 
      var tipo=3;
      $.ajax({
      // url:URL+"functions/productosservicios/cargarcuentascontables.php", 
      
      url:URL+"functions/productosservicios/listarproductosservicios.php", 
      type:"POST", 
      data: {"tipo":tipo,"idEmpresa":idEmpresa}, 
      dataType: "json",
      }).done(function(msg){  
        aDatos=[];
        msg.forEach(function(element,index){
          aDatos.push({
              value: element.idProductoServicio,
              label: element.codigo+" - "+element.nombre,
            })
        })
        console.log(aDatos);
        autocompleteP(); 
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

autocompleteP=function(){
  $( ".producto" ).autocomplete({
      minLength: 0,
      source: aDatos,
      focus: function( event, ui ) {
        var index=$(this).index(".producto")
        $( ".producto" ).eq(index).val( ui.item.label );
        $( ".idProducto" ).eq(index).val( ui.item.value );
        return false;
      },
      select: function( event, ui ) {
        var index=$(this).index(".producto")
        $( ".producto" ).eq(index).val( ui.item.label );
        $( ".idProducto" ).eq(index).val( ui.item.value );
        return false;
      },
      change: function(event, ui){
        var index=$(this).index(".producto")
        if(ui.item==null){
          $( ".idProducto" ).eq(index).val('');
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

        text: 'Está a punto de agregar realizar la parametrización contable de esta empresa!',

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

            url:URL+"functions/contable/guardarconfiguracionproducto.php", 

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



$("body").on("click touchstart",".eliminarImpuesto",function(e){
    e.preventDefault();
    var idEliminar=$(this).attr("value");
    // alert(idEliminar);
      // if(true === $("#frmGuardar").parsley().validate()){
         Swal.fire({
        title: '¿Está seguro?',
        text: 'Está a punto de eliminar la parametrización contable de este producto!',
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
            url:URL+"functions/contable/eliminarproducto.php", 
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