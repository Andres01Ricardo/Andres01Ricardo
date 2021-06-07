// $("body").on("click","#btnAceptarCuotas",function(e){

//     e.preventDefault();

//       if(true === $("#frmGuardar").parsley().validate()){

//           Swal.fire({

//           title: 'Está seguro?',

//           text: 'Está a punto de aceptar el valor de la cuota',

//           icon: 'warning', 

//           showCancelButton: true,

//           showLoaderOnConfirm: true,

//           confirmButtonText: `Si, Continuar!`,

//           cancelButtonText:'Cancelar',

//           preConfirm: function(result) {

//               return new Promise(function(resolve) {

//                 var formu = document.getElementById("frmGuardar");

        

//                 var data = new FormData(formu);

//                 $.ajax({

//                 url:URL+"functions/nomina/guardasimulacionlibranza.php", 

//                 type:"POST", 

//                 data: data,

//                 contentType:false, 

//                 processData:false, 

//                 dataType: "json",

//                 cache:false 

//                 }).done(function(msg){  

//                   if(msg.msg){

//                     Swal.fire({

//                       icon: 'success',

//                       title: 'Empleado creado!',

//                       text: 'con exito',

//                       closeOnConfirm: true,

//                     }

//                     ).then((result) => {

//                      location.replace('cuotaaceptada/',msg.id,'?valorCuota=',msg.valorCuota,'&valorCredito=',msg.valorCredito);

//                     })

//                   }else{

//                      Swal.fire(

//                       'Algo ha salido mal!',

//                       'Verifique su conexión a internet',

//                       'error'
//                     ).then((result) => {
//                     })
//                   }
//               });    
//               });
//             }
//         })
//       }
//   })