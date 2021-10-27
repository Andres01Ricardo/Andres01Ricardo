// $(document).ready(function(e){

// 	dataTable("#tableNomina"); 

// })

$(document).ready(function(){

    var table = $('#tableNomina').DataTable({
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
    $('#tableNomina thead tr').clone(true).appendTo( '#tableNomina thead' );

    $('#tableNomina thead tr:eq(1) th').each( function (i) {
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



$("body").on("click touchstart",".finalizar",function(e){

	var idNomina=$(this).attr("id");
  var idEmpresa=$(this).attr("idEmpresa");

	var valor=$(this).parents("tr").find("td").eq(3).html();
	// var empresa=$(this).parents("tr").find("td").eq(5).html();
	$("[name='datos[idNomina]']").val(idNomina); 
  $("[name='datos[idEmpresa]']").val(idEmpresa); 
	// $("#titulo").html(periodo+" / "+empresa)
  $("#valorNomina").val(valor);
  // alert(idEmpresa)

  e.preventDefault();

  $.ajax({
      url:URL+"functions/nomina/cargarcuentabancaria.php", 
      type:"POST",
      data: {"idEmpresa":idEmpresa},
      dataType: "json",
      }).done(function(msg){  
        console.log('aca');
        console.log(msg);
        var sHtml=""; 
        msg.forEach(function(element,index){
          sHtml+="<option value='"+element.idCuentaBancaria+"'>"+element.numeroCuenta+' '+element.nombreCuenta.toUpperCase()+"</option>"; 
        })
        $("#cuentaBancaria").html(sHtml);
    });
})



$("body").on("click touchstart","#btnGuardar",function(e){

        e.preventDefault();
        Swal.fire({
          title: 'Está seguro?',
          text: 'Está a punto de pagar esta nómina!',
          icon: 'warning', 
          showCancelButton: true,
          showLoaderOnConfirm: true,
          confirmButtonText: `Si, Continuar!`,
          cancelButtonText:'Cancelar',
          preConfirm: function(result) {
          return new Promise(function(resolve) {

            var formu = document.getElementById("frmFinalizar");
            var data = new FormData(formu);
            
            $.ajax({
            url:URL+"functions/nomina/finalizarnomina.php", 
            type:"POST",
            data:data,
            dataType: "json",
            contentType:false, 
            processData:false, 
            cache:false 
            }).done(function(msg){  
              if(msg.msg){
                Swal.fire({
                  icon: 'success',
                  title: "Nomina finalizada!",
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
})

//     e.preventDefault();


//         Swal.fire({
//           title: 'Está seguro?',
//           text: 'Está a punto de finalizar la realización de esta nomina!',
//           icon: 'warning', 
//           showCancelButton: true,
//           showLoaderOnConfirm: true,
//           confirmButtonText: `Si, Continuar!`,
//           cancelButtonText:'Cancelar',
//           preConfirm: function(result) {
//           return new Promise(function(resolve) {
            
//             $.ajax({
//             url:URL+"functions/nomina/finalizarnomina.php", 
//             type:"POST",
//             data: {"idNomina":$},
//             contentType:false, 
//             processData:false, 
//             dataType: "json",
//             cache:false 
//             }).done(function(msg){  
//               if(msg.msg){
//                 Swal.fire({
//                   icon: 'success',
//                   title: "Nomina finalizada!",
//                   text: 'con exito',
//                   closeOnConfirm: true,
//                 }
//                 ).then((result) => {
//                  location.reload();
//                 })
//               }else{
//                  Swal.fire(
//                   'Algo ha salido mal!',
//                   'Verifique su conexión a internet',
//                   'error'
//                 ).then((result) => {
//                 })
//               }
//           });     

//           });

//         }

//         })

//   })



$("body").on("click",".nominaEliminar",function(e){

  e.preventDefault();
  var idEliminar=$(this).attr('value');
  // var tipoNovedad=$(this).attr('tipoNovedad');
  // alert(idEliminar);
  

      // if(true === $("#frmEliminar").parsley().validate()){
        Swal.fire({

        title: '¿Está seguro?',

        text: 'Está a punto de eliminar esta nomina!',

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

            url:URL+"functions/nomina/eliminarnomina.php", 

            type:"POST", 

            data:  {"idEliminar":idEliminar},

            dataType: "json"


            }).done(function(msg){  

              if(msg.msg){

                Swal.fire(

                 {icon: 'success',

                  title: 'Nomina eliminada!',

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
})