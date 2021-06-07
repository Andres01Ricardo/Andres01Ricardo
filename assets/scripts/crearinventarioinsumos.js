var aDatos=[]; 

$(document).ready(function(e){
  var idEmpresa = document.getElementById('datos[idEmpresa]').value;

        

	$.ajax({

	    url:URL+"functions/inventario/cargarinsumos.php", 

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

              cantidadMinima:element.cantidadMinima,

			      })

	      })

	      autocomplete(); 

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

        var sHtml="<option value='"+ui.item.idUnidad+"'>"+ui.item.unidad+"</option>";

        $(".idUnidad").eq(index).html(sHtml);

        $(".idUnidadMinima").eq(index).html(sHtml);

        var valorCantidadMinima = parseFloat(ui.item.valorUnitario) * parseInt(ui.item.cantidadMinima);

        valorCantidadMinima=Math.round(valorCantidadMinima);

        $( ".valorUnitario" ).eq(index).val( valorCantidadMinima );

        $( ".cantidadMinima" ).eq(index).val( ui.item.cantidadMinima );

        $( ".valorUnitario" ).attr("readonly","readonly");
        $( ".valorUnitario" ).addClass("readOnly");

        $( ".cantidadMinima" ).attr("readonly","readonly");
        $( ".cantidadMinima" ).addClass("readOnly");

        $(".cantidadMinima").prop('disabled', 'disabled');

        $(".valorUnitario").prop('disabled', 'disabled');


        return false;

      },

      select: function( event, ui ) {

        var index=$(this).index(".producto")

        $( ".producto" ).eq(index).val( ui.item.label );

        $( ".idProducto" ).eq(index).val( ui.item.value );


        var sHtml="<option value='"+ui.item.idUnidad+"'>"+ui.item.unidad+"</option>";
        $(".idUnidad").eq(index).html(sHtml);
        $(".idUnidadMinima").eq(index).html(sHtml);

        var valorCantidadMinima = parseFloat(ui.item.valorUnitario) * parseInt(ui.item.cantidadMinima);
        valorCantidadMinima=Math.round(valorCantidadMinima);

        $( ".valorUnitario" ).eq(index).val(valorCantidadMinima );

        $( ".valorUnitario" ).attr("readonly","readonly");
        $( ".valorUnitario" ).addClass("readOnly");

        $( ".cantidadMinima" ).attr("readonly","readonly");
        $( ".cantidadMinima" ).addClass("readOnly");
        $(".cantidadMinima").prop('disabled', 'disabled');

        $(".cantidadMinima").prop('disabled', 'disabled');

        $(".valorUnitario").prop('disabled', 'disabled');

        return false;

      },

      change: function(event, ui){

        var index=$(this).index(".producto")

        $( ".valorUnitario" ).removeAttr("readonly","readonly");
        $( ".valorUnitario" ).removeClass("readOnly");

        $( ".cantidadMinima" ).removeAttr("readonly","readonly");
        $( ".cantidadMinima" ).removeClass("readOnly");
        

        if(ui.item==null){

          $( ".idProducto" ).eq(index).val('');

          $( ".valorUnitario" ).eq(index).val('');

          $( ".cantidadMinima" ).eq(index).val('');
          $(".cantidadMinima").prop('disabled', false);

          $(".valorUnitario").prop('disabled', false);

          $.ajax({

          url:URL+"functions/inventario/consultarunidad.php", 

          type:"POST", 

          data: {"idEmpresa":$("[name='datos[idEmpresa]']").val()}, 

          dataType: "json",

          }).done(function(msg){  

            var sHtml="<option value=''>"+'Seleccione'+"</option>"; 

            msg.unidad.forEach(function(element,index){

              sHtml+="<option value='"+element.idUnidad+"'>"+element.nombre+"</option>"; 

            });

            $(".idUnidad").eq(index).html(sHtml);
            $(".idUnidadMinima").eq(index).html(sHtml);

        });

        }

        return false;

      }

    })

}








$("body").on("keyup",".cantidad, .valorUnitario",function(e){

  var cantidad=$(this).parents("tr").find(".cantidad").val(); 

  if($(this).parents("tr").find(".valorUnitario").val()!=""){var valorMinimo=eliminarMoneda(eliminarMoneda($(this).parents("tr").find(".valorUnitario").val(),"$",""),",",""); }else{ var valorMinimo=0}

  var cantidadMinima=$(this).parents("tr").find(".cantidadMinima").val();

  var valorUnitario= parseFloat(valorMinimo)/parseInt(cantidadMinima);
  
  total=parseInt(cantidad)*parseFloat(valorUnitario); 

  $(this).parents("tr").find(".total").val(total).trigger("change");

  totalizar(); 

})


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



      // $(element).find(".producto").attr("id","item["+index+"][producto]").attr("name","item["+index+"][producto]").val("");

      // $(element).find(".idProducto").attr("id","item["+index+"][idProducto]").attr("name","item["+index+"][idProducto]").val("");

      // $(element).find(".cantidad").attr("id","item["+index+"][cantidad]").attr("name","item["+index+"][cantidad]").val(""); 

      // $(element).find(".idUnidad").attr("id","item["+index+"][idUnidad]").attr("name","item["+index+"][idUnidad]").val(""); 

      // $(element).find(".valorUnitario").attr("id","item["+index+"][valorUnitario]").attr("name","item["+index+"][valorUnitario]").val(''); 

      // $(element).find(".total").attr("id","item["+index+"][total]").attr("name","item["+index+"][total]").val('');

    })

    autocomplete(); 

  }

});







$("body").on("click touchstart","#btnGuardar",function(e){

    e.preventDefault();

      if(true === $("#frmGuardar").parsley().validate()){

         Swal.fire({

        title: '¿Está seguro?',

        text: 'Está a punto de agregar insumos al inventario!',

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

            url:URL+"functions/inventario/guardarinsumo.php", 

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

                  title: 'Insumos agregados!',

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