var aDatos=[]; 
var aDatosi=[];

$(document).ready(function(e){
  var idEmpresa = document.getElementById('datos[idEmpresa]').value;
  
	$.ajax({

	    url:URL+"functions/inventario/cargarproductos.php", 

	    type:"POST", 

	    data: {"idEmpresa":idEmpresa}, 

	    dataType: "json",

	    }).done(function(msg){  

	      msg.forEach(function(element,index){

	      	aDatos.push({

			        value: element.idProducto,

			        label: element.producto,

              unidad: element.unidad,

              idUnidad:element.idUnidad,

              valorUnitario:element.valorUnitario,

			      })

	      })

	      autocomplete(); 

	  });  


      $.ajax({

      url:URL+"functions/inventario/cargarinsumos.php", 

      type:"POST", 

      data: {"idEmpresa":idEmpresa}, 

      dataType: "json",

      }).done(function(msg){  

        msg.forEach(function(element,index){

          aDatosi.push({

              value: element.idProducto,

              label: element.producto,

              unidad: element.unidad,

              idUnidad:element.idUnidad,

              valorUnitario:element.valorUnitario,

              cantidadMinima:element.cantidadMinima,

            })

        })

        autocompletei(); 

    });




})

autocomplete=function(){



  $( ".producto" ).autocomplete({

      minLength: 0,

      source: aDatos,

      focus: function( event, ui ) {

        var index=$(this).index(".producto")

        $( ".producto" ).eq(index).val( ui.item.label );

        $( ".idProducto" ).eq(index).val( ui.item.value );

        // var sHtml="<option value='"+ui.item.idUnidad+"'>"+ui.item.unidad+"</option>";

        // $(".idUnidad").eq(index).html(sHtml);

        // $( ".valorUnitario" ).eq(index).val( ui.item.valorUnitario );

        // $( ".valorUnitario" ).attr("readonly","readonly");
        // $( ".valorUnitario" ).addClass("readOnly");

        return false;

      },

      select: function( event, ui ) {

        var index=$(this).index(".producto")

        $( ".producto" ).eq(index).val( ui.item.label );

        $( ".idProducto" ).eq(index).val( ui.item.value );


        // var sHtml="<option value='"+ui.item.idUnidad+"'>"+ui.item.unidad+"</option>";
        // $(".idUnidad").eq(index).html(sHtml);

        // $( ".valorUnitario" ).eq(index).val( ui.item.valorUnitario );

        // $( ".valorUnitario" ).attr("readonly","readonly");
        // $( ".valorUnitario" ).addClass("readOnly");

        return false;

      },

      change: function(event, ui){

        var index=$(this).index(".producto")

        // $( ".valorUnitario" ).removeAttr("readonly","readonly");
        // $( ".valorUnitario" ).removeClass("readOnly");

        if(ui.item==null){

          $( ".idProducto" ).eq(index).val('');

          // $( ".valorUnitario" ).eq(index).val('');

        //   $.ajax({

        //   url:URL+"functions/inventario/consultarunidad.php", 

        //   type:"POST", 

        //   data: {"idEmpresa":$("[name='datos[idEmpresa]']").val()}, 

        //   dataType: "json",

        //   }).done(function(msg){  

        //     var sHtml="<option value=''>"+'Seleccione'+"</option>"; 

        //     msg.unidad.forEach(function(element,index){

        //       sHtml+="<option value='"+element.idUnidad+"'>"+element.nombre+"</option>"; 

        //     });

        //     $(".idUnidad").eq(index).html(sHtml);

        // });

        }

        return false;

      }

    })

}




autocompletei=function(){



  $( ".productoInsumo" ).autocomplete({

      minLength: 0,

      source: aDatosi,

      focus: function( event, ui ) {

        var index=$(this).index(".productoInsumo");

        $( ".productoInsumo" ).eq(index).val( ui.item.label );

        $( ".idProductoInsumo" ).eq(index).val( ui.item.value );

        // var sHtml="<option value='"+ui.item.idUnidad+"'>"+ui.item.unidad+"</option>";

        // $(".idUnidad").eq(index).html(sHtml);

        // $( ".valorUnitario" ).eq(index).val( ui.item.valorUnitario );

        // $( ".valorUnitario" ).attr("readonly","readonly");
        // $( ".valorUnitario" ).addClass("readOnly");

        $(".unidadInsumo").eq(index).val(ui.item.unidad);

        $(".valorUnitarioInsumo").eq(index).val(ui.item.valorUnitario);

        return false;

      },

      select: function( event, ui ) {

        var index=$(this).index(".productoInsumo");

        $( ".productoInsumo" ).eq(index).val( ui.item.label );

        $( ".idProductoInsumo" ).eq(index).val( ui.item.value );


        // var sHtml="<option value='"+ui.item.idUnidad+"'>"+ui.item.unidad+"</option>";
        // $(".idUnidad").eq(index).html(sHtml);

        // $( ".valorUnitario" ).eq(index).val( ui.item.valorUnitario );

        // $( ".valorUnitario" ).attr("readonly","readonly");
        // $( ".valorUnitario" ).addClass("readOnly");

        $(".unidadInsumo").eq(index).val(ui.item.unidad);

        $(".valorUnitarioInsumo").eq(index).val(ui.item.valorUnitario);

        return false;

      },

      change: function(event, ui){

        var index=$(this).index(".productoInsumo");

        $( ".valorUnitarioInsumo" ).removeAttr("readonly","readonly");
        $( ".valorUnitarioInsumo" ).removeClass("readOnly");

        if(ui.item==null){

          $( ".idProductoInsumo" ).eq(index).val('');

          $( ".valorUnitarioInsumo" ).eq(index).val('');

          $.ajax({

          url:URL+"functions/inventario/consultarunidad.php", 

          type:"POST", 

          data: {"idEmpresa":$("[name='datos[idEmpresa]']").val()}, 

          dataType: "json",

          }).done(function(msg){  

            var sHtml="<option value=''>"+'Seleccione'+"</option>"; 

            msg.unidad.forEach(function(element,index){

              sHtml+="<option value=''>"+"Seleccione"+"</option>"; 

            });

            $(".idUnidadInsumo").eq(index).html(sHtml);

        });

        }

        return false;

      }

    })

}



$("body").on("keyup",".cantidadInsumo, .valorUnitarioInsumo",function(e){

  var cantidad=$(this).parents("tr").find(".cantidadInsumo").val(); 

  if($(this).parents("tr").find(".valorUnitarioInsumo").val()!=""){var valorUnitario=eliminarMoneda(eliminarMoneda($(this).parents("tr").find(".valorUnitarioInsumo").val(),"$",""),",",""); }else{ var valorUnitario=0}

  total=parseInt(cantidad)*parseFloat(valorUnitario); 

  $(this).parents("tr").find(".totalInsumo").val(total).trigger("change");

  totalizar2(); 

})


totalizar2=function(){

  var valor=0; 

  var total=0; 

  $(".totalInsumo").each(function(index,element){

    if($(element).val()!=""){valor=parseFloat(eliminarMoneda(eliminarMoneda($(element).val(),"$",""),",","")); }else{ valor=0; }

    total+=valor;

  })

}

// $("body").on("keyup",".cantidad, .valorUnitario",function(e){

//   var cantidad=$(this).parents("tr").find(".cantidad").val(); 

//   if($(this).parents("tr").find(".valorUnitario").val()!=""){var valorUnitario=eliminarMoneda(eliminarMoneda($(this).parents("tr").find(".valorUnitario").val(),"$",""),",",""); }else{ var valorUnitario=0}

//   total=parseInt(cantidad)*parseFloat(valorUnitario); 

//   $(this).parents("tr").find(".total").val(total).trigger("change");

//   totalizar(); 

// })



totalizar=function(){

  var valor=0; 

  var total=0; 

  $(".total").each(function(index,element){

    if($(element).val()!=""){valor=parseFloat(eliminarMoneda(eliminarMoneda($(element).val(),"$",""),",","")); }else{ valor=0; }

    total+=valor

  })

}


$("body").on("click touchstart","#agregar",function(e){

  $('select.flexselect').removeData("flexselect");

  var sHtml=$("#tableProductos tbody tr:first").html(); 

  var cant=$("#tableProductos tbody tr").length; 

  $("#tableProductos tbody").append("<tr>"+sHtml+"</tr>"); 

  

  $("#tableProductos tbody tr:last").find("td").eq(0).html(cant+1); 



  $("#tableProductos tbody tr:last").find(".producto").attr("id","item["+cant+"][producto]").attr("name","item["+cant+"][producto]").val("");

  $("#tableProductos tbody tr:last").find(".idProducto").attr("id","item["+cant+"][idProducto]").attr("name","item["+cant+"][idProducto]").val("");

  
  $("#tableProductos tbody tr:last").find(".cantidad").attr("id","item["+cant+"][cantidad]").attr("name","item["+cant+"][cantidad]").val(""); 

  $("#tableProductos tbody tr:last").find(".idUnidad").attr("id","item["+cant+"][idUnidad]").attr("name","item["+cant+"][idUnidad]").val(""); 

  $("#tableProductos tbody tr:last").find(".valorUnitario").attr("id","item["+cant+"][valorUnitario]").attr("name","item["+cant+"][valorUnitario]").val(''); 


  $("#tableProductos tbody tr:last").find(".total").attr("id","item["+cant+"][total]").attr("name","item["+cant+"][total]").val('');

  autocomplete(); 

})

$("body").on("click touchstart",".eliminar",function(e){



  var cant=$("#tableProductos tbody tr").length; 

  if(cant>1){

    $('select.flexselect').removeData("flexselect");

    $(this).parents("tr").remove(); 

    $("#tableProductos tbody tr").each(function(index,element){

      $(element).find("td").eq(0).html(index+1); 



      $(element).find(".producto").attr("id","item["+index+"][producto]").attr("name","item["+index+"][producto]").val("");

      $(element).find(".idProducto").attr("id","item["+index+"][idProducto]").attr("name","item["+index+"][idProducto]").val("");

      $(element).find(".cantidad").attr("id","item["+index+"][cantidad]").attr("name","item["+index+"][cantidad]").val(""); 

      $(element).find(".idUnidad").attr("id","item["+index+"][idUnidad]").attr("name","item["+index+"][idUnidad]").val(""); 

      $(element).find(".valorUnitario").attr("id","item["+index+"][valorUnitario]").attr("name","item["+index+"][valorUnitario]").val(''); 

      $(element).find(".total").attr("id","item["+index+"][total]").attr("name","item["+index+"][total]").val('');

    })

    autocomplete(); 

  }

});


$("body").on("click touchstart","#agregarInsumos",function(e){

  $('select.flexselect').removeData("flexselect");

  var sHtml=$("#tableInsumos tbody tr:first").html(); 

  var cant=$("#tableInsumos tbody tr").length; 

  $("#tableInsumos tbody").append("<tr>"+sHtml+"</tr>"); 

  

  $("#tableInsumos tbody tr:last").find("td").eq(0).html(cant+1); 



  $("#tableInsumos tbody tr:last").find(".productoInsumo").attr("id","itemR["+cant+"][productoInsumo]").attr("name","itemR["+cant+"][productoInsumo]").val("");

  $("#tableInsumos tbody tr:last").find(".idProductoInsumo").attr("id","itemR["+cant+"][idProductoInsumo]").attr("name","itemR["+cant+"][idProductoInsumo]").val("");

  
  $("#tableInsumos tbody tr:last").find(".cantidadInsumo").attr("id","itemR["+cant+"][cantidadInsumo]").attr("name","itemR["+cant+"][cantidadInsumo]").val(""); 

  $("#tableInsumos tbody tr:last").find(".idUnidadInsumo").attr("id","itemR["+cant+"][idUnidadInsumo]").attr("name","itemR["+cant+"][idUnidadInsumo]").val(""); 

  $("#tableInsumos tbody tr:last").find(".valorUnitarioInsumo").attr("id","itemR["+cant+"][valorUnitarioInsumo]").attr("name","itemR["+cant+"][valorUnitarioInsumo]").val(''); 


  $("#tableInsumos tbody tr:last").find(".totalInsumo").attr("id","itemR["+cant+"][totalInsumo]").attr("name","itemR["+cant+"][totalInsumo]").val('');

  autocompletei(); 

})

$("body").on("click touchstart",".eliminarInsumos",function(e){



  var canti=$("#tableInsumos tbody tr").length; 

  if(canti>1){

    $('select.flexselect').removeData("flexselect");

    $(this).parents("tr").remove(); 

    $("#tableInsumos tbody tr").each(function(index,element){

      $(element).find("td").eq(0).html(index+1); 



      // $(element).find(".productoInsumo").attr("id","item["+index+"][productoInsumo]").attr("name","item["+index+"][productoInsumo]").val("");

      // $(element).find(".idProductoInsumo").attr("id","item["+index+"][idProductoInsumo]").attr("name","item["+index+"][idProductoInsumo]").val("");

      // $(element).find(".cantidadInsumo").attr("id","item["+index+"][cantidadInsumo]").attr("name","item["+index+"][cantidadInsumo]").val(""); 

      // $(element).find(".idUnidadInsumo").attr("id","item["+index+"][idUnidadInsumo]").attr("name","item["+index+"][idUnidadInsumo]").val(""); 

      // $(element).find(".valorUnitarioInsumo").attr("id","item["+index+"][valorUnitarioInsumo]").attr("name","item["+index+"][valorUnitarioInsumo]").val(''); 

      // $(element).find(".totalInsumo").attr("id","item["+index+"][totalInsumo]").attr("name","item["+index+"][totalInsumo]").val('');

    })

    autocompletei(); 

  }

});




$("body").on("click touchstart","#btnGuardar",function(e){

    e.preventDefault();

      if(true === $("#frmGuardar").parsley().validate()){

         Swal.fire({

        title: '¿Está seguro?',

        text: 'Está a punto de agregar productos productos en proceso!',

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

            url:URL+"functions/inventario/guardarproductoproceso.php", 

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

                  title: 'Productos en proceso agregados!',

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

  })