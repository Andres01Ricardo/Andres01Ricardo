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
	// dataTable("#tableEnterprise"); 
  var table = $('#tableEnterprise').DataTable({
      // orderCellsTop: true,
      //  fixedHeader: true,
      paging: false,
      ordering: false,
      dom: 'Blfrtip',
        buttons: [
            // {
            // extend: 'excel',
            // footer: true,
            // title: 'BALANCE COMPROBACION',
            // filename: 'BALANCE COMPROBACION',
            // text:'<i class="fas fa-file-excel" style="color: #fff;font-size: 26px;"></i>',
            // titleAttr: 'EXCEL'
            // },
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
})



$("body").on("click touchstart",".sumarInsumo",function(e){

	// $("#frmGuardar")[0].reset(); 
  var idBodega = $(this).attr("bodega");

	var codigo=$(this).parents("tr").find("td").eq(0).html()
  var producto=$(this).parents("tr").find("td").eq(1).html()

	var unidad=$(this).parents("tr").find("td").eq(3).html()

	// var factura=$(this).parents("tr").find("td").eq(4).html()

 //    var total=$(this).parents("tr").find("td").eq(6).html()
	var id=$(this).attr("id"); 

	$("[name='datos[idProducto]']").val(id); 

	$("#codigoSumar").val(codigo); 

  $("#insumoSumar").val(producto); 

	$("#unidadSumar").val(unidad); 

  $("#idBodegaSumar").val(idBodega); 
	// $("#empresa").val(empresa); 
    
 //    $("#total").val(total); 
})



$("body").on("click touchstart",".restarInsumo",function(e){
  var idBodega = $(this).attr("bodega");
	// $("#frmGuardar")[0].reset(); 
  var codigo=$(this).parents("tr").find("td").eq(0).html()

	var insumo=$(this).parents("tr").find("td").eq(1).html()

	var unidad=$(this).parents("tr").find("td").eq(3).html()

	// var factura=$(this).parents("tr").find("td").eq(4).html()

 //    var total=$(this).parents("tr").find("td").eq(6).html()

	var id=$(this).attr("id"); 

	$("[name='datos[idProductoRestar]']").val(id); 

  $("#codigoRestar").val(codigo);

	$("#insumoRestar").val(insumo); 

	$("#unidadRestar").val(unidad); 
  $("#idBodegaRestar").val(idBodega); 
})


$("body").on("click touchstart","#btnSumar",function(e){
    e.preventDefault();
      if(true === $("#frmSumar").parsley().validate()){
        Swal.fire({
        title: '¿Está seguro?',
        text: 'Está a punto de sumar unidades al inventario de productos!',
        icon: 'warning', 
        showCancelButton: true,
        showLoaderOnConfirm: true,
        confirmButtonText: `Si, Guardar!`,
        cancelButtonText:'Cancelar',
        preConfirm: function(result) {
          return new Promise(function(resolve) {
            var formu = document.getElementById("frmSumar");
            var data = new FormData(formu);
            $.ajax({
            url:URL+"functions/inventario/modificarinventarioproductoterminado.php", 
            type:"POST", 
            data: data,
            contentType:false, 
            processData:false, 
            dataType: "json",
            cache:false 
            }).done(function(msg){  
              if(msg.msg){
                Swal.fire(
                 {icon: 'success',
                  title: 'Inventario modificado!',
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

$("body").on("click touchstart","#btnRestar",function(e){
    e.preventDefault();
      if(true === $("#frmRestar").parsley().validate()){
        Swal.fire({
        title: '¿Está seguro?',
        text: 'Está a punto de restar unidades al inventario de productos!',
        icon: 'warning', 
        showCancelButton: true,
        showLoaderOnConfirm: true,
        confirmButtonText: `Si, Guardar!`,
        cancelButtonText:'Cancelar',
        preConfirm: function(result) {
          return new Promise(function(resolve) {
            var formu = document.getElementById("frmRestar");
            var data = new FormData(formu);
            $.ajax({
            url:URL+"functions/inventario/modificarinventarioproductoterminado.php", 
            type:"POST", 
            data: data,
            contentType:false, 
            processData:false, 
            dataType: "json",
            cache:false 
            }).done(function(msg){  
              if(msg.msg){
                Swal.fire(
                 {icon: 'success',
                  title: 'Inventario modificado!',
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


$('[data-toggle="tooltip"]').tooltip()