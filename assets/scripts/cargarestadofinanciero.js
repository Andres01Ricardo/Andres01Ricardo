

$("body").on("click touchstart","#btnGuardar",function(e){

    e.preventDefault();

    if($("#excel").val()!=""){

      var formu = document.getElementById("frmGuardar");



      var data = new FormData(formu);

      $.ajax({

      url:URL+"functions/dashboard/leerestadofinanciero.php", 

      type:"POST", 

      data: data, 

      contentType:false, 

      processData:false, 

      dataType: "json",

      cache:false

      }).done(function(msg){  

        $(".cabecera h4").html(msg.cabecera.titulo); 

        $(".fecha").html(msg.cabecera.fecha); 

        $("[name='datos[titulo]']").val(msg.cabecera.titulo); 

        $("[name='datos[subtitulo]']").val(msg.cabecera.fecha); 

        var sHtml=""; 

        msg.info.forEach(function(element,index){

          var clase=""; 

          if(element.utilidad==1){clase="negrita"}

          if(element.equivalencia==null){element.equivalencia=0}

          var tipo=0; 
        if (element.cuenta=='Ingresos Operacionales' || element.cuenta=='Ingresos No Operacionales') {
          tipo=2;
        }
        if (element.cuenta=='Gastos operacionales de Administracion' || element.cuenta=='Gastos operacionales de Ventas' || element.cuenta=='Gastos No Operacionales') {tipo=3;}

          if((index+1)==msg.info.length){tipo=1;}

          sHtml+="<tr class='"+clase+"'>"

          +"<td class='tddashboard'>"

          +"<input type='hidden' name='item["+index+"][cuenta]' id='item["+index+"][cuenta]' value='"+element.cuenta+"'/>"

          +"<input type='hidden' name='item["+index+"][valor]' id='item["+index+"][valor]' value='"+element.valor+"'/>"

          +"<input type='hidden' name='item["+index+"][porcentaje]' id='item["+index+"][porcentaje]' value='"+element.equivalencia+"'/>"

          +"<input type='hidden' name='item["+index+"][tipo]' id='item["+index+"][tipo]' value='"+tipo+"'/>"

          +element.cuenta+"</td>"

          +"<td class='tddashboard' style='width:15%'>"+element.valor+"</td>"

          +"<td class='tddashboard' style='width:10%'>"+parseFloat(element.equivalencia).toFixed(2)+"%</td>"

          +"</tr>";

        })



        $("#estadoFinanciero tbody").html(sHtml)

        $(".estadoFinanciero").removeClass("ocultar");

    });

    }

    

})



$("body").on("click touchstart","#btnGuardarInfo",function(e){

    e.preventDefault();

      if(true === $("#frmGuardar").parsley().validate()){

          Swal.fire({

        title: 'Está seguro?',

        text: 'Está a punto de guardar este estado financiero!',

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

            url:URL+"functions/dashboard/guardarestadofinanciero.php", 

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

                  title: 'Estado Financiero Guardado!',

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

      }).then((result) => {

        if (result.isConfirmed) {

        //   var formu = document.getElementById("frmGuardar");

      

        //   var data = new FormData(formu);

        //   $.ajax({

        //   url:URL+"functions/dashboard/guardarestadofinanciero.php", 

        //   type:"POST", 

        //   data: data,

        //   contentType:false, 

        //   processData:false, 

        //   dataType: "json",

        //   cache:false 

        //   }).done(function(msg){  

        //     if(msg.msg){

        //       Swal.fire(

        //        {icon: 'success',

        //         title: 'Estado Financiero Guardado!',

        //         text: 'con exito',

        //         closeOnConfirm: true,

        //       }

        //       ).then((result) => {

        //        location.reload(); 

        //       })

        //     }else{

        //        Swal.fire(

        //         'Algo ha salido mal!',

        //         'Verifique su conexión a internet',

        //         'error'

        //       ).then((result) => {

                

        //       })

        //     }

          

        // });

        } 



       })







          // swal({

          //   title: 'Está seguro?',

          //   text: 'Está a punto de guardar este estado financiero!',

          //   icon: 'warning',

          //   buttons: {

          //       confirm : {text:'Si, Guardar!',className:'sweet-warning',closeModal:false},

          //       cancel : 'Cancelar' 

          //   },

          //   dangerMode: true,

          // })

          //   .then((willDelete) => {

          //     if (willDelete) {

          //       var formu = document.getElementById("frmGuardar");

            

          //       var data = new FormData(formu);

          //       $.ajax({

          //       url:URL+"functions/dashboard/guardarestadofinanciero.php", 

          //       type:"POST", 

          //       data: data,

          //       contentType:false, 

          //       processData:false, 

          //       dataType: "json",

          //       cache:false 

          //       }).done(function(msg){  

          //         if(msg.msg){



          //           swal({   

          //             title: "Estado Financiero Guardado!",   

          //             text: "con exito",

          //             type: "success",        

          //             closeOnConfirm: true 

          //             }).then((element)=>{

          //               location.reload(); 

          //             })

          //         }else{

          //           swal({   

          //             title: "Algo ha salido mal!",   

          //             text: "Revise su conexión a internet",

          //             type: "error",        

          //             closeOnConfirm: true 

          //             }).then((element)=>{

                        

          //             });

          //         }

                

          //     });

          //     } else {

                

          //     }

          //   });

            

       

      }

  })

