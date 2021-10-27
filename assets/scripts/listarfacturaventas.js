// $(document).ready(function(e){

	// dataTable("#tableFacturas").draw(); 



    // $('#tableFacturas thead th').each( function () {
    //     var title = $(this).text();
    //     $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    // } );
 
    // // DataTable
    // var table = $('#tableFacturas').DataTable({
    //     initComplete: function () {
    //         // Apply the search
    //         this.api().columns().every( function () {
    //             var that = this;
 
    //             $( 'input', this.footer() ).on( 'keyup change clear', function () {
    //                 if ( that.search() !== this.value ) {
    //                     that
    //                         .search( this.value )
    //                         .draw();
    //                 }
    //             } );
    //         } );
    //     }
    // });

// let temp = $("#btn1").clone();
// $("#btn1").click(function(){
//     $("#btn1").after(temp);
// });

// $(document).ready(function(){
  $( window ).on( "load", function() {


    jQuery.fn.dataTable.Api.register( 'sum()', function ( ) {
    return this.flatten().reduce( function ( a, b ) {
      if ( typeof a === 'string' ) {
        a = a.replace(/[^\d.-]/g, '') * 1;
      }
      if ( typeof b === 'string' ) {
        b = b.replace(/[^\d.-]/g, '') * 1;
      }
      return a + b;
    }, 0);
  });
  
//   var empresa=document.getElementById('nombreEmpresa').value;
// var logo=document.getElementById('logoEmpresa').value;
// var nit=document.getElementById('nitEmpresa').value;
// var email=document.getElementById('emailEmpresa').value;
// var telefono=document.getElementById('telefonoEmpresa').value;
// var url=document.getElementById('url').value;
    var table = $('#tableFacturas').DataTable({
      drawCallback: function () {
        var api = this.api();
        var total = api.column( 5, {"filter":"applied"}).data().sum();
        $('#monto').html(total);
      },
      orderCellsTop: true,
       fixedHeader: true,
       
      // dom: 'Bfrtip',
      //   buttons: [

      //       {
      //       extend: 'copyHtml5',
      //       text: '<i class="far fa-copy" style="color: #fff;font-size: 26px;"></i>',
      //       className: 'botoncopiar',
      //       titleAttr: 'COPIAR'
      //       },
      //       {
      //       extend: 'excel',
      //       footer: true,
      //       title: 'PLAN CUENTAS',
      //       filename: 'CUENTAS CONTABLES',
      //       text:'<i class="fas fa-file-excel" style="color: #fff;font-size: 26px;"></i>',
      //       titleAttr: 'EXCEL'
      //       },
      //       {
      //       extend: 'csvHtml5',
      //       text: '<i class="fas fa-file-csv" style="color: #fff;font-size: 26px;"></i>',
      //       titleAttr: 'CSV'
            
      //       },
      //       {
      //       extend: 'pdf',
      //       text: '<i class="far fa-file-pdf" style="color: #fff;font-size: 26px;"></i>',
      //       messageTop:'CUENTAS CONTABLES',
      //       titleAttr: 'PDF'
            
      //       },
      //       {
      //       extend: 'print',
      //       text: '<i class="fas fa-print" style="color: #fff;font-size: 26px;"></i>',
      //       autoPrint: true,
      //       titleAttr: 'IMPRIMIR',
      //       messageTop:'<br><div>'+'nit: '+nit+'</div>'+'<div>  email: '+email+'</div><div>   telefono: '+telefono+'</div>',
      //       title: '<img src="'+url+logo+'" width="60" height="60">'+'   '+empresa

      //       }
            
      //   ]
        
    });

    //Creamos una fila en el head de la tabla y lo clonamos para cada columna
    $('#tableFacturas thead tr').clone(true).appendTo( '#tableFacturas thead' );

    $('#tableFacturas thead tr:eq(1) th').each( function (i) {
        var title = $(this).text(); //es el nombre de la columna
        $(this).html( '<input type="text"  class="form-control" style="heigth:25%;" />' );
 
        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );   
});



















// });

$("body").on("click touchstart",".comprobante",function(e){

	$("#frmGuardar")[0].reset(); 

	

	var factura=$(this).parents("tr").find("td").eq(3).html();

    var total=$(this).parents("tr").find("td").eq(5).html();

var idEmpresaSesion = $("#idEmpresaSesion").val();


  if (idEmpresaSesion!="0") {
    var saldo=$(this).parents("tr").find("td").eq(7).html();
    var idEmpresa=$(this).parents("tr").find("td").eq(9).html();
  }
  if (idEmpresaSesion=="0") {
    var saldo=$(this).parents("tr").find("td").eq(8).html();
    var idEmpresa=$(this).parents("tr").find("td").eq(10).html();
  }


// alert(numero);

	var id=$(this).attr("id"); 

  if (saldo!='$0,00') {
    $("#total").val(saldo); 
    $("#totalSaldo").val(saldo); 

  }
  if (saldo=='$0,00') {
    $("#total").val(total); 
    $("#totalSaldo").val(total); 
    
  }

	$("[name='datos[idFacturaVenta]']").val(id); 

	$("#nroFactura").val(factura); 

    
  $.ajax({
          url:URL+"functions/facturacompra/consultarcuentatotal.php", 
          type:"POST", 
          data: {"empresa":idEmpresa,"tipoFactura":'venta'}, 
          dataType: "json",
          }).done(function(msg){  

              if(msg.length!=0){

                  console.log('este:');
                  console.log(msg);
                  var sHtml=""; 
                  msg.forEach(function(element,index){
                    sHtml+="<option value='"+element.idEmpresaCuenta+"'>"+element.codigoCuenta+'-'+element.nombre+"</option>"; 
                  })
                  $("#cuentaContableTotal").html(sHtml);

                  if(msg.length>1){
                    $("#divCuentaContableTotal").removeClass('ocultar');
                  }
              }
              if(msg.length==0){
              }

            })


})





$("body").on("click touchstart","#btnGuardar",function(e){

    e.preventDefault();

      

      if(true === $("#frmGuardar").parsley().validate()){

        Swal.fire({

        title: '¿Está seguro?',

        text: 'Está a punto de marcar como pagada esta factura!',

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

            url:URL+"functions/facturaventa/guardarcomprobanteingreso.php", 

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

                  title: 'Pago realizado!',

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

  })


$('[data-toggle="tooltip"]').tooltip();




$("body").on("click touchstart","#btnEliminar",function(e){

    e.preventDefault();

      var idEliminar=$(this).attr('name');
      // var posicion=idEliminar.substring(12,13);
      var posicion=idEliminar.split('[');
      var posicion2=posicion[1].split(']');
      var posicion3=posicion2[0];
      // alert(posicion);
      var inputPoscion="idFacturaVentaEliminar["+posicion3+"][idFacturaVentaEliminar]";
      var idFacturaEliminar=document.getElementById(inputPoscion).value;


      // if(true === $("#frmEliminar").parsley().validate()){

        Swal.fire({

        title: '¿Está seguro?',

        text: 'Está a punto de eliminar esta factura!',

        icon: 'warning', 

        showCancelButton: true,

        showLoaderOnConfirm: true,

        confirmButtonText: `Si, Eliminar!`,

        cancelButtonText:'Cancelar',

        preConfirm: function(result) {

          return new Promise(function(resolve) {

            // var formu = document.getElementById("frmEliminar");

      

            // var data = new FormData(formu);

            $.ajax({

            url:URL+"functions/facturaventa/eliminarfacturaventa.php", 

            type:"POST", 

            data:  {"idFactura":idFacturaEliminar},

            dataType: "json"


            }).done(function(msg){  

              if(msg.msg){

                Swal.fire(

                 {icon: 'success',

                  title: 'Factura eliminada!',

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
      // }

  })





$("body").on("click touchstart","#btnAnular",function(e){

    e.preventDefault();

      var idAnular=$(this).attr('name');
      // var posicion=idAnular.substring(10,11);
      var posicion=idAnular.split('[');
      var posicion2=posicion[1].split(']');
      var posicion3=posicion2[0];
      // alert(posicion);
      var inputPoscion="idFacturaVentaEliminar["+posicion3+"][idFacturaVentaEliminar]";
      var idFacturaAnular=document.getElementById(inputPoscion).value;
      // alert(idFacturaAnular);

      // if(true === $("#frmEliminar").parsley().validate()){

        Swal.fire({

        title: '¿Está seguro?',

        text: 'Está a punto de anular esta factura!',

        icon: 'warning', 

        showCancelButton: true,

        showLoaderOnConfirm: true,

        confirmButtonText: `Si, Anular!`,

        cancelButtonText:'Cancelar',

        preConfirm: function(result) {

          return new Promise(function(resolve) {

            // var formu = document.getElementById("frmEliminar");

      

            // var data = new FormData(formu);

            $.ajax({

            url:URL+"functions/facturaventa/anularfacturaventa.php", 

            type:"POST", 

            data:  {"idFactura":idFacturaAnular},

            dataType: "json"


            }).done(function(msg){  

              if(msg.msg){

                Swal.fire(

                 {icon: 'success',

                  title: 'Factura anulada!',

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
      // }

  })