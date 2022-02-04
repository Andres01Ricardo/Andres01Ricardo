var empresa=document.getElementById('empresa').value;
var logo=document.getElementById('logo').value;
var nit=document.getElementById('nitEmpresa').value;
var digitoVerificador=document.getElementById('digitoVerificador').value;
var fecha=new Date();
var dia=fecha.getDate();
var mes=fecha.getMonth()+1;
var anio=fecha.getFullYear();
var hoy=fecha.toLocaleDateString();
var url=document.getElementById('url').value;

$(document).ready(function(e){
  var table = $('#tableInsumos').DataTable({
      // orderCellsTop: true,
      //  fixedHeader: true,
      paging: false,
      ordering: false,
      dom: 'Blfrtip',
        buttons: [
            
            // {
            // extend: 'pdf',
            // customize: function(doc) {
            //     doc.pageMargins = [ 10, 10, 10, 10 ]
            // },
            // pageSize: 'A4',
            // text: '<i class="far fa-file-pdf" style="color: #fff;font-size: 26px;"></i>',
            // titleAttr: 'PDF',
            // // title:'Juriscon--           '+empresa+'             '+hoy+'\n Nit: '+nit+'-'+digitoVerificador+'\n ESTADO SITUACION FINANCIERA - '+tipo+'\n DESDE:  '+desde+' HASTA: '+hasta,  
          
            //     },
            {
            extend: 'print',
            // printOptions: {
            //         columns: [ 0, 1, 2, 3, 4, 5, 6 ];
            // },
            customize: function ( win ) {
                    $(win.document.body).find( '.derecha' ).css( 'text-align', 'right' );
                },
            
            text: '<i class="fas fa-print" style="color: #fff;font-size: 26px;"></i>',
            autoPrint: true,
            titleAttr: 'IMPRIMIR',
            title:'<table class="table"><thead><tr><th style="float:left;">Smartbuss</th><th ><img src="'+url+logo+'" width="140" height="100">    '+empresa+'</th><th></th><th>'+hoy+'</th></tr><tr><th> </th><th>Nit: '+nit+'-'+digitoVerificador+'</th><th> </th><th> </th></tr></thead></table>',
            }
        ] 
    });

  var idEmpresa = $("[name='datos[idEmpresa]'").val();
  console.log(idEmpresa);
	$.ajax({
	    url:URL+"functions/inventario/cargarproductosinventario.php", 
	    type:"POST", 
	    data: {"idEmpresa":idEmpresa}, 
	    dataType: "json",
	    }).done(function(msg){  
        console.log(msg);
        // var sHtml="";
        var  sHtml="<option value=''>Seleccione una opción</option>"; 
	      msg.forEach(function(element,index){
	      	sHtml+="<option value='"+element.idProductoServicio+"'>"+element.codigo+' '+element.nombre+"</option>"; 
	      })
	      $("#idProducto").html(sHtml);
	  });  


      $.ajax({
      url:URL+"functions/inventario/cargarcategoriasinventario.php", 
      type:"POST", 
      data: {"idEmpresa":idEmpresa}, 
      dataType: "json",
      }).done(function(msg){  
        var  sHtmlC="<option value=''>Seleccione una opción</option>"; 
        msg.forEach(function(element,index){
          sHtmlC+="<option value='"+element.idCategoriaInventario+"'>"+element.nombre+"</option>"; 
        })
        $("#idCategoria").html(sHtmlC);
    });
})



// $("body").on("keyup",".cantidadInsumo, .valorUnitarioInsumo",function(e){

//   var cantidad=$(this).parents("tr").find(".cantidadInsumo").val(); 

//   if($(this).parents("tr").find(".valorUnitarioInsumo").val()!=""){var valorUnitario=eliminarMoneda(eliminarMoneda($(this).parents("tr").find(".valorUnitarioInsumo").val(),"$",""),",",""); }else{ var valorUnitario=0}

//   total=parseInt(cantidad)*parseFloat(valorUnitario); 

//   $(this).parents("tr").find(".totalInsumo").val(total).trigger("change");

//   // totalizar2(); 

// })


// totalizar2=function(){

//   var valor=0; 

//   var total=0; 

//   $(".totalInsumo").each(function(index,element){

//     if($(element).val()!=""){valor=parseFloat(eliminarMoneda(eliminarMoneda($(element).val(),"$",""),",","")); }else{ valor=0; }

//     total+=valor;

//   })

// }




// totalizar=function(){

//   var valor=0; 

//   var total=0; 

//   $(".total").each(function(index,element){

//     if($(element).val()!=""){valor=parseFloat(eliminarMoneda(eliminarMoneda($(element).val(),"$",""),",","")); }else{ valor=0; }

//     total+=valor

//   })

// }

$("body").on("click","#btnAgregarProducto",function(e){
  $("#modalProductos").modal('show');
})

$("body").on("click","#btnAgregarCat",function(e){
  $("#modalCat").modal('show');
})


$("body").on("click touchstart","#btnGuardar",function(e){
    e.preventDefault();
      if(true === $("#frmGuardar").parsley().validate()){
        Swal.fire({
        title: '¿Está seguro?',
        text: 'Está a punto de agregar este producto al inventario inicial!',
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
            url:URL+"functions/inventario/guardarinventarioinicial.php", 
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
                  title: 'Producto agregado!',
                  text: 'con exito',
                  closeOnConfirm: true,
                }
                ).then((result) => {
                 location.reload(); 
                })
              }else{
                 Swal.fire(
                  'El producto ya fue agregado al inventario inicial!',
                  'Realice los ingresos y egresos correspondientes',
                  'error'
                ).then((result) => {
                 location.reload(); 
                })

              }
            });
          });
        }
      })
      }
  })





$("body").on("click touchstart","#btnGuardarProducto",function(e){
    e.preventDefault();
      if(true === $("#frmGuardarProducto").parsley().validate()){
        Swal.fire({
        title: '¿Está seguro?',
        text: 'Está a punto de agregar un producto nuevo!',
        icon: 'warning', 
        showCancelButton: true,
        showLoaderOnConfirm: true,
        confirmButtonText: `Si, Guardar!`,
        cancelButtonText:'Cancelar',
        preConfirm: function(result) {
          return new Promise(function(resolve) {
            var formu = document.getElementById("frmGuardarProducto");
            var data = new FormData(formu);
            $.ajax({
            url:URL+"functions/inventario/guardarproductoinventario.php", 
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
                  title: 'Producto agregado!',
                  text: 'con exito',
                  closeOnConfirm: true,
                }
                ).then((result) => {
                 var idEmpresa = $("[name='datos[idEmpresa]'").val();
                  console.log(idEmpresa);
                  $.ajax({
                      url:URL+"functions/inventario/cargarproductosinventario.php", 
                      type:"POST", 
                      data: {"idEmpresa":idEmpresa}, 
                      dataType: "json",
                      }).done(function(msg){  
                        console.log(msg);
                        // var sHtml="";
                        var  sHtml="<option value=''>Seleccione una opción</option>"; 
                        msg.forEach(function(element,index){
                          sHtml+="<option value='"+element.idProductoServicio+"'>"+element.codigo+' '+element.nombre+"</option>"; 
                        })
                        $("#idProducto").html(sHtml);
                        $("#modalProductos").modal('hide');
                    });
                })
              }else{
                 Swal.fire(
                  'El codigo de producto ya existe!',
                  'verifique que sea el codigo correcto',
                  'error'
                )

              }
            });
          });
        }
      })
      }
  })



$("body").on("click touchstart","#btnGuardarCategoria",function(e){
    e.preventDefault();
      if(true === $("#frmGuardarCategoria").parsley().validate()){
        Swal.fire({
        title: '¿Está seguro?',
        text: 'Está a punto de agregar una nueva categoria de inventario!',
        icon: 'warning', 
        showCancelButton: true,
        showLoaderOnConfirm: true,
        confirmButtonText: `Si, Guardar!`,
        cancelButtonText:'Cancelar',
        preConfirm: function(result) {
          return new Promise(function(resolve) {
            var formu = document.getElementById("frmGuardarCategoria");
            var data = new FormData(formu);
            $.ajax({
            url:URL+"functions/inventario/guardarcategoria.php", 
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
                  title: 'Categoria agregada!',
                  text: 'con exito',
                  closeOnConfirm: true,
                }
                ).then((result) => {
                 var idEmpresa = $("[name='datos[idEmpresa]'").val();
                  console.log(idEmpresa);
                  $.ajax({
                    url:URL+"functions/inventario/cargarcategoriasinventario.php", 
                    type:"POST", 
                    data: {"idEmpresa":idEmpresa}, 
                    dataType: "json",
                    }).done(function(msg){  
                      var  sHtmlC="<option value=''>Seleccione una opción</option>"; 
                      msg.forEach(function(element,index){
                        sHtmlC+="<option value='"+element.idCategoriaInventario+"'>"+element.nombre+"</option>"; 
                      })
                      $("#idCategoria").html(sHtmlC);
                      $("#modalCat").modal('hide');
                  });
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


$("#categoria").keypress(function(e) { 
  var code = (e.keyCode ? e.keyCode : e.which); if(code == 13){ 

    return false; 
  } 
});

$('[data-toggle="tooltip"]').tooltip();