$(document).ready(function(e){

    smallchart1()

	// $.ajax({

 //    url:URL+"functions/generales/dashboardadministrador.php", 

 //    type:"POST", 

 //    data: {"idDepartamento":id}, 

 //    dataType: "json",

 //    }).done(function(msg){  

      

 //      //$("[name='datos[idCiudad]']").html(sHtml);

 //  });

})



function smallchart1() {

  var options = {

    series: [

      {

        name: "Facturacion de venta",

        data: [81, 90, 78, 101, 92, 109, 100],

      },

      {

        name: "Facturación de compra",

        data: [70, 82, 95, 82, 84, 102, 91],

      },

    ],

    chart: {

      height: 310,

      type: "area",

      dropShadow: {

        enabled: true,

        opacity: 0.3,

        blur: 5,

        left: -7,

        top: 22,

      },

      toolbar: {

        show: false,

      },

    },

    colors: ["#9D1B69", "#25AF69"],

    dataLabels: {

      enabled: false,

    },

    stroke: {

      curve: "smooth",

    },

    xaxis: {

      axisBorder: {

        show: false,

      },

      axisTicks: {

        show: false,

      },

      crosshairs: {

        show: true,

      },

      categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug"],

      labels: {

        offsetX: 0,

        offsetY: 5,

        style: {

          fontSize: "12px",

          fontFamily: "Segoe UI",

          cssClass: "apexcharts-xaxis-title",

        },

      },

    },

    yaxis: {

      labels: {

        offsetX: 0,

        offsetY: 0,

        style: {

          fontSize: "12px",

          fontFamily: "Segoe UI",

          cssClass: "apexcharts-yaxis-title",

        },

      },

    },

    legend: {

      show: false,

    },

    tooltip: {

      theme: "dark",

      marker: {

        show: true,

      },

      x: {

        show: true,

      },

    },

  };



  var chart = new ApexCharts(document.querySelector("#schart1"), options);



  chart.render();

}



$("body").on("click touchstart","#verEFinanciero",function(e){

  $("#periodo").val($(this).attr("value")).trigger("change")

})



$("body").on("click touchstart","#verSFinanciera",function(e){

  $("#periodoSF").val($(this).attr("value")).trigger("change")

})



$("body").on("change","#periodo",function(e){

  $("#tableBalances tbody").html(''); 

    if($(this).val()!=""){

      $.ajax({

      url:URL+"functions/dashboard/verdetalleestadofinanciero.php", 

      type:"POST", 

      data: {"idEstadoFinanciero":$(this).val()}, 

      dataType: "json",

      }).done(function(msg){  

        console.log(msg)

        var sHtml=''; 

        msg[0].forEach(function(element,index){

          sHtml+='<tr>'+

                '<td>'+(index+1)+'</td>'+

                '<td>'+element.cuenta+'</td>'+

                '<td>'+element.valor+'</td>'+

                '<td class="centrar">'+element.porcentaje+'</td>'+

                '</tr>'; 

        })



        $("#tableBalances tbody").append(sHtml); 

        //$("[name='datos[idCiudad]']").html(sHtml);

    });

    }

    

})



$("body").on("change","#periodoSF",function(e){

  $("#tableSituacion tbody").html(''); 

    if($(this).val()!=""){

      $.ajax({

      url:URL+"functions/dashboard/verdetallebalancegeneral.php", 

      type:"POST", 

      data: {"idBalanceGeneral":$(this).val()}, 

      dataType: "json",

      }).done(function(msg){  

        console.log(msg)

        var sHtml=''; 

        msg[0].forEach(function(element,index){

          sHtml+='<tr>'+

                '<td>'+(index+1)+'</td>'+

                '<td>'+element.titulo+'</td>'+

                '<td>'+element.valor+'</td>'+

                '<td class="centrar">'+element.porcentaje+'</td>'+

                '</tr>'; 

        })



        $("#tableSituacion tbody").append(sHtml); 

        //$("[name='datos[idCiudad]']").html(sHtml);

    });

    }

    

})


$('[data-toggle="tooltip"]').tooltip();