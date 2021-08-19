var aDatos=[]; 
var aDatosc=[]; 
var aDatoss=[];

$(document).ready(function(e){
  $("#divPorcentajeRetencion").css("display","none");

  if ($("#porcentajeRetencion").val()!="") {
    $("#divPorcentajeRetencion").css("display","block");
  }
  idEmpresa=0;

	$.ajax({

	    url:URL+"functions/cuentascontables/cargargrupos.php", 

	    type:"POST", 

	    data: {"idEmpresa":idEmpresa}, 

	    dataType: "json",

	    }).done(function(msg){  

	      msg.forEach(function(element,index){

	      	aDatos.push({

			        value: element.idGrupo,

			        label: element.codigo+" - "+element.denominacion,

			      })

	      })

	      autocomplete(); 

	  });  


    

         $.ajax({

        url:URL+"functions/cuentascontables/cargarcuentas.php", 

        type:"POST", 

        data: {"id":$("#idGrupo").val()}, 

        dataType: "json",

        }).done(function(msg){  

        msg.forEach(function(element,index){

          aDatosc.push({

              value: element.idCuenta,

              label: element.codigo+" - "+element.denominacion,

            })

        })

        autocompletec(); 

    });

    $.ajax({

        url:URL+"functions/cuentascontables/cargarsubcuentas.php", 

        type:"POST", 

        data: {"id":$("#idCuenta").val()}, 

        dataType: "json",

        }).done(function(msg){  

        msg.forEach(function(element,index){

          aDatoss.push({

              value: element.idSubcuenta,

              label: element.codigo+" - "+element.denominacion,

            })

        })

        autocompletes(); 

    });   

});

$("body").on("click touchstart","#btnGuardar",function(e){

    e.preventDefault();

      if(true === $("#frmGuardar").parsley().validate()){

         Swal.fire({

        title: '¿Está seguro?',

        text: 'Está a punto de editar esta cuenta contable!',

        icon: 'warning', 

        showCancelButton: true,

        showLoaderOnConfirm: true,

        confirmButtonText: `Si, Editar!`,

        cancelButtonText:'Cancelar',

        preConfirm: function(result) {

          return new Promise(function(resolve) {

            var formu = document.getElementById("frmGuardar");
            
            var data = new FormData(formu);

            $.ajax({

            url:URL+"functions/cuentascontables/editarcuentacontable.php", 

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

                  title: 'Cuenta contable editada!',

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

                )

              }
            });

          });

        }

      })

      }

  });

$(".grupo").on( 'change', function() {
     
  autocomplete();
})


autocomplete=function(){

  $( ".grupo" ).autocomplete({

      minLength: 0,

      source: aDatos,

      focus: function( event, ui ) {

        var index=$(this).index(".grupo");

        $( ".grupo" ).eq(index).val( ui.item.label );

        $( ".idGrupo" ).eq(index).val( ui.item.value );

        

        return false;

      },

      select: function( event, ui ) {

        var index=$(this).index(".grupo");

        $( ".grupo" ).eq(index).val( ui.item.label );

        $( ".idGrupo" ).eq(index).val( ui.item.value );
        
        var id=ui.item.value;
        aDatosc=[];
        aDatoss=[];

         $.ajax({

        url:URL+"functions/cuentascontables/cargarcuentas.php", 

        type:"POST", 

        data: {"id":id}, 

        dataType: "json",

        }).done(function(msg){  

        msg.forEach(function(element,index){

          aDatosc.push({

              value: element.idCuenta,

              label: element.codigo+" - "+element.denominacion,

            })

        })

        autocompletec(); 

    }); 



        return false;

      },

      change: function(event, ui){

        var index=$(this).index(".grupo");

        if(ui.item==null){

          $( ".idGrupo" ).eq(index).val('');

        }

        return false;

      }

    })

}




autocompletec=function(){

  $( ".cuenta" ).autocomplete({

      minLength: 0,

      source: aDatosc,

      focus: function( event, ui ) {

        var index=$(this).index(".cuenta");

        $( ".cuenta" ).eq(index).val( ui.item.label );

        $( ".idCuenta" ).eq(index).val( ui.item.value );

        

        return false;

      },

      select: function( event, ui ) {

        var index=$(this).index(".cuenta");

        $( ".cuenta" ).eq(index).val( ui.item.label );

        $( ".idCuenta" ).eq(index).val( ui.item.value );

        var ids=ui.item.value;

        $.ajax({

        url:URL+"functions/cuentascontables/cargarsubcuentas.php", 

        type:"POST", 

        data: {"id":ids}, 

        dataType: "json",

        }).done(function(msg){  

        msg.forEach(function(element,index){

          aDatoss.push({

              value: element.idSubcuenta,

              label: element.codigo+" - "+element.denominacion,

            })

        })

        autocompletes(); 

    }); 


        return false;

      },

      change: function(event, ui){

        var index=$(this).index(".cuenta");

        if(ui.item==null){

          $( ".idCuenta" ).eq(index).val('');

        }

        return false;

      }

    })

}


autocompletes=function(){

  $( ".subcuenta" ).autocomplete({

      minLength: 0,

      source: aDatoss,

      focus: function( event, ui ) {

        var index=$(this).index(".subcuenta");

        $( ".subcuenta" ).eq(index).val( ui.item.label );

        $( ".idSubcuenta" ).eq(index).val( ui.item.value );

        

        return false;

      },

      select: function( event, ui ) {

        var index=$(this).index(".subcuenta");

        $( ".subcuenta" ).eq(index).val( ui.item.label );

        $( ".idSubcuenta" ).eq(index).val( ui.item.value );

        return false;

      },

      change: function(event, ui){

        var index=$(this).index(".subcuenta");

        if(ui.item==null){

          $( ".idSubcuenta" ).eq(index).val('');

        }

        return false;

      }

    })
}





$("#checkauxiliar").on( 'change', function() {
    if( $(this).is(':checked') ) {
        $( "#idAuxiliar" ).removeAttr("readonly","readonly");
        $("#idAuxiliar").removeAttr('disabled');
        $( "#auxiliar" ).removeAttr("readonly","readonly");
        $("#auxiliar").removeAttr('disabled');
        $("#checksubauxiliar").removeAttr('disabled');
        
        $( "#idAuxiliar" ).attr("required","required");
        $( "#auxiliar" ).attr("required","required");
    } else {
        $( "#idAuxiliar" ).attr("readonly","readonly");
        $("#idAuxiliar").attr('disabled','disabled');
        $( "#auxiliar" ).attr("readonly","readonly");
        $("#auxiliar").attr('disabled','disabled');
        $("#checksubauxiliar").attr('disabled','disabled');

        $( "#idAuxiliar" ).removeAttr("required","required");
        $( "#auxiliar" ).removeAttr("required","required");
    }
});

$("#checksubauxiliar").on( 'change', function() {
    if( $(this).is(':checked') ) {
        $( "#idSubauxiliar" ).removeAttr("readonly","readonly");
        $("#idSubauxiliar").removeAttr('disabled');
        $( "#subauxiliar" ).removeAttr("readonly","readonly");
        $("#subauxiliar").removeAttr('disabled');

        $( "#idSubauxiliar" ).attr("required","required");
        $( "#subauxiliar" ).attr("required","required");
    } else {
        $( "#idSubauxiliar" ).attr("readonly","readonly");
        $("#idSubauxiliar").attr('disabled','disabled');
        $( "#subauxiliar" ).attr("readonly","readonly");
        $("#subauxiliar").attr('disabled','disabled');

        $( "#idSubauxiliar" ).removeAttr("required","required");
        $( "#subauxiliar" ).removeAttr("required","required");
    }
});
$("#checksubcuenta").on( 'change', function() {
    if( $(this).is(':checked') ) {
        $( "#descripcionSubcuenta" ).removeAttr("readonly","readonly");
        $("#descripcionSubcuenta").removeAttr('disabled');
        // $( "#subauxiliar" ).removeAttr("readonly","readonly");
        // $("#subauxiliar").removeAttr('disabled');

        // $( "#idSubauxiliar" ).attr("required","required");
        // $( "#subauxiliar" ).attr("required","required");
    } else {
        $( "#descripcionSubcuenta" ).attr("readonly","readonly");
        $("#descripcionSubcuenta").attr('disabled','disabled');
        // $( "#subauxiliar" ).attr("readonly","readonly");
        // $("#subauxiliar").attr('disabled','disabled');

        // $( "#idSubauxiliar" ).removeAttr("required","required");
        // $( "#subauxiliar" ).removeAttr("required","required");
    }
});







$("#tercero").on( 'change', function() {
    if ($(this).val()=='3') {
      $("#divPorcentajeRetencion").css("display","block");
      $("#divPorcentajeRetencion").attr("required","required");
    }else{
      $("#divPorcentajeRetencion").css("display","none");
      $("#divPorcentajeRetencion").removeAttr("required");
    }
});



$('.decimales').keyup(function () { 
    this.value = this.value.replace(/[^0-9\,]/g,'');


});




$('[data-toggle="tooltip"]').tooltip();