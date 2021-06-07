var aDatos=[]; 
var aDatosC=[]; 
var aDatosT=[]; 
 var debito=0;
 var tabla = document.getElementById('tabla');
 tabla.style.display="none";


// $(document).ready(function(e){

// })


  // console.log(tipoDocumento);
  // console.log(comprobante);
$("body").on("change","[name='datos[comprobante]']",function(e){

    // var id=$(this).val(); 
    var idEmpresa=$("#idEmpresa").val();

      var tipoDocumento=$("#tipoDocumento").val();
      var comprobante=$(this).val();
    

      $.ajax({

        url:URL+"functions/comprobantes/cargarnumerocomprobante.php", 

        type:"POST", 

        data: {"tipoDocumento":tipoDocumento,"idEmpresa":idEmpresa,"comprobante":comprobante}, 


        dataType: "json",

        }).done(function(msg){  
          // console.log(msg.comprobanteNumero[0].numeracionActual);
          // var sHtml="<option value=''>Seleccione una opción</option>"; 

          // msg.comprobante.forEach(function(element,index){

          //   sHtml+="<option value='"+element.idParametrosDocumentos+"'>"+element.comprobante+' - '+element.descripcion+"</option>"; 

          // })

          // $("[name='datos[comprobante]']").html(sHtml);
          $("#numeroComprobante").val(msg.comprobanteNumero[0].numeracionActual).trigger('change');

      });



    

});
$("body").on("change","[name='datos[baseModal]']",function(e){

   var totalRetencion=(( $("#porcentajeRetencion").val() * parseFloat(eliminarMoneda($(this).val(),",",".")) ) / 100);
   $("#retencionModal").val(totalRetencion);

})
$("body").on("change","[name='datos[idEmpresa]']",function(e){


  

  aDatos=[]; 
  aDatosC=[]; 
  aDatosT=[]; 
  
  var idEmpresa=$(this).val();

  // debito=debito+parseInt(valorDebito);
  // alert(debito);
  //   valorDebito =eliminarMoneda(eliminarMoneda(valor,"$",""),",","")
  if (idEmpresa =="") {
    tabla.style.display="none";
  }
  if (idEmpresa !="") {
    tabla.style.display="block";
  }
  

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

              tercero:element.tercero,

              centroCosto:element.centroCosto,

              detalle:element.detalle,

              porcentajeRetencion:element.porcentajeRetencion,

            })

        })

        autocomplete(); 


    }); 

    $.ajax({

      url:URL+"functions/centrocosto/cargarcentrocosto.php", 

      type:"POST", 

      data: {"idEmpresa":idEmpresa}, 

      dataType: "json",

      }).done(function(msg){  

        msg.forEach(function(element,index){

          aDatosC.push({

              value: element.idCentroCosto,

              label: element.idCentroCosto+'-'+element.centroCosto,

            })

        })

        autocompleteC(); 


    });   


 

});


autocomplete=function(){

  $( ".cuentaContable" ).autocomplete({

      minLength: 0,

      source: aDatos,

      focus: function( event, ui ) {

        var index=$(this).index(".cuentaContable");

        // $( ".cuentaContable" ).eq(index).val( ui.item.label );

        $( ".idCuentaContable" ).eq(index).val( ui.item.value );

        $( ".naturaleza" ).eq(index).val( ui.item.naturaleza );

        if (ui.item.tercero=='2') {
          $( ".nit" ).eq(index).attr("disabled","true");
          $( ".nit" ).eq(index).removeAttr("required");
          
        }

        if (ui.item.centroCosto=='0' ) {
          $( ".centroCosto" ).eq(index).attr("disabled","true");
          $( ".centroCosto" ).eq(index).removeAttr("required");
          
        }
        if (ui.item.centroCosto==null) {
          $( ".centroCosto" ).eq(index).removeAttr("required");
        }
        if (ui.item.tercero=='1' || ui.item.tercero=='3') {
          $( ".nit" ).eq(index).removeAttr("disabled");
          $( ".nit" ).eq(index).attr("required","true");
        }

        if (ui.item.centroCosto=='1' ) {
          $( ".centroCosto" ).eq(index).removeAttr("disabled");
          $( ".centroCosto" ).eq(index).attr("required","true");
        }


        return false;

      },

      select: function( event, ui ) {

        var index=$(this).index(".cuentaContable");

        $( ".cuentaContable" ).eq(index).val( ui.item.label );

        $( ".idCuentaContable" ).eq(index).val( ui.item.value );

        $( ".naturaleza" ).eq(index).val( ui.item.naturaleza );
        $( ".letreroCuentaContable" ).eq(index).addClass('ocultar');
        if (ui.item.tercero=='2') {
          $( ".nit" ).eq(index).attr("disabled","true");
        }
        
        if (ui.item.centroCosto=='0') {
          $( ".centroCosto" ).eq(index).attr("disabled","true");
          $( ".centroCosto" ).eq(index).removeAttr("required");
        }

        if (ui.item.tercero=='1' || ui.item.tercero=='3') {
          $( ".nit" ).eq(index).removeAttr("disabled");
          $( ".nit" ).eq(index).attr("required","true");
        }

        if ( ui.item.tercero=='3') {
          $("#porcentajeRetencion").val(ui.item.porcentajeRetencion);
          $('#exampleModal').modal('show');  
          // $( ".base" ).eq(index).removeAttr("disabled");

        }

        

        if (ui.item.centroCosto=='1') {
          $( ".centroCosto" ).eq(index).removeAttr("disabled");
          $( ".centroCosto" ).eq(index).attr("required","required");
        }

        var id=ui.item.value;

        $("#index").val(index);

 //--------------------------------------------------------------------------------------------------------





 if (ui.item.detalle=='1') {
    var tipoDetalle=1;
 }
 if (ui.item.detalle=='2') {
    var tipoDetalle=2;
 }
 if (ui.item.detalle=='3') {
    var tipoDetalle=3;
 }
var idEmpresa=$("#idEmpresa").val();

aDatosT=[];

  $.ajax({

      url:URL+"functions/terceros/cargarterceros.php", 

      type:"POST", 

      data: {"idEmpresa":idEmpresa,"tipoDetalle":tipoDetalle}, 

      dataType: "json",

      }).done(function(msg){
      console.log(msg);


        msg.forEach(function(element,index){
          if (element.idCliente !=null) {
               var tipo='c'; 
              }
              if (element.idProveedor !=null) {
               var tipo='p';
              }
              if (element.idEmpleado !=null) {
               var tipo='e';
              }
          aDatosT.push({

              value: element[0],

              label: element.nit+" - "+element.razonSocial,

              tipo: tipo,
               

            })

        })

        autocompleteT(); 


    });  
      $( "#btnGuardarRetencion" ).click(function() {
        var indexG = $("#index").val();
        var totalR=$("#retencionModal").val();
        var baseM=$("#baseModal").val();
        if ($("#debito").is(':checked')) {
          $( ".debito" ).eq(indexG).val( totalR ).trigger('change');
          $( ".base" ).eq(indexG).val( baseM ).trigger('change');
          $( ".credito" ).eq(indexG).attr("disabled","disabled");
          // alert(baseM);
        }
        if ($("#credito").is(':checked')) {
          $( ".credito" ).eq(indexG).val( totalR ).trigger('change');
          $( ".base" ).eq(indexG).val( baseM ).trigger('change');
          // alert($( ".base" ).eq(indexG).val());
          $( ".debito" ).eq(indexG).attr("disabled","disabled");
          // alert(baseM);
        }
        sumar_columnas();
        $('#exampleModal').modal('hide'); 
        $("#frmRetencion")[0].reset();
      });








 //--------------------------------------------------------------------------------------------------------
        return false;

      },

      change: function(event, ui){

        var index=$(this).index(".cuentaContable");

        if(ui.item==null){

          $( ".idCuentaContable" ).eq(index).val('');
          $( ".letreroCuentaContable" ).eq(index).removeClass('ocultar');

        }

        return false;

      }

    })

}



autocompleteC=function(){

  $( ".centroCosto" ).autocomplete({

      minLength: 0,

      source: aDatosC,

      focus: function( event, ui ) {

        var index=$(this).index(".centroCosto");

        $( ".centroCosto" ).eq(index).val( ui.item.label );

        $( ".idCentroCosto" ).eq(index).val( ui.item.value );



        return false;

      },

      select: function( event, ui ) {

        var index=$(this).index(".centroCosto");

        $( ".centroCosto" ).eq(index).val( ui.item.label );

        $( ".idCentroCosto" ).eq(index).val( ui.item.value );
        
        var id=ui.item.value;
 
        return false;

      },

      change: function(event, ui){

        var index=$(this).index(".centroCosto");

        if(ui.item==null){

          $( ".idCentroCosto" ).eq(index).val('');

        }

        return false;

      }

    })

}






autocompleteT=function(){

  $( ".nit" ).autocomplete({

      minLength: 0,

      source: aDatosT,

      focus: function( event, ui ) {

        var index=$(this).index(".nit");

        // $( ".nit" ).eq(index).val( ui.item.label );

        $( ".idTercero" ).eq(index).val( ui.item.value );

        $( ".tipoTercero" ).eq(index).val( ui.item.tipo );



        return false;

      },

      select: function( event, ui ) {

        var index=$(this).index(".nit");

        $( ".nit" ).eq(index).val( ui.item.label );

        $( ".idTercero" ).eq(index).val( ui.item.value );

        $( ".tipoTercero" ).eq(index).val( ui.item.tipo );
        $( ".letreroTercero" ).eq(index).addClass('ocultar');
        
        var id=ui.item.value;
 
        return false;

      },

      change: function(event, ui){

        var index=$(this).index(".nit");

        if(ui.item==null){

          $( ".idTercero" ).eq(index).val('');
          $( ".letreroTercero" ).eq(index).removeClass('ocultar');

        }

        return false;

      }

    })

}

// totalDebito

// $("body").on("keyup",".total",function(e){
//   var valor=$(this).val();
//   
  

// })
$('.decimales').keyup(function () { 
    this.value = this.value.replace(/[^0-9\,]/g,'');


});

// $('.idCuentaContable').change(function(){
//   if (this.val()!='') {
//     var nomb=this.attr('name');
//     alert(nomb);
//   }
// })

// $("body").on("change",".idCuentaContable",function(e){
//   alert(this.attr(id));
// })

$("body").on("change","[name='datos[tipoDocumento]']",function(e){

    var id=$(this).val(); 
    var idEmpresa=$("#idEmpresa").val();


    if(id!=""){

      $.ajax({

        url:URL+"functions/comprobantes/parametrosdocumentos.php", 

        type:"POST", 

        data: {"idTipoDocumento":id,"idEmpresa":idEmpresa}, 

        dataType: "json",

        }).done(function(msg){  

          var sHtml="<option value=''>Seleccione una opción</option>"; 

          msg.comprobante.forEach(function(element,index){

            sHtml+="<option value='"+element.idParametrosDocumentos+"'>"+element.comprobante+' - '+element.descripcion+"</option>"; 

          })

          $("[name='datos[comprobante]']").html(sHtml);

      });

    }else{

      $("[name='datos[comprobante]']").html("<option value=''>Seleccione una opción</option>");

    }

    

});


$("#tableProductos").on("input", "input", function() {
  var input = $(this);
  // var columns = input.closest("tr").children();
  // var dc = columns.eq(7).text();
  // var calculated = input.val() * price;
  // columns.eq(5).text(calculated.toFixed(2));
  
  sumar_columnas();
  
  
});

function sumar_columnas(){
var sumDebito=0;
var sumCredito=0;
var cont=0;
var contC=0;
var restarDebito=0;

    //itera cada input de clase .subtotal y la suma
    $('.debito').each(function() { 
      // var naturaleza=document.getElementById("item["+cont+"][naturaleza]").value;
      var debito=document.getElementById("item["+cont+"][debito]");
      var credito=document.getElementById("item["+cont+"][credito]");
      var cuentaContable=document.getElementById("item["+cont+"][cuentaContable]");
      var valorDebito=(eliminarMoneda(eliminarMoneda(eliminarMoneda($(this).val(),"$",""),".",""),",","."));
      if (valorDebito=="" || valorDebito==null) {
        valorDebito=0;
        
      }
      if (debito.value !="" && credito.value =="") {
        credito.disabled=true;
      }
      if (debito.value =="" && credito.value !="") {
        debito.disabled=true;
      }
      if (debito.value =="" && credito.value =="") {
        credito.disabled=false;
        debito.disabled=false;
      }   
      
      // if (valorCuentaContable.substring(0,4)=='1592') {
      //   sumDebito -=parseFloat(valorDebito);
      // }
      
        sumDebito +=parseFloat(valorDebito);

         

            // if (naturaleza=="debito") {
              
            //   sumDebito +=parseFloat(valorDebito);
            // }
            // if (naturaleza=="credito") {
              
            //   sumCredito +=parseFloat(valorDebito);
            // }  
            cont++;                    
    }); 
      $('.credito').each(function() { 
      // var naturaleza=document.getElementById("item["+cont+"][naturaleza]");
      // var debito=document.getElementById("item["+cont+"][debito]");
      // var credito=document.getElementById("item["+cont+"][credito]");
      var valorCredito=(eliminarMoneda(eliminarMoneda(eliminarMoneda($(this).val(),"$",""),".",""),",","."));
      var cuentaContable=document.getElementById("item["+contC+"][cuentaContable]");
      if (valorCredito=="" || valorCredito==null) {
        valorCredito=0;
        
      } 
       
      var valorCuentaContable=cuentaContable.value;
      
      if (valorCuentaContable.substring(0,4)=='1592') {
        restarDebito +=parseFloat(valorCredito);
      }else{
        sumCredito +=parseFloat(valorCredito); 
      }
        contC++; 
    }); 
    //cambia valor del total y lo redondea a la segunda decimal
    var totalD=sumDebito-restarDebito;
    // var totalC=
    $('#totalDebito').val(totalD.toFixed(2));
    $('#totalCredito').val(sumCredito.toFixed(2));
    var diferencia=totalD - sumCredito;
    $('#totalDiferencia').val(diferencia.toFixed(2));

}
// $(document).ready(function(e){

// })

  function verificar_id_cuenta_contable(){
    var cuenta=0;
    var estado=true;
    $('.idCuentaContable').each(function() { 

        var cuentaContable=document.getElementById('item['+cuenta+'][cuentaContable]');
        var idCuentaContable=document.getElementById('item['+cuenta+'][idCuentaContable]');
        var letreroCuentaContable=document.getElementById('item['+cuenta+'][letreroCuentaContable]');

        if ($(this).val()=='') {
          letreroCuentaContable.classList.remove("ocultar");
          estado= false;
        }


        cuenta++;
    });
    return estado;
  }

  function verificar_id_tercero(){
    var cuenta=0;
    var estado=true;
    $('.idTercero').each(function() { 

        var cuentaContable=document.getElementById('item['+cuenta+'][nit]');
        var idCuentaContable=document.getElementById('item['+cuenta+'][idTercero]');
        var letreroCuentaContable=document.getElementById('item['+cuenta+'][letreroTercero]');

        if ($(this).val()=='') {
          letreroCuentaContable.classList.remove("ocultar");
          estado= false;
        }


        cuenta++;
    });
    return estado;
  }
  

$("body").on("click","#agregar",function(e){



  $('select.flexselect').removeData("flexselect");

  var sHtml=$("#tableProductos tbody tr:first").html(); 

  var cant=$("#tableProductos tbody tr").length; 
  if (cant>=249) {
    $(this).hide();
    // alert('mas 10');
  }

  $("#tableProductos tbody").append("<tr>"+sHtml+"</tr>"); 

  $("#tableProductos tbody tr:last").find("td").eq(0).html(cant+1);

  $("#tableProductos tbody tr:last").find(".cuentaContable").attr("id","item["+cant+"][cuentaContable]").attr("name","item["+cant+"][cuentaContable]").val("");

  $("#tableProductos tbody tr:last").find(".idCuentaContable").attr("id","item["+cant+"][idCuentaContable]").attr("name","item["+cant+"][idCuentaContable]").val("");
  $("#tableProductos tbody tr:last").find(".letreroCuentaContable").attr("id","item["+cant+"][letreroCuentaContable]").addClass('ocultar').val("");

  $("#tableProductos tbody tr:last").find(".centroCosto").attr("id","item["+cant+"][centroCosto]").attr("name","item["+cant+"][centroCosto]").val(""); 
  $("#tableProductos tbody tr:last").find(".idCentroCosto").attr("id","item["+cant+"][idCentroCosto]").attr("name","item["+cant+"][idCentroCosto]").val(""); 

  // $("#tableProductos tbody tr:last").find(".subcentroCosto").attr("id","item["+cant+"][subcentroCosto]").attr("name","item["+cant+"][subcentroCosto]").val(""); 

  $("#tableProductos tbody tr:last").find(".nit").attr("id","item["+cant+"][nit]").attr("name","item["+cant+"][nit]").val(""); 
  $("#tableProductos tbody tr:last").find(".idTercero").attr("id","item["+cant+"][idTercero]").attr("name","item["+cant+"][idTercero]").val(""); 
  $("#tableProductos tbody tr:last").find(".letreroTercero").attr("id","item["+cant+"][letreroTercero]").addClass('ocultar').val("");
  $("#tableProductos tbody tr:last").find(".tipoTercero").attr("id","item["+cant+"][tipoTercero]").attr("name","item["+cant+"][tipoTercero]").val(""); 

  // $("#tableProductos tbody tr:last").find(".sucursal").attr("id","item["+cant+"][sucursal]").attr("name","item["+cant+"][sucursal]").val(''); 

  $("#tableProductos tbody tr:last").find(".descripcion").attr("id","item["+cant+"][descripcion]").attr("name","item["+cant+"][descripcion]").val(""); 
  $("#tableProductos tbody tr:last").find(".base").attr("id","item["+cant+"][base]").attr("name","item["+cant+"][base]").val(""); 

  $("#tableProductos tbody tr:last").find(".naturaleza").attr("id","item["+cant+"][naturaleza]").attr("name","item["+cant+"][naturaleza]").val(''); 

  $("#tableProductos tbody tr:last").find(".debito").removeAttr("disabled").attr("id","item["+cant+"][debito]").attr("name","item["+cant+"][debito]").val('');
  $("#tableProductos tbody tr:last").find(".credito").removeAttr("disabled").attr("id","item["+cant+"][credito]").attr("name","item["+cant+"][credito]").val('');

  autocomplete(); 
  autocompleteC();
  autocompleteT();

})





$("body").on("click",".eliminar",function(e){



  var cant=$("#tableProductos tbody tr").length; 

  if(cant>1){

    $('select.flexselect').removeData("flexselect");

    $(this).parents("tr").remove(); 

    $("#tableProductos tbody tr").each(function(index,element){

      $(element).find("td").eq(0).html(index+1); 

    })

    

    autocomplete(); 
    sumar_columnas();

  }
  if (cant<=250) {
    $("#agregar").show();
    // alert('menos 10');
  }

  

})







$("body").on("click","#btnGuardar",function(e){

    e.preventDefault();
    var diferencia= document.getElementById('totalDiferencia');
    var diferenciaTotal=eliminarMoneda(eliminarMoneda(diferencia.value,"$",""),",","");  
    if (diferenciaTotal!=0) {
      Swal.fire(

                  'Algo ha salido mal!',

                  'debitos y creditos no coinciden',

                  'error'

                )
      
      diferencia.style.color='red';
    }else{
      if (verificar_id_cuenta_contable()) {
        if (verificar_id_tercero()) {

          if(true === $("#frmGuardar").parsley().validate()){

             Swal.fire({

            title: '¿Está seguro?',

            text: 'Está a punto de contabilizar el comprobante!',

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

                url:URL+"functions/comprobantes/guardarcomprobante.php", 

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

                      title: 'comprobante contabilizado!',

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

          } //aca
        }else{
          Swal.fire(

          'Verifique los terceros',

          'deben quedar seleccionados de la lista desplegable',

          'error'

        )
        }
      }else{
        Swal.fire(

          'Verifique las cuentas contables',

          'deben quedar seleccionadas de la lista desplegable',

          'error'

        )
      }
    }
  });




