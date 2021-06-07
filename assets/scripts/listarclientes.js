// $(document).ready(function(e){
// 	dataTable("#tableClientes"); 
// })


$(document).ready(function(){

    var table = $('#tableClientes').DataTable({
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
    $('#tableClientes thead tr').clone(true).appendTo( '#tableClientes thead' );

    $('#tableClientes thead tr:eq(1) th').each( function (i) {
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



$("body").on("click touchstart","#btnEliminar",function(e){

    e.preventDefault();

      var idEliminar=$(this).attr("value");
      

    // alert(idEliminar);
      

        Swal.fire({

        title: '¿Está seguro?',

        text: 'Está a punto de eliminar este cliente!',

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

            url:URL+"functions/cliente/eliminarcliente.php", 

            type:"POST", 

            data:  {"idEliminar":idEliminar},

            dataType: "json"


            }).done(function(msg){  

              if(msg.msg){

                Swal.fire(

                 {icon: 'success',

                  title: 'Cliente eliminado!',

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