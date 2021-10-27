$("body").on("click","#btnGuardar",function(e){
    e.preventDefault();
      if(true === $("#frmGuardar").parsley().validate()){
        Swal.fire({
        title: '¿Está seguro?',
        text: 'Está a punto de guardar un nuevo anticipo!',
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
            url:URL+"functions/facturaventa/guardaranticipoventa.php", 
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
                    title: 'Anticipo Creado!',
                    text: 'con exito',
                    closeOnConfirm: true,
                  }

                ).then((result) => {

                 location.reload(); 

                })

              }else{

                 Swal.fire(

                  'Algo ha salido mal!',

                  'Revise su conexión a internet',

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

       

      }

  })



// $("body").on("change","[name='datos[tipoCuenta]']",function(e){

  
//     if($(this).val()==1 || $(this).val()==2){
//       $("#idBanco").css("display", "block");
//       $("#selectIdBanco").attr("required","required");
//       $("#numeroCuenta").css("display", "block");
//       $("#aplicaCuatroMil").css("display", "block");
//       $("#inputNumeroCuenta").attr("required","required");
      
//     }
//     if($(this).val()==3){
//       $("#idBanco").css("display", "none");
//       $("#selectIdBanco").removeAttr("required");
//       $("#numeroCuenta").css("display", "none");
//       $("#inputNumeroCuenta").removeAttr("required");
//       $("#aplicaCuatroMil").css("display", "none");
//       $("#aplicaCuatroMilSi").removeAttr("checked");
//       $("#aplicaCuatroMilNo").attr("checked","checked");
//     }
// })



$( window ).on( "load", function() {

  var table = $('#tableEnterprise').DataTable({
      // drawCallback: function () {
      //   var api = this.api();
      //   var total = api.column( 5, {"filter":"applied"}).data().sum();
      //   $('#monto').html(total);
      // },
      orderCellsTop: true,
       fixedHeader: true,
       
      dom: 'Bfrtip',
        buttons: [

            // {
            // extend: 'copyHtml5',
            // text: '<i class="far fa-copy" style="color: #fff;font-size: 26px;"></i>',
            // className: 'botoncopiar',
            // titleAttr: 'COPIAR'
            // },
            {
            extend: 'excel',
            footer: true,
            title: 'Ancipos de venta',
            filename: 'ANTICIPOS DE VENTA',
            text:'<i class="fas fa-file-excel" style="color: #fff;font-size: 26px;"></i>',
            titleAttr: 'EXCEL'
            },
            // {
            // extend: 'csvHtml5',
            // text: '<i class="fas fa-file-csv" style="color: #fff;font-size: 26px;"></i>',
            // titleAttr: 'CSV'
            
            // },
            {
            extend: 'pdf',
            text: '<i class="far fa-file-pdf" style="color: #fff;font-size: 26px;"></i>',
            messageTop:'ANTICIPOS DE VENTA',
            titleAttr: 'PDF'
            
            },
            // {
            // extend: 'print',
            // text: '<i class="fas fa-print" style="color: #fff;font-size: 26px;"></i>',
            // autoPrint: true,
            // titleAttr: 'IMPRIMIR',
            // messageTop:'<br><div>'+'nit: '+nit+'</div>'+'<div>  email: '+email+'</div><div>   telefono: '+telefono+'</div>',
            // title: '<img src="'+url+logo+'" width="60" height="60">'+'   '+empresa

            // }
            
        ]
        
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


})



  