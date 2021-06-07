

$("body").on("click touchstart","#btnGuardar",function(e){

    e.preventDefault();

    if($("#excel").val()!=""){

      var formu = document.getElementById("frmGuardar");



      var data = new FormData(formu);

      $.ajax({

      url:URL+"functions/dashboard/leerbalancegeneral.php", 

      type:"POST", 

      data: data, 

      contentType:false, 

      processData:false, 

      dataType: "json",

      cache:false

      }).done(function(msg){  



        console.log(msg)

        $(".cabecera h4").html(msg.cabecera.titulo); 

        $(".fecha").html(msg.cabecera.fecha); 

        $("[name='datos[titulo]']").val(msg.cabecera.titulo); 

        $("[name='datos[subtitulo]']").val(msg.cabecera.fecha); 

        var sHtml=""; 

        var item=-1; 

        var cuenta=-1; 

        var valorCuenta=""; 

        msg.info.forEach(function(element,index){

          var clase=""; 

          if(element.utilidad==1){clase="negrita"}

          if(element.equivalencia==null){element.equivalencia=0}



          

          // +"<td class='tddashboard'>"

          // +"<input type='hidden' name='item["+index+"][cuenta]' id='item["+index+"][cuenta]' value='"+element.cuenta+"'/>"

          // +"<input type='hidden' name='item["+index+"][valor]' id='item["+index+"][valor]' value="+element.valor+"/>"

          // +"<input type='hidden' name='item["+index+"][porcentaje]' id='item["+index+"][porcentaje]' value="+element.equivalencia+"/>"

          // +element.cuenta+"</td>"

          if(element.tipo==1||element.tipo==2){

            item++; 

            sHtml+="<tr>";

            sHtml+="<td class='tddashboard negrita centrar' colspan='5'>"

            +"<input type='hidden' name='item["+item+"][nombre]' id='item["+item+"][nombre]' value='"+element.titulo+"'/>"

            +"<input type='hidden' name='item["+item+"][tipo]' id='item["+item+"][tipo]' value='"+element.tipo+"'/>"

            +element.titulo+"</td>"; 

            sHtml+="</tr>";

          }else if(element.tipo==4){

            cuenta++; 

            valorCuenta=element.cuenta; 

            sHtml+="<tr class='negrita'>";

            sHtml+="<td class='tddashboard' style='width:5%'>"

            +"<input type='hidden' name='cuenta["+item+"]["+cuenta+"][nroCuenta]' id='item["+item+"][nroCuenta]' value='"+element.cuenta+"'/>"

            +"<input type='hidden' name='cuenta["+item+"]["+cuenta+"][cuenta]' id='item["+item+"][cuenta]' value='"+element.titulo+"'/>"

            +"<input type='hidden' name='cuenta["+item+"]["+cuenta+"][total]' id='item["+item+"][total]' value='"+element.total+"'/>"

            +"<input type='hidden' name='cuenta["+item+"]["+cuenta+"][porcentaje]' id='item["+item+"][porcentaje]' value='"+parseFloat(element.porcentaje).toFixed(8)+"'/>"

            +"<input type='hidden' name='cuenta["+item+"]["+cuenta+"][tipo]' id='item["+item+"][tipo]' value='"+element.tipo+"'/>"

            +element.cuenta+"</td>"; 

            sHtml+="<td class='tddashboard'>"+element.titulo+"</td>"; 

            sHtml+="<td class='tddashboard'></td>"; 

            sHtml+="<td class='tddashboard'>"+element.total+"</td>"; 

            sHtml+="<td class='tddashboard'>"+parseFloat(element.porcentaje).toFixed(8)+"</td>"; 

            sHtml+="</tr>";

          }else if(element.tipo==3){

            item++; 

            sHtml+="<tr class='negrita'>";

            sHtml+="<td class='tddashboard' style='width:5%'>"

            +"<input type='hidden' name='item["+item+"][nombre]' id='item["+item+"][nombre]' value='"+element.titulo+"'/>"

            +"<input type='hidden' name='item["+item+"][tipo]' id='item["+item+"][tipo]' value='"+element.tipo+"'/>"

            +"<input type='hidden' name='item["+item+"][total]' id='item["+item+"][total]' value='"+element.total+"'/>"

            +"<input type='hidden' name='item["+item+"][porcentaje]' id='item["+item+"][porcentaje]' value='"+parseFloat(element.porcentaje).toFixed(8)+"'/>"

            +"</td>"; 

            sHtml+="<td class='tddashboard'>"+element.titulo+"</td>"; 

            sHtml+="<td class='tddashboard'></td>"; 

            sHtml+="<td class='tddashboard'>"+element.total+"</td>"; 

            sHtml+="<td class='tddashboard'>"+parseFloat(element.porcentaje).toFixed(2)+"</td>"; 

            sHtml+="</tr>";

          }else{

            cuenta++; 

            sHtml+="<tr>";

            sHtml+="<td class='tddashboard' style='width:5%'>"

            +"<input type='hidden' name='cuenta["+item+"]["+cuenta+"][nroCuenta]' id='item["+item+"][nroCuenta]' value='"+element.cuenta+"'/>"

            +"<input type='hidden' name='cuenta["+item+"]["+cuenta+"][cuenta]' id='item["+item+"][cuenta]' value='"+element.titulo+"'/>"

            +"<input type='hidden' name='cuenta["+item+"]["+cuenta+"][total]' id='item["+item+"][total]' value='"+element.total+"'/>"

            +"<input type='hidden' name='cuenta["+item+"]["+cuenta+"][posicion]' id='item["+item+"][posicion]' value='"+valorCuenta+"'/>"

            +"<input type='hidden' name='cuenta["+item+"]["+cuenta+"][tipo]' id='item["+item+"][tipo]' value='"+element.tipo+"'/>"

            +element.cuenta+"</td>"; 

            sHtml+="<td class='tddashboard'>"+element.titulo+"</td>"; 

            sHtml+="<td class='tddashboard'>"+element.total+"</td>"; 

            sHtml+="<td class='tddashboard'></td>"; 

            sHtml+="<td class='tddashboard'></td>"; 

            sHtml+="</tr>";

          }

        })



        $("#balanceGral tbody").html(sHtml)

        $(".balanceGral").removeClass("ocultar");

    });

    }

    

})



$("body").on("click touchstart","#btnGuardarInfo",function(e){

    e.preventDefault();

      if(true === $("#frmGuardar").parsley().validate()){

          Swal.fire({

        title: 'Está seguro?',

        text: 'Está a punto de guardar este balance general!',

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

            url:URL+"functions/dashboard/guardarbalancegeneral.php", 

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

                  title: 'Balance General Guardado!',

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

        //   url:URL+"functions/dashboard/guardarbalancegeneral.php", 

        //   type:"POST", 

        //   data: data,

        //   contentType:false, 

        //   processData:false, 

        //   dataType: "json",

        //   cache:false 

        //   }).done(function(msg){  

        //     if(msg.msg){

        //       Swal.fire(

        //         {

        //         icon: 'success',

        //         title: 'Balance General Guardado!',

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

          //   text: 'Está a punto de guardar este balance general!',

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

          //       url:URL+"functions/dashboard/guardarbalancegeneral.php", 

          //       type:"POST", 

          //       data: data,

          //       contentType:false, 

          //       processData:false, 

          //       dataType: "json",

          //       cache:false 

          //       }).done(function(msg){  

          //         if(msg.msg){



          //           swal({   

          //             title: "Balance General Guardado!",   

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

