// $(document).ready(function(e){

// 	dataTable("#tableEnterprise"); 

// })

$(document).ready(function(){

    var table = $('#tableEnterprise').DataTable({
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
    $('#tableEnterprise thead tr').clone(true).appendTo( '#tableEnterprise thead' );

    $('#tableEnterprise thead tr:eq(1) th').each( function (i) {
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



$("body").on("click touchstart",".ingresarRol",function(e){

	var id=$(this).attr("id"); 

	var texto=$(this).parents("tr").find("td").eq(3).html(); 

	Swal.fire({

          title: 'Está seguro?',

          text: 'Está a punto de cambiar al perfil de '+texto+'!',

          icon: 'warning', 

          showCancelButton: true,

          showLoaderOnConfirm: true,

          confirmButtonText: `Si, Ingresar!`,

          cancelButtonText:'Cancelar',

          preConfirm: function(result) {

          return new Promise(function(resolve) {

            

            var data = new FormData();

            data.append("id",id)

            $.ajax({

            url:URL+"functions/sesion/cambiarsesionrol.php", 

            type:"POST", 

            data: data,

            contentType:false, 

            processData:false, 

            dataType: "json",

            cache:false 

            }).done(function(msg){  

              if(msg.msg){

                 window.location.href="inicio"; 

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

        }).then((result) => {

          if (result.isConfirmed) {

          } 



         })



})



$("body").on("click touchstart",".ingresar",function(e){

    var id=$(this).attr("id"); 

    var texto=$(this).parents("tr").find("td").eq(3).html(); 

    Swal.fire({

          title: 'Está seguro?',

          text: 'Está a punto de ingresar a trabajar en la empresa '+texto+'!',

          icon: 'warning', 

          showCancelButton: true,

          showLoaderOnConfirm: true,

          confirmButtonText: `Si, Ingresar!`,

          cancelButtonText:'Cancelar',

          preConfirm: function(result) {

          return new Promise(function(resolve) {

            

            var data = new FormData();

            data.append("id",id)

            $.ajax({

            url:URL+"functions/sesion/cambiarsesion.php", 

            type:"POST", 

            data: data,

            contentType:false, 

            processData:false, 

            dataType: "json",

            cache:false 

            }).done(function(msg){  

              if(msg.msg){

                 window.location.href="inicio"; 

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

        }).then((result) => {

          if (result.isConfirmed) {

          } 



         })



})