// $("body").on("change","[name='datos[grupo]']",function(e){

//     var id=$(this).val(); 

//     if(id!=""){

//         var tipo=$(this).find("option:selected").attr("tipo");

//         $("[name='datos[tipo]']").val(tipo); 

//         $.ajax({

//           url:URL+"functions/productosservicios/segmentos.php", 

//           type:"POST", 

//           data: {"idgrupo":id}, 

//           dataType: "json",

//           }).done(function(msg){  

//             var sHtml="<option value=''>Seleccione una opción</option>"; 

//             msg.segmentos.forEach(function(element,index){

//               sHtml+="<option value='"+element.idSegmento+"'>"+element.codigo+" - "+element.nombre+"</option>"; 

//             })



//             $("[name='datos[segmento]']").html(sHtml);

//         });

//     }else{

//       $("[name='datos[tipo]']").val(""); 

//       $("[name='datos[segmento]']").html("<option value=''>Seleccione una opción</option>");

//     }

    

// })



// $("body").on("change","[name='datos[segmento]']",function(e){

//     var id=$(this).val(); 

//     if(id!=""){

//         $.ajax({

//           url:URL+"functions/productosservicios/familias.php", 

//           type:"POST", 

//           data: {"idsegmento":id}, 

//           dataType: "json",

//           }).done(function(msg){  

//             var sHtml="<option value=''>Seleccione una opción</option>"; 

//             msg.familias.forEach(function(element,index){

//               sHtml+="<option value='"+element.idFamilia+"'>"+element.codigo+" - "+element.nombre+"</option>"; 

//             })



//             $("[name='datos[familia]']").html(sHtml);

//         });

//     }else{

//       $("[name='datos[familia]']").html("<option value=''>Seleccione una opción</option>");

//     }

    

// })



// $("body").on("change","[name='datos[familia]']",function(e){

//     var id=$(this).val(); 

//     if(id!=""){

//         $.ajax({

//           url:URL+"functions/productosservicios/clases.php", 

//           type:"POST", 

//           data: {"idfamilia":id}, 

//           dataType: "json",

//           }).done(function(msg){  

//             var sHtml="<option value=''>Seleccione una opción</option>"; 

//             msg.clases.forEach(function(element,index){

//               sHtml+="<option value='"+element.idClase+"'>"+element.codigo+" - "+element.nombre+"</option>"; 

//             })



//             $("[name='datos[clase]']").html(sHtml);

//         });

//     }else{

//       $("[name='datos[clase]']").html("<option value=''>Seleccione una opción</option>");

//     }

    

// })



// $("body").on("change","[name='datos[clase]']",function(e){

//     var id=$(this).val(); 

//     if(id!=""){

//         $.ajax({

//           url:URL+"functions/productosservicios/bienservicio.php", 

//           type:"POST", 

//           data: {"idclase":id,"tipo":$("[name='datos[tipo]']").val()}, 

//           dataType: "json",

//           }).done(function(msg){  

//             var sHtml="<option value=''>Seleccione una opción</option>"; 

//             msg.bienes.forEach(function(element,index){

//               var valor=element.idBienes; 

//               if($("[name='datos[tipo]']").val()==1){

//                 valor=element.idBienes; 

//               }

//               sHtml+="<option value='"+valor+"'>"+element.codigo+" - "+element.nombre+"</option>"; 

//             })



//             $("[name='datos[bien]']").html(sHtml);

//         });

//     }else{

//       $("[name='datos[bien]']").html("<option value=''>Seleccione una opción</option>");

//     }

    

// })
var aDatos=[]; 

$( document ).ready(function() {
    if ($("#idEmpresa").val()!= null) {
      aDatos=[]; 
      var idEmpresa=$("#idEmpresa").val();
      $.ajax({
          url:URL+"functions/cuentascontables/cargarcuentascontables.php", 
          type:"POST", 
          data: {"idEmpresa":idEmpresa}, 
          dataType: "json",
          }).done(function(msg){  
            msg.forEach(function(element,index){
              aDatos.push({
                  value: element.idCuentaContable,
                  label: element.codigoCuentaContable+" - "+element.nombre,
                  // naturaleza: element.naturaleza,
                  // tercero:element.tercero,
                  // centroCosto:element.centroCosto,
                  // detalle:element.detalle,
                  // porcentajeRetencion:element.porcentajeRetencion,
                })
            })
            autocomplete(); 
        });   


        $.ajax({
      url:URL+"functions/parametrosdocumentos/cargarparametros.php", 
      type:"POST", 
      data: {"idEmpresa":idEmpresa}, 
      dataType: "json",
      }).done(function(msg){  
          var sHtml="<option value=''>Seleccione una opción</option>"; 
        msg.forEach(function(element,index){

              var valor=element.idParametrosDocumentos; 

              sHtml+="<option value='"+valor+"'>"+element.letra+'-'+element.comprobante+"</option>";             

        })
            $("[name='datos[tipoDocumentoProductoCompra]']").html(sHtml);
            $("[name='datos[tipoDocumentoProductoVenta]']").html(sHtml);
        
    });   
    }
});


$("body").on("change","[name='datos[idEmpresa]']",function(e){
  aDatos=[]; 
  var idEmpresa=$(this).val();
  $.ajax({
      url:URL+"functions/cuentascontables/cargarcuentascontables.php", 
      type:"POST", 
      data: {"idEmpresa":idEmpresa}, 
      dataType: "json",
      }).done(function(msg){  
        msg.forEach(function(element,index){
          aDatos.push({
              value: element.idCuentaContable,
              label: element.codigoCuentaContable+" - "+element.nombre,
              // naturaleza: element.naturaleza,
              // tercero:element.tercero,
              // centroCosto:element.centroCosto,
              // detalle:element.detalle,
              // porcentajeRetencion:element.porcentajeRetencion,
            })
        })
        autocomplete(); 
    }); 





      $.ajax({
      url:URL+"functions/parametrosdocumentos/cargarparametros.php", 
      type:"POST", 
      data: {"idEmpresa":idEmpresa}, 
      dataType: "json",
      }).done(function(msg){  
          var sHtml="<option value=''>Seleccione una opción</option>"; 
        msg.forEach(function(element,index){

              var valor=element.idParametrosDocumentos; 

              sHtml+="<option value='"+valor+"'>"+element.letra+'-'+element.comprobante+"</option>";             

        })
            $("[name='datos[tipoDocumentoProductoCompra]']").html(sHtml);
            $("[name='datos[tipoDocumentoProductoVenta]']").html(sHtml);
        
    }); 





});




function verificar_id_cuenta_contable(){
    var cuenta=0;
    var estado=true;
    $('.cuentaContable').each(function() { 

        var cuentaContable=document.getElementById('item['+cuenta+'][cuentaContable]');
        var idCuentaContable=document.getElementById('item['+cuenta+'][idCuentaContable]');
        var letreroCuentaContable=document.getElementById('item['+cuenta+'][letreroCuentaContable]');

        if ($(this).val()=='') {
          
          letreroCuentaContable.classList.add("ocultar");
        }
        else{
          if (idCuentaContable == null) {
            letreroCuentaContable.classList.remove("ocultar");
            estado= false;  
          }else{
            letreroCuentaContable.classList.add("ocultar");   
          }
          // letreroCuentaContable.classList.add("ocultar");
          
        }


        cuenta++;
    });

 
    return estado;
  }

  // function verificar_id_tercero(){
  //   var cuenta=0;
  //   var estado=true;
  //   $('.idTercero').each(function() { 

  //       var cuentaContable=document.getElementById('item['+cuenta+'][nit]');
  //       var idCuentaContable=document.getElementById('item['+cuenta+'][idTercero]');
  //       var letreroCuentaContable=document.getElementById('item['+cuenta+'][letreroTercero]');

  //       if ($(this).val()=='') {
  //         letreroCuentaContable.classList.remove("ocultar");
  //         estado= false;
  //       }


  //       cuenta++;
  //   });
  //   return estado;
  // }




autocomplete=function(){

  $( ".cuentaContable" ).autocomplete({

      minLength: 0,

      source: aDatos,

      focus: function( event, ui ) {

        var index=$(this).index(".cuentaContable");

        // $( ".cuentaContable" ).eq(index).val( ui.item.label );

        // $( ".idCuentaContable" ).eq(index).val( ui.item.value );

        // $( ".naturaleza" ).eq(index).val( ui.item.naturaleza );

        


        return false;

      },

      select: function( event, ui ) {

        var index=$(this).index(".cuentaContable");

        $( ".cuentaContable" ).eq(index).val( ui.item.label );


        $( ".idCuentaContable" ).eq(index).val( ui.item.value );

        // $( ".naturaleza" ).eq(index).val( ui.item.naturaleza );

        // verificar_id_cuenta_contable();

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

$('input[type=radio][name="datos[inventario]"]').change(function() {
    var id=this.value;
    var idEmpresa=document.getElementById('datos[idEmpresa]').value;
    if (id == 1) {

        $.ajax({

          url:URL+"functions/inventario/consultarinventario.php", 

          type:"POST", 

          data: {"idEmpresa":idEmpresa}, 

          dataType: "json",

          }).done(function(msg){  

            var sHtml="<option value=''>Seleccione una opción</option>"; 

            msg.inventario.forEach(function(element,index){

              var valor=element.idProducto; 

             

              sHtml+="<option value='"+valor+"'>"+element.producto+"</option>"; 

            })



            $("[name='datos[idInventario]']").html(sHtml);

        });

    }
    else if (id == 2) {
        
        var sHtml="<option value=''>No inventario</option>";
        $("[name='datos[idInventario]']").html(sHtml);

       
    }
});



$("body").on("click touchstart","#btnGuardar",function(e){

    e.preventDefault();

      if(true === $("#frmGuardar").parsley().validate()){
        if (verificar_id_cuenta_contable()) {

        var texto="Servicio"; 

          if($("[name='datos[bienServicio]']").val()==1){

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

        })   
        }    

      }

  })