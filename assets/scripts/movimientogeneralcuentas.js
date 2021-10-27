var aDatos=[]; 
// var aDatosC=[]; 
// var aDatosT=[]; 
 var debito=0;
$(document).ready(function(e){

    var overlay = document.getElementById("overlayImpuestos");
    var popup   = document.getElementById("popupImpuestos");

   
    overlay.classList.add('active');
    popup.classList.add('active');

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
              var sHtml='<option value="">Seleccione una opción</option>';
            msg.forEach(function(element,index){
              sHtml+="<option value='"+element.idCuentaContable+"'>"+element.codigoCuentaContable+" - "+element.nombre+"</option>";
              aDatos.push({
                  value: element.idCuentaContable,
                  label: element.codigoCuentaContable+" - "+element.nombre,
              
                })
            })
            console.log('select');
            console.log(sHtml);
            $("#cuentaPrimeraSelect").html(sHtml);
            console.log('input');
            console.log(aDatos);
            autocomplete(); 
        }); 
      }
});


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
        // var sHtml='<option value="">Seleccione una opción</option>';
        msg.forEach(function(element,index){
          // sHtml+="<option value='"+element.idCuentaContable+"'>"+element.codigoCuentaContable+" - "+element.nombre+"</option>";
          
          aDatos.push({

              value: element.idCuentaContable,
              label: element.codigoCuentaContable+" - "+element.nombre,

            })

        })
        // console.log('select');
        // console.log(sHtml);
        // $("#cuentaPrimeraSelect").html(sHtml);
        // console.log('input');
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


  $.ui.autocomplete.filter = function (array, term) {
        var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(term), "i");
        return $.grep(array, function (value) {
            return matcher.test(value.label || value.value || value);
        });
    };

}