$(document).ready(function(e){

    var overlay = document.getElementById("overlayImpuestos");
    var popup   = document.getElementById("popupImpuestos");

   
    overlay.classList.add('active');
    popup.classList.add('active');

    // document.getElementById('divTercero').style.visibility= "hidden";
    // document.getElementById('divCuenta').style.visibility= "hidden";
    // document.getElementById('divTipoTercero').style.visibility= "hidden";
});

var aDatos=[]; 
// var aDatosC=[]; 
// var aDatosT=[]; 
 var debito=0;
 // var tabla = document.getElementById('tabla');
 // tabla.style.display="none";


// $(document).ready(function(e){

// })


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


});




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

        // $( ".idCuentaContable" ).eq(index).val( ui.item.value );

        // $( ".naturaleza" ).eq(index).val( ui.item.naturaleza );
        // $( ".letreroCuentaContable" ).eq(index).addClass('ocultar');
        // if (ui.item.tercero=='no') {
        //   $( ".nit" ).eq(index).attr("disabled","true");
        // }
        
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