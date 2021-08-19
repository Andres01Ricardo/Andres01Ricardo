


var aDatos=[];
var aDatosT=[];
var aDatosCC=[];
var tipoDetalle=3;


$(document).ready(function(e){

    $("#exampleModal").modal('show');


    // var overlay = document.getElementById("overlayImpuestos");
    // var popup   = document.getElementById("popupImpuestos");

   
    // overlay.classList.add('active');
    // popup.classList.add('active');
    // alert('ingreso');

if ($("#empresa").val()!=""){
  aDatos=[]; 
  var idEmpresa=$("#empresa").val();
  // alert(idEmpresa);
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

              naturaleza: element.naturaleza,

              // tercero:element.tercero,

              centroCosto:element.centroCosto,

            })

        })
        console.log(aDatos);
        autocomplete(); 


    }); 

aDatosT=[];
tipoDetalle=3;
  $.ajax({

      url:URL+"functions/terceros/cargarterceros.php", 

      type:"POST", 

      data: {"idEmpresa":idEmpresa}, 

      dataType: "json",

      }).done(function(msg){
      console.log(msg);


        msg.forEach(function(element,index){
         
          aDatosT.push({

              value: element.idTercero,

              label: element.nit+" - "+element.razonSocial,               

            })

        })
        console.log(aDatosT);
        // autocompleteT(); 
        autocompleteTS(); 


    });  


      aDatosCC=[];
        $.ajax({
          url:URL+"functions/centrocosto/cargarcentrocosto.php", 
          type:"POST", 
          data: {"idEmpresa":idEmpresa}, 
          dataType: "json",
          }).done(function(msg){
          console.log(msg);
            msg.forEach(function(element,index){
              aDatosCC.push({
                  label: element.codigoCentroCosto+" - "+element.centroCosto,
                })
            })
            console.log(aDatosCC);
            // autocompleteT(); 
            autocompleteCC(); 
        });

  }

});





$('[data-toggle="tooltip"]').tooltip();

// $("body").on("change","#empresa",function(e){
//   aDatos=[]; 
//   var idEmpresa=$(this).val();
//   $.ajax({

//       url:URL+"functions/cuentascontables/cargarcuentascontables.php", 

//       type:"POST", 

//       data: {"idEmpresa":idEmpresa}, 

//       dataType: "json",

//       }).done(function(msg){  

//         msg.forEach(function(element,index){

//           aDatos.push({

//               value: element.idCuentaContable,

//               label: element.codigoCuentaContable+" - "+element.nombre,

//               naturaleza: element.naturaleza,

//               // tercero:element.tercero,

//               centroCosto:element.centroCosto,

//             })

//         })
//         console.log(aDatos);
//         autocomplete(); 


//     }); 


// });




// autocomplete=function(){

//   $( ".cuentaContable" ).autocomplete({

//       minLength: 0,

//       source: aDatos,

//       focus: function( event, ui ) {

//         var index=$(this).index(".cuentaContable");

//         // $( ".cuentaContable" ).eq(index).val( ui.item.label );

//         // $( ".idCuentaContable" ).eq(index).val( ui.item.value );

//         // $( ".naturaleza" ).eq(index).val( ui.item.naturaleza );

       


//         return false;

//       },

//       select: function( event, ui ) {

//         var index=$(this).index(".cuentaContable");

//         $( ".cuentaContable" ).eq(index).val( ui.item.label );

//         // $( ".idCuentaContable" ).eq(index).val( ui.item.value );

//         // $( ".naturaleza" ).eq(index).val( ui.item.naturaleza );
//         // $( ".letreroCuentaContable" ).eq(index).addClass('ocultar');
//         // if (ui.item.tercero=='no') {
//         //   $( ".nit" ).eq(index).attr("disabled","true");
//         // }
        
//         var id=ui.item.value;
 
//         return false;

//       },

//       change: function(event, ui){

//         var index=$(this).index(".cuentaContable");

//         if(ui.item==null){

//           // $( ".idCuentaContable" ).eq(index).val('');
//           // $( ".letreroCuentaContable" ).eq(index).removeClass('ocultar');

//         }

//         return false;

//       }

//     })

// }








$("body").on("change","#empresa",function(e){
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

              naturaleza: element.naturaleza,

              // tercero:element.tercero,

              centroCosto:element.centroCosto,

            })

        })
        console.log(aDatos);
        autocomplete(); 
    }); 

// var idEmpresa=$("#idEmpresa").val();
aDatosT=[];
tipoDetalle=3;
  $.ajax({
      url:URL+"functions/terceros/cargarterceros.php", 
      type:"POST", 
      data: {"idEmpresa":idEmpresa,"tipoDetalle":tipoDetalle}, 
      dataType: "json",
      }).done(function(msg){
      console.log(msg);
        msg.forEach(function(element,index){
          aDatosT.push({
              value: element[0],
              label: element.nit+" - "+element.razonSocial,
            })
        })
        console.log(aDatosT);
        autocompleteTS(); 
    });  
        aDatosCC=[];
        $.ajax({
          url:URL+"functions/centrocosto/cargarcentrocosto.php", 
          type:"POST", 
          data: {"idEmpresa":idEmpresa}, 
          dataType: "json",
          }).done(function(msg){
          console.log(msg);
            msg.forEach(function(element,index){
              aDatosCC.push({
                  label: element.codigoCentroCosto+" - "+element.centroCosto,
                })
            })
            console.log(aDatosCC);
            autocompleteCC(); 
        });
});


autocomplete=function(){

  $( ".cuentaContable" ).autocomplete({
    appendTo:'#exampleModal',

      minLength: 0,
      source: aDatos,

      focus: function( event, ui ) {
        var index=$(this).index(".cuentaContable");

        return false;

      },
      select: function( event, ui ) {
        var index=$(this).index(".cuentaContable");
        $( ".cuentaContable" ).eq(index).val( ui.item.label );        
        var id=ui.item.value;
 
        return false;

      },

      change: function(event, ui){

        var index=$(this).index(".cuentaContable");

        if(ui.item==null){

          // $( ".idCuentaContable" ).eq(index).val('');
          // $( ".letreroCuentaContable" ).eq(index).removeClass('ocultar');

        }

        return false;

      }

    })

}






autocompleteTS=function(){
  $( ".terceros" ).autocomplete({
    appendTo:'#exampleModal',
      minLength: 0,
      source: aDatosT,
      focus: function( event, ui ) {
        var index=$(this).index(".terceros");
        // $( ".nit" ).eq(index).val( ui.item.label );
        // $( ".idTercero" ).eq(index).val( ui.item.value );
        // $( ".tipoTercero" ).eq(index).val( ui.item.tipo );
        return false;
      },
      select: function( event, ui ) {
        var index=$(this).index(".terceros");
        $( ".terceros" ).eq(index).val( ui.item.label );
        // $( ".idTercero" ).eq(index).val( ui.item.value );
        // $( ".tipoTercero" ).eq(index).val( ui.item.tipo );
        // $( ".letreroTercero" ).eq(index).addClass('ocultar');
        var id=ui.item.value;
        return false;
      },
      change: function(event, ui){
        var index=$(this).index(".terceros");
        if(ui.item==null){

          // $( ".idTercero" ).eq(index).val('');
          // $( ".letreroTercero" ).eq(index).removeClass('ocultar');
        }

        return false;

      }

    })

}



autocompleteCC=function(){
  $( ".centroCosto" ).autocomplete({
    appendTo:'#exampleModal',
      minLength: 0,
      source: aDatosCC,
      focus: function( event, ui ) {
        var index=$(this).index(".centroCosto");
        // $( ".nit" ).eq(index).val( ui.item.label );
        // $( ".idTercero" ).eq(index).val( ui.item.value );
        // $( ".tipoTercero" ).eq(index).val( ui.item.tipo );
        return false;
      },
      select: function( event, ui ) {
        var index=$(this).index(".centroCosto");
        $( ".centroCosto" ).eq(index).val( ui.item.label );
        // $( ".idTercero" ).eq(index).val( ui.item.value );
        // $( ".tipoTercero" ).eq(index).val( ui.item.tipo );
        // $( ".letreroTercero" ).eq(index).addClass('ocultar');
        var id=ui.item.value;
        return false;
      },
      change: function(event, ui){
        var index=$(this).index(".centroCosto");
        if(ui.item==null){

          // $( ".idTercero" ).eq(index).val('');
          // $( ".letreroTercero" ).eq(index).removeClass('ocultar');
        }

        return false;

      }

    })

}

