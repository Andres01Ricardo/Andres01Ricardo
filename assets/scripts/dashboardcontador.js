$(document).ready(function(e){

            // getMorris('line_chart');
            dataTable("#tableEnterprise"); 

})



function getMorris(element) {

      

      $.ajax({

      url:URL+"functions/dashboard/dashboardcontador.php", 

      type:"POST", 

      dataType: "json",

      }).done(function(msg){  

        console.log(msg)

        var  aData=[]; 

        msg.facturacion.forEach(function(element,index){

          aData.push({

            period: element.periodo,

            iphone: element.compra,

            ipad: element.venta,

          })

        })



        setTimeout(function(e){

          Morris.Line({

            element: element,

            data: aData,

            xkey: 'period',

            ykeys: ['iphone', 'ipad'],

            labels: ['Facuración Compra', 'Facturación Venta'],

            pointSize: 3,

            fillOpacity: 0,

            pointStrokeColors: ['#222222', '#cccccc', '#f96332'],

            behaveLikeLine: true,

            gridLineColor: '#e0e0e0',

            lineWidth: 2,

            hideHover: 'auto',

            lineColors: ['#222222', '#20B2AA', '#f96332'],

            resize: true

        });

        },1000)

        

      });

        

    

}


$("body").on("click touchstart",".ingresar",function(e){

  var id=$(this).attr("id"); 

  var texto=$(this).parents("tr").find("td").eq(3).html(); 

  Swal.fire({

          title: 'Está seguro?',

          text: 'Está a punto de ingresar al perfil de '+texto+'!',

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