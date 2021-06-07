$(document).ready(function(e){

      smallchart1();

      smallchart2();

      smallchart3();

      smallchart4();

      getMorris('line_chart');
      dataTable("#tableEnterprise"); 

})

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


// $("body").on("click","#enviar",function(e){

//   $.ajax({

//       url:URL+"functions/generales/enviarcorreo.php", 

//       type:"POST", 

//       dataType: "json",

//       }).done(function(msg){  

//         console.log("correo enviado")

//       })

// })

function getMorris(element) {

      

      $.ajax({

      url:URL+"functions/dashboard/dashboardadmin.php", 

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

function smallchart1() {

  var balance_chart = document.getElementById("smallChart1").getContext("2d");



  var balance_chart_bg_color = balance_chart.createLinearGradient(0, 0, 0, 70);

  balance_chart_bg_color.addColorStop(0, "rgba(156,39,176,.2)");

  balance_chart_bg_color.addColorStop(1, "rgba(156,39,176,0)");



  var myChart = new Chart(balance_chart, {

    type: "line",

    data: {

      labels: [

        "16-07-2018",

        "17-07-2018",

        "18-07-2018",

        "19-07-2018",

        "20-07-2018",

        "21-07-2018",

        "22-07-2018",

        "23-07-2018",

        "24-07-2018",

        "25-07-2018",

        "26-07-2018",

        "27-07-2018",

        "28-07-2018",

        "29-07-2018",

        "30-07-2018",

        "31-07-2018",

      ],

      datasets: [

        {

          label: "Balance",

          data: [

            50,

            61,

            80,

            50,

            72,

            52,

            60,

            41,

            30,

            45,

            70,

            40,

            93,

            63,

            50,

            62,

          ],

          backgroundColor: balance_chart_bg_color,

          borderWidth: 3,

          borderColor: "#9c27b0 ",

          pointBorderWidth: 0,

          pointBorderColor: "transparent",

          pointRadius: 3,

          pointBackgroundColor: "transparent",

          pointHoverBackgroundColor: "rgba(63,82,227,1)",

        },

      ],

    },

    options: {

      layout: {

        padding: {

          bottom: -1,

          left: -1,

        },

      },

      legend: {

        display: false,

      },

      scales: {

        yAxes: [

          {

            gridLines: {

              display: false,

              drawBorder: false,

            },

            ticks: {

              beginAtZero: true,

              display: false,

            },

          },

        ],

        xAxes: [

          {

            gridLines: {

              drawBorder: false,

              display: false,

            },

            ticks: {

              display: false,

            },

          },

        ],

      },

    },

  });

}



function smallchart2() {

  var balance_chart = document.getElementById("smallChart2").getContext("2d");



  var balance_chart_bg_color = balance_chart.createLinearGradient(0, 0, 0, 70);

  balance_chart_bg_color.addColorStop(0, "rgba(255,87,34,.2)");

  balance_chart_bg_color.addColorStop(1, "rgba(255,87,34,0)");



  var myChart = new Chart(balance_chart, {

    type: "line",

    data: {

      labels: [

        "16-07-2018",

        "17-07-2018",

        "18-07-2018",

        "19-07-2018",

        "20-07-2018",

        "21-07-2018",

        "22-07-2018",

        "23-07-2018",

        "24-07-2018",

        "25-07-2018",

        "26-07-2018",

        "27-07-2018",

        "28-07-2018",

        "29-07-2018",

        "30-07-2018",

        "31-07-2018",

      ],

      datasets: [

        {

          label: "Balance",

          data: [

            50,

            61,

            80,

            50,

            72,

            52,

            60,

            41,

            30,

            45,

            70,

            40,

            93,

            63,

            50,

            62,

          ],

          backgroundColor: balance_chart_bg_color,

          borderWidth: 3,

          borderColor: "#ff9800",

          pointBorderWidth: 0,

          pointBorderColor: "transparent",

          pointRadius: 3,

          pointBackgroundColor: "transparent",

          pointHoverBackgroundColor: "rgba(63,82,227,1)",

        },

      ],

    },

    options: {

      layout: {

        padding: {

          bottom: -1,

          left: -1,

        },

      },

      legend: {

        display: false,

      },

      scales: {

        yAxes: [

          {

            gridLines: {

              display: false,

              drawBorder: false,

            },

            ticks: {

              beginAtZero: true,

              display: false,

            },

          },

        ],

        xAxes: [

          {

            gridLines: {

              drawBorder: false,

              display: false,

            },

            ticks: {

              display: false,

            },

          },

        ],

      },

    },

  });

}

function smallchart3() {

  var balance_chart = document.getElementById("smallChart3").getContext("2d");



  var balance_chart_bg_color = balance_chart.createLinearGradient(0, 0, 0, 70);

  balance_chart_bg_color.addColorStop(0, "rgba(76,175,80,.2)");

  balance_chart_bg_color.addColorStop(1, "rgba(76,175,80,0)");



  var myChart = new Chart(balance_chart, {

    type: "line",

    data: {

      labels: [

        "16-07-2018",

        "17-07-2018",

        "18-07-2018",

        "19-07-2018",

        "20-07-2018",

        "21-07-2018",

        "22-07-2018",

        "23-07-2018",

        "24-07-2018",

        "25-07-2018",

        "26-07-2018",

        "27-07-2018",

        "28-07-2018",

        "29-07-2018",

        "30-07-2018",

        "31-07-2018",

      ],

      datasets: [

        {

          label: "Balance",

          data: [

            50,

            61,

            80,

            50,

            72,

            52,

            60,

            41,

            30,

            45,

            70,

            40,

            93,

            63,

            50,

            62,

          ],

          backgroundColor: balance_chart_bg_color,

          borderWidth: 3,

          borderColor: "#4caf50",

          pointBorderWidth: 0,

          pointBorderColor: "transparent",

          pointRadius: 3,

          pointBackgroundColor: "transparent",

          pointHoverBackgroundColor: "rgba(63,82,227,1)",

        },

      ],

    },

    options: {

      layout: {

        padding: {

          bottom: -1,

          left: -1,

        },

      },

      legend: {

        display: false,

      },

      scales: {

        yAxes: [

          {

            gridLines: {

              display: false,

              drawBorder: false,

            },

            ticks: {

              beginAtZero: true,

              display: false,

            },

          },

        ],

        xAxes: [

          {

            gridLines: {

              drawBorder: false,

              display: false,

            },

            ticks: {

              display: false,

            },

          },

        ],

      },

    },

  });

}

function smallchart4() {

  var balance_chart = document.getElementById("smallChart4").getContext("2d");



  var balance_chart_bg_color = balance_chart.createLinearGradient(0, 0, 0, 70);

  balance_chart_bg_color.addColorStop(0, "rgba(63,82,227,.2)");

  balance_chart_bg_color.addColorStop(1, "rgba(63,82,227,0)");



  var myChart = new Chart(balance_chart, {

    type: "line",

    data: {

      labels: [

        "16-07-2018",

        "17-07-2018",

        "18-07-2018",

        "19-07-2018",

        "20-07-2018",

        "21-07-2018",

        "22-07-2018",

        "23-07-2018",

        "24-07-2018",

        "25-07-2018",

        "26-07-2018",

        "27-07-2018",

        "28-07-2018",

        "29-07-2018",

        "30-07-2018",

        "31-07-2018",

      ],

      datasets: [

        {

          label: "Balance",

          data: [

            50,

            61,

            80,

            50,

            72,

            52,

            60,

            41,

            30,

            45,

            70,

            40,

            93,

            63,

            50,

            62,

          ],

          backgroundColor: balance_chart_bg_color,

          borderWidth: 3,

          borderColor: "rgba(63,82,227,1)",

          pointBorderWidth: 0,

          pointBorderColor: "transparent",

          pointRadius: 3,

          pointBackgroundColor: "transparent",

          pointHoverBackgroundColor: "rgba(63,82,227,1)",

        },

      ],

    },

    options: {

      layout: {

        padding: {

          bottom: -1,

          left: -1,

        },

      },

      legend: {

        display: false,

      },

      scales: {

        yAxes: [

          {

            gridLines: {

              display: false,

              drawBorder: false,

            },

            ticks: {

              beginAtZero: true,

              display: false,

            },

          },

        ],

        xAxes: [

          {

            gridLines: {

              drawBorder: false,

              display: false,

            },

            ticks: {

              display: false,

            },

          },

        ],

      },

    },

  });

}