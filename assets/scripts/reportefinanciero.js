$(function () {

  graphFinanciero();

 

});



graphFinanciero=function(){
  $.ajax({

      url:URL+"functions/dashboard/facturaVentaAcumulada.php", 

      type:"POST", 

      dataType: "json",

      }).done(function(msg){ 



        var aVenta=[]; 
        

        var aLabels=[]; 
        console.log(msg.facturaCompraSumada);
           



          msg.facturaVentaSumada.forEach(function(element,index){
            console.log(element.valor);
            // aCompra.push(parseInt(element.facturaCompraSumada.valor));

            aVenta.push(parseInt(element.valor));
            // var mesLabel=element.mes;
           
            aLabels.push(element.periodoAnio+'-'+element.periodoMes);

          });
          var aCompras=[]; 
          msg.facturaCompraSumada.forEach(function(element,index){
            console.log(element.valor);
            // aCompra.push(parseInt(element.facturaCompraSumada.valor));

            aCompras.push(parseInt(element.valor));
            // var mesLabel=element.mes;
           
            // aLabels.push(element.periodoAnio+'-'+element.periodoMes);

          });
          var aGastos=[]; 
          msg.gastosOperacionales.forEach(function(element,index){
            console.log(element.valor);
            // aCompra.push(parseInt(element.facturaCompraSumada.valor));

            aGastos.push(parseInt(element.valor));
            // var mesLabel=element.mes;
           
            // aLabels.push(element.periodoAnio+'-'+element.periodoMes);

          });
          var aGastosVentas=[]; 
          msg.gastosOperacionalesVentas.forEach(function(element,index){
            console.log(element.valor);
            // aCompra.push(parseInt(element.facturaCompraSumada.valor));

            aGastosVentas.push(parseInt(element.valor));
            // var mesLabel=element.mes;
           
            // aLabels.push(element.periodoAnio+'-'+element.periodoMes);

          });
          console.log(aCompras);
        

                  

                



var options2 = {

    series: [

      {

        name: "Ventas",

        data: aVenta,

      },

      {

        name: "Compras ",

        data: aCompras,

      },
      {

        name: "Gastos operacionales de admon",

        data: aGastos,

      },
      {

        name: "Gastos operacionales de ventas",

        data: aGastosVentas,

      },

    ],

    chart: {

      height: 300,

      type: "line",

      dropShadow: {

        enabled: true,

        opacity: 0.3,

        blur: 5,

        left: -7,

        top: 22,

      },

      toolbar: {

        show: true,

      },

    },

    colors: ["#6777EF", "#FEB019","#8BFFC1","#EF8BFF"],

    dataLabels: {

      enabled: false,

    },

    stroke: {

      show: true,

      curve: "smooth",

      width: 3,

      lineCap: "square",

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

      categories: aLabels,

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
      y: {

                    formatter: function (val) {

                                            

                        return "$ " + format((val*1));

                    }

                }

    },

  };



  var chart3 = new ApexCharts(document.querySelector("#facturacion"), options2);

  chart3.render();

})


	$.ajax({

	    url:URL+"functions/dashboard/dashboardempresa.php", 

	    type:"POST", 

	    dataType: "json",

	    }).done(function(msg){  

		// console.log(msg);
	      $("#totalActivoCorriente").html(parseFloat(msg.indicador.totalActivoCorriente).toFixed(2)); 

	      $("#totalPasivoCorriente").html(parseFloat(msg.indicador.totalPasivoCorriente).toFixed(2)); 


	      $("#activo").html(parseFloat(msg.indicador.activo).toFixed(2)); 

	      $("#pasivo").html(parseFloat(msg.indicador.pasivo).toFixed(2)); 

	      $("#utilidadOperacional").html(parseFloat(msg.indicador.utilidadOperacional).toFixed(2)); 

	      $("#totalPatrimonio").html(parseFloat(msg.indicador.totalPatrimonio).toFixed(2)); 

	      $("#totalActivo").html(parseFloat(msg.indicador.totalActivo).toFixed(2)); 

	      $("#totalPatrimonioA").html(parseFloat(msg.indicador.totalPatrimonio).toFixed(2));

	      $("#totalActivoCorrienteC").html(parseFloat(msg.indicador.totalActivoCorriente).toFixed(2)); 

	      $("#totalPasivoCorrienteC").html(parseFloat(msg.indicador.totalPasivoCorriente).toFixed(2)); 
	      


	      $("#indicadorLiquidez").html(parseFloat(msg.indicador.indiceLiquidez).toFixed(2)); 

	      $("#indicadorSolidez").html(parseFloat(msg.indicador.solidez).toFixed(2)); 

	      $("#capitalTrabajo").html(msg.indicador.capitalTrabajo); 

	      $("#rentabilidadPatrimonio").html(parseFloat(msg.indicador.rentabilidadPatrimonio).toFixed(5)); 

	      $("#rentabilidadActivo").html(parseFloat(msg.indicador.rentabilidadActivo).toFixed(2));
        // console.log(msg.gastos);
			    	
        var  label3=[]; 
        var  datos3=[];

        if(msg.gastos!=null){

          msg.gastos.forEach(function(element,index){

          label3.push(element.periodo),

            datos3.push(element.valor)

            })

        }



   let miCanvas3 = document.getElementById("gastos").getContext("2d");
   // var label3= ['Oct-2020','Nov-2020','Dic-2020'];
   // var datos3= [5500600,3800000,1780350];

   var stackedLine = new Chart(miCanvas3, {
    type: 'line',
    data:{
      
      datasets:[{label:"GASTOS",
        data: datos3,
        borderColor:"rgb(185,84,255)",
        backgroundColor:"rgba(185,84,255,0.1)",
        
        lineTension: 0.5,
        order:1,
        pointBorderWidth:8
      }],
      labels:label3
      
    },
    
    options: {
        scales: {
            yAxes: [{
                stacked: true
            }]
        },
        tooltips: {
              callbacks: {
                  label: function(tooltipItem, data) {
                      return "$" + Number(tooltipItem.yLabel).toFixed(0).replace(/./g, function(c, i, a) {
                          return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
                      });
                  }
              }
    }
  }
  });
   var  label=[]; 
        var  datos=[];
   if(msg.ingresos!=null){

          msg.ingresos.forEach(function(element,index){

          label.push(element.periodo),

            datos.push(element.valor)

            })

        }


   let miCanvas1 = document.getElementById("ingresos").getContext("2d");
   // var label= ['Oct-2020','Nov-2020','Dic-2020'];
   // var datos= [1200600,3800000,18500400];

   var stackedLine = new Chart(miCanvas1, {
    type: 'line',
    data:{
      
      datasets:[{label:"INGRESOS",
        data: datos,
        borderColor:"rgb(84,216,255)",
        backgroundColor:"rgba(84,216,255,0.1)",
        
        lineTension: 0.5,
        order:1,
        pointBorderWidth:8
      }],
      labels:label
      
    },
    
    options: {
        scales: {
            yAxes: [{
                stacked: true
            }]
        },
        tooltips: {
              callbacks: {
                  label: function(tooltipItem, data) {
                      return "$" + Number(tooltipItem.yLabel).toFixed(0).replace(/./g, function(c, i, a) {
                          return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
                      });
                  }
              }
    }
  }
  });

	     // am4core.useTheme(am4themes_animated);
       // console.log(msg.rentabilidad);
        var  label2=[]; 
        var  datos2=[]; 

        if(msg.rentabilidad!=null){

          msg.rentabilidad.forEach(function(element,index){

          label2.push(element.periodo),

            datos2.push(element.valor)

            })

        }



let miCanvas2 = document.getElementById("utilidad").getContext("2d");
   // var label2= ['Oct-2020','Nov-2020','Dic-2020'];
   // var datos2= [1200600,3800000,18500400];

   var stackedLine = new Chart(miCanvas2, {
    type: 'line',
    data:{
      
      datasets:[{label:"UTILIDAD",
        data: datos2,
        borderColor:"rgb(84,255,198)",
        backgroundColor:"rgba(84,255,198,0.1)",
        
        lineTension: 0.5,
        order:1,
        pointBorderWidth:8
      }],
      labels:label2
      
    },
    
    options: {
        scales: {
            yAxes: [{
                stacked: true
            }]
        },
        tooltips: {
              callbacks: {
                  label: function(tooltipItem, data) {
                      return "$" + Number(tooltipItem.yLabel).toFixed(0).replace(/./g, function(c, i, a) {
                          return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
                      });
                  }
              }
    }
  }
  });

       am4core.useTheme(am4themes_animated);

        var  aData=[]; 

        if(msg.rentabilidad!=null){

          msg.rentabilidad.forEach(function(element,index){

          aData.push({

            "country": element.periodo,

            "visits": element.valor

          })

            })

        }

        

      


// am4core.ready(function() {

// // Themes begin
// am4core.useTheme(am4themes_animated);
// // Themes end

// // Create chart instance
// var chart = am4core.create("utilidad", am4charts.XYChart);

// // Add data
// // chart.data = aData;
// chart.data = aData;

// // Set input format for the dates
// chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

// // Create axes
// var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
// var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// // Create series
// var series = chart.series.push(new am4charts.LineSeries());
// series.dataFields.valueY = "country";
// series.dataFields.dateX = "visits";
// series.tooltipText = "{value}"
// series.strokeWidth = 2;
// series.minBulletDistance = 15;

// // Drop-shaped tooltips
// series.tooltip.background.cornerRadius = 20;
// series.tooltip.background.strokeOpacity = 0;
// series.tooltip.pointerOrientation = "vertical";
// series.tooltip.label.minWidth = 40;
// series.tooltip.label.minHeight = 40;
// series.tooltip.label.textAlign = "middle";
// series.tooltip.label.textValign = "middle";

// // Make bullets grow on hover
// var bullet = series.bullets.push(new am4charts.CircleBullet());
// bullet.circle.strokeWidth = 2;
// bullet.circle.radius = 4;
// bullet.circle.fill = am4core.color("#fff");

// var bullethover = bullet.states.create("hover");
// bullethover.properties.scale = 1.3;

// // Make a panning cursor
// chart.cursor = new am4charts.XYCursor();
// chart.cursor.behavior = "panXY";
// chart.cursor.xAxis = dateAxis;
// chart.cursor.snapToSeries = series;

// Create vertical scrollbar and place it before the value axis
// chart.scrollbarY = new am4core.Scrollbar();
// chart.scrollbarY.parent = chart.leftAxesContainer;
// chart.scrollbarY.toBack();

// // Create a horizontal scrollbar with previe and place it underneath the date axis
// chart.scrollbarX = new am4charts.XYChartScrollbar();
// chart.scrollbarX.series.push(series);
// chart.scrollbarX.parent = chart.bottomAxesContainer;

// dateAxis.start = 0.79;
// dateAxis.keepSelection = true;


// }); // end am4core.ready()
   //    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());

   //    categoryAxis.dataFields.category = "country";

   //    categoryAxis.renderer.grid.template.location = 0;

   //    categoryAxis.renderer.minGridDistance = 30;

   //    categoryAxis.renderer.labels.template.horizontalCenter = "right";

   //    categoryAxis.renderer.labels.template.verticalCenter = "middle";

   //    categoryAxis.renderer.labels.template.rotation = 270;

   //    categoryAxis.tooltip.disabled = true;

   //    categoryAxis.renderer.minHeight = 110;

   //    categoryAxis.renderer.labels.template.fill = am4core.color("#8e8da4");



   //    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

   //    valueAxis.renderer.minWidth = 50;

   //    valueAxis.renderer.labels.template.fill = am4core.color("#8e8da4");


   //    var series = chart.series.push(new am4charts.ColumnSeries());

   //    series.sequencedInterpolation = true;

   //    series.dataFields.valueY = "visits";

   //    series.dataFields.categoryX = "country";

   //    series.tooltipText = "[{categoryX}: bold]{valueY}[/]";

   //    series.columns.template.strokeWidth = 0;





   //    series.tooltip.pointerOrientation = "vertical";



   //    series.columns.template.column.cornerRadiusTopLeft = 10;

   //    series.columns.template.column.cornerRadiusTopRight = 10;

   //    series.columns.template.column.fillOpacity = 0.8;



   //  let hoverState = series.columns.template.column.states.create("hover");

   //    hoverState.properties.cornerRadiusTopLeft = 0;

   //    hoverState.properties.cornerRadiusTopRight = 0;

   //    hoverState.properties.fillOpacity = 1;


 		// series.columns.template.adapter.add("fill", (fill, target) => {

   //      return chart.colors.getIndex(target.dataItem.index);

   //    	});


      // chart.cursor = new am4charts.XYCursor();

      var aActivo=[]; 

      var aPasivo=[]; 

      var aPatrimonio=[];

      var aLabel=[]; 
      
      if(msg.situacion!=null){

          msg.situacion.forEach(function(element,index){

          aActivo.push(element.activo);

          aPasivo.push(element.pasivo);

          aPatrimonio.push(element.patrimonio);

          aLabel.push(element.periodo);

          })};

          var options = {
          series: [{

                name: 'TOTAL ACTIVO',

                data: aActivo

            }, {

                name: 'TOTAL PASIVO',

                data: aPasivo

            }, {

                name: 'TOTAL PATRIMONIO',

                data: aPatrimonio

            }],
          chart: {
          height: 350,
          type: 'line',
          // dropShadow: {
          //   enabled: true,
          //   color: '#000',
          //   top: 18,
          //   left: 7,
          //   blur: 10,
          //   opacity: 0.2
          // },
          toolbar: {
            show: false
          }
        },
        colors: ['#77B6EA', '#545454','#FFEE8F'],
        dataLabels: {
          enabled: false,
        },
        stroke: {
          curve: 'smooth'
        },
       
        grid: {
          borderColor: '#e7e7e7',
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
          padding:{
            right:40,
            left:10
          },
          position:'back'
        },
        markers: {
          size: 10
        },
        xaxis: {
          categories: aLabel,
          labels: {

              style: {

                  colors: '#8e8da4',

              }

          },
          title: {
            text: 'Meses'
          }
        },
       
        // yaxis: {
        //   title: {
        //     text: 'Temperature'
        //   },
        //   min: 5,
        //   max: 40
        // },
        yaxis: {

                title: {

                    text: '$ (Millones)'

                },

                labels: {

                    style: {

                        color: '#8e8da4',

                    }

                }

            },
        legend: {
          position: 'top',
          horizontalAlign: 'right',
          floating: true,
          offsetY: -25,
          offsetX: -5
        },
        tooltip: {
              theme: "dark",

      marker: {

        show: true,

      },

                y: {

                    formatter: function (val) {

                                            

                        return "$ " + format((val*1));

                    }

                }

            }
        };

        // var chart2 = new ApexCharts(document.querySelector("#chart"), options);
         var chart2 = new ApexCharts( document.querySelector("#situacion"),options);
        chart2.render();

    // var aCompra=[]; 

    //     var aVenta=[]; 

    //     var aLabels=[]; 

    //     if(msg.facturacion!=null){

    //       msg.facturacion.forEach(function(element,index){

    //         aCompra.push(element.compra);

    //         aVenta.push(element.venta);

    //         aLabels.push(element.periodo)

    //       })

    //     }

    // var options2 = {

    //         chart: {

    //             height: 350,

    //             type: 'line',

    //         },

    //         series: [{

    //             name: 'Facturación Compra',

    //             type: 'column',

    //             data: aCompra

    //         }, {

    //             name: 'Facturación Venta',

    //             type: 'line',

    //             data: aVenta

    //         }],

    //         stroke: {

    //             width: [0, 4]

    //         },

    //         // labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],

    //         labels: aLabels,

    //         xaxis: {

    //             type: 'category',

    //             labels: {

    //               style: {

    //                     colors: '#8e8da4',

    //                 }

    //             }

    //         },

    //         yaxis: [{

    //             title: {

    //                 text: 'Facturación Compra',

    //             },

    //             labels: {

    //                 style: {

    //                     color: '#8e8da4',

    //                 }

    //             }



    //         }, {

    //             opposite: true,

    //             title: {

    //                 text: 'Facturación Venta'

    //             },

    //             labels: {

    //                 style: {

    //                     color: '#8e8da4',

    //                 }

    //             }

    //         }]

    //     }

    // var chart3 = new ApexCharts(

    //         document.querySelector("#facturacion"),

    //         options2

    //     );


    // chart3.render();



      //   am4core.useTheme(am4themes_animated);

      // var chart4 = am4core.create("gaugeChart", am4charts.RadarChart);

      // console.log(msg.indicador); 

      var nivel=0; 

if(msg.indicador!=null){

        nivel=msg.indicador.nivelEndeudamiento; 

      }


      $("#nivelEndeudamiento").html(nivel+"%");
      // Add data

//       chart4.data = [{

//         "category": "Nivel Endeudamiento",

//         "value": nivel,

//         "full": 100

//        },    

//       ];




//       chart4.startAngle = -90;

//       chart4.endAngle = 180;

//       chart4.innerRadius = am4core.percent(20);

//       chart4.numberFormatter.numberFormat = "#.#'%'";

//       var categoryAxis = chart4.yAxes.push(new am4charts.CategoryAxis());

//       categoryAxis.dataFields.category = "category";

//       categoryAxis.renderer.grid.template.location = 0;

//       categoryAxis.renderer.grid.template.strokeOpacity = 0;

//       categoryAxis.renderer.labels.template.horizontalCenter = "right";

//       categoryAxis.renderer.labels.template.fontWeight = 500;

//       categoryAxis.renderer.labels.template.adapter.add("fill", function (fill, target) {

//         return (target.dataItem.index >= 0) ? chart.colors.getIndex(target.dataItem.index) : fill;

//       });

// categoryAxis.renderer.minGridDistance = 10;



//       var valueAxis = chart4.xAxes.push(new am4charts.ValueAxis());

//       valueAxis.renderer.grid.template.strokeOpacity = 0;

//       valueAxis.min = 0;

//       valueAxis.max = 100;

//       valueAxis.strictMinMax = true;

//       valueAxis.renderer.labels.template.fill = am4core.color("#8e8da4");


//       var series1 = chart4.series.push(new am4charts.RadarColumnSeries());

//       series1.dataFields.valueX = "full";

//       series1.dataFields.categoryY = "category";

//       series1.clustered = false;

//       series1.columns.template.fill = new am4core.InterfaceColorSet().getFor("alternativeBackground");

//       series1.columns.template.fillOpacity = 0.08;

//       series1.columns.template.cornerRadiusTopLeft = 20;

//       series1.columns.template.strokeWidth = 0;

//       series1.columns.template.radarColumn.cornerRadius = 20;



//       var series2 = chart4.series.push(new am4charts.RadarColumnSeries());

//       series2.dataFields.valueX = "value";

//       series2.dataFields.categoryY = "category";

//       series2.clustered = false;

//       series2.columns.template.strokeWidth = 0;

//       series2.columns.template.tooltipText = "{category}: [bold]{value}[/]";

//       series2.columns.template.radarColumn.cornerRadius = 20;



//       series2.columns.template.adapter.add("fill", function (fill, target) {

//         return chart.colors.getIndex(target.dataItem.index);

//       });


//       chart4.cursor = new am4charts.RadarCursor();


//       am4core.useTheme(am4themes_animated);



// var draw = Chart.controllers.line.prototype.draw;

// Chart.controllers.lineShadow = Chart.controllers.line.extend({

//   draw: function () {

//     draw.apply(this, arguments);

//     var ctx = this.chart.chart.ctx;

//     var _stroke = ctx.stroke;

//     ctx.stroke = function () {

//       ctx.save();

//       ctx.shadowColor = "#00000075";

//       ctx.shadowBlur = 10;

//       ctx.shadowOffsetX = 8;

//       ctx.shadowOffsetY = 8;

//       _stroke.apply(this, arguments);

//       ctx.restore();

//     };

//   },

// }); 


 var  aIndiceLiquidezAcumulado=[]; 
        for (var key in msg.liquidezAcumulado) {
          aIndiceLiquidezAcumulado.push(key);
      }
          // console.log(aIndiceLiquidezAcumulado);


        // console.log('probando los value');
        var  aIndiceLiquidezAcumuladoValues=[]; 
        for (var key in msg.liquidezAcumulado) {
          aIndiceLiquidezAcumuladoValues.push(msg.liquidezAcumulado[key]);
      }
          // console.log(aIndiceLiquidezAcumuladoValues);



// var aLabelsIndiceLiquidez=aIndiceLiquidezAcumulado;
// var aDataIndiceLiquidez=aIndiceLiquidezAcumuladoValues;

var aLabelsIndiceLiquidez=['5','6','7','8','9','10'];
var aDataIndiceLiquidez=[1.24,1.26,1.25,1.25,1.26,1.26];



var ctx = document.getElementById("cardChart1").getContext("2d");

var gradientStroke2 = ctx.createLinearGradient(0, 0, 700, 0);

gradientStroke2.addColorStop(0, "rgba(255, 204, 128, 1)");

gradientStroke2.addColorStop(0.5, "rgba(255, 152, 0, 1)");

gradientStroke2.addColorStop(1, "rgba(239, 108, 0, 1)");


var myChart = new Chart(ctx, {

  type: "line",

  data: {

    labels: aLabelsIndiceLiquidez,

    type: "line",

    datasets: [

      {

        label: "Income",

        data: aDataIndiceLiquidez,

        borderColor: gradientStroke2,

        pointBorderColor: gradientStroke2,

        pointBackgroundColor: gradientStroke2,

        pointHoverBackgroundColor: gradientStroke2,

        pointHoverBorderColor: gradientStroke2,

        pointBorderWidth: 5,

        pointHoverRadius: 5,

        pointHoverBorderWidth: 1,

        pointRadius: 0.5,

        fill: false,

        borderWidth: 4,

      },

    ],

  },

  options: {

    legend: {

      display: false,

    },

    tooltips: {},

    scales: {

      yAxes: [

        {

          ticks: {

            display: false, //this will remove only the label

          },

          gridLines: {

            display: false,

            drawBorder: false,

          },

        },

      ],

      xAxes: [

        {

          gridLines: {

            display: false,

            drawBorder: false,

          },

          ticks: {

            display: false, //this will remove only the label

          },

        },

      ],

    },

  },

});


// console.log(msg.solidezAcumulado);


// var  aSolidezAcumulado=[]; 
//         for (var key in msg.solidezAcumulado) {
//           aSolidezAcumulado.push(key);
//       }
//           console.log(aSolidezAcumulado);


        
//         var  aSolidezAcumuladoValues=[]; 
//         for (var key in msg.solidezAcumulado) {
//           aSolidezAcumuladoValues.push(msg.solidezAcumulado[key]);
//       }
//           console.log(aSolidezAcumuladoValues);



// var aLabelsSolidez=aSolidezAcumulado;
// var aDataSolidez=aSolidezAcumuladoValues;

var ctx = document.getElementById("cardChart2").getContext("2d");

var gradientStroke2 = ctx.createLinearGradient(500, 0, 0, 0);

gradientStroke2.addColorStop(0, "rgba(55, 154, 80, 1)");

gradientStroke2.addColorStop(1, "rgba(131, 210, 151, 1)");



var myChart = new Chart(ctx, {

  type: "line",

  data: {

    labels: ["2010", "2011", "2012", "2013", "2014", "2015", "2016"],

    type: "line",

    datasets: [

      {

        label: "Income",

        data: [60, 100, 50, 15, 110, 33, 20],

        borderColor: gradientStroke2,

        pointBorderColor: gradientStroke2,

        pointBackgroundColor: gradientStroke2,

        pointHoverBackgroundColor: gradientStroke2,

        pointHoverBorderColor: gradientStroke2,

        pointBorderWidth: 5,

        pointHoverRadius: 5,

        pointHoverBorderWidth: 1,

        pointRadius: 0.5,

        fill: false,

        borderWidth: 4,

      },

    ],

  },

  options: {

    legend: {

      display: false,

    },

    tooltips: {},

    scales: {

      yAxes: [

        {

          ticks: {

            display: false, //this will remove only the label

          },

          gridLines: {

            display: false,

            drawBorder: false,

          },

        },

      ],

      xAxes: [

        {

          gridLines: {

            display: false,

            drawBorder: false,

          },

          ticks: {

            display: false, //this will remove only the label

          },

        },

      ],

    },

  },

});
// ----

var ctx = document.getElementById("cardChart3").getContext("2d");

var gradientStroke2 = ctx.createLinearGradient(0, 0, 700, 0);

gradientStroke2.addColorStop(0, "rgba(103, 119, 239, 1)");

gradientStroke2.addColorStop(0.5, "rgba(106, 120, 220, 1)");

gradientStroke2.addColorStop(1, "rgba(92, 103, 187, 1)");



var myChart = new Chart(ctx, {

  type: "line",

  data: {

    labels: ["2010", "2011", "2012", "2013", "2014", "2015", "2016"],

    type: "line",

    datasets: [

      {

        label: "Income",

        data: [0, 30, 10, 120, 50, 63, 10],

        borderColor: gradientStroke2,

        pointBorderColor: gradientStroke2,

        pointBackgroundColor: gradientStroke2,

        pointHoverBackgroundColor: gradientStroke2,

        pointHoverBorderColor: gradientStroke2,

        pointBorderWidth: 5,

        pointHoverRadius: 5,

        pointHoverBorderWidth: 1,

        pointRadius: 0.5,

        fill: false,

        borderWidth: 4,

      },

    ],

  },

  options: {

    legend: {

      display: false,

    },

    tooltips: {},

    scales: {

      yAxes: [

        {

          ticks: {

            display: false, //this will remove only the label

          },

          gridLines: {

            display: false,

            drawBorder: false,

          },

        },

      ],

      xAxes: [

        {

          gridLines: {

            display: false,

            drawBorder: false,

          },

          ticks: {

            display: false, //this will remove only the label

          },

        },

      ],

    },

  },

});




var ctx = document.getElementById("cardChart4").getContext("2d");

var gradientStroke2 = ctx.createLinearGradient(0, 0, 700, 0);

gradientStroke2.addColorStop(0, "rgba(61, 199, 190, 1)");

gradientStroke2.addColorStop(0.5, "rgba(57, 171, 163, 1)");

gradientStroke2.addColorStop(1, "rgba(40, 142, 135, 1)");



var myChart = new Chart(ctx, {

  type: "line",

  data: {

    labels: ["2010", "2011", "2012", "2013", "2014", "2015", "2016"],

    type: "line",

    datasets: [

      {

        label: "Income",

        data: [110, 90, 10, 38, 10, 90,],

        borderColor: gradientStroke2,

        pointBorderColor: gradientStroke2,

        pointBackgroundColor: gradientStroke2,

        pointHoverBackgroundColor: gradientStroke2,

        pointHoverBorderColor: gradientStroke2,

        pointBorderWidth: 5,

        pointHoverRadius: 5,

        pointHoverBorderWidth: 1,

        pointRadius: 0.5,

        fill: false,

        borderWidth: 4,

      },

    ],

  },

  options: {

    legend: {

      display: false,

    },

    tooltips: {},

    scales: {

      yAxes: [

        {

          ticks: {

            display: false, //this will remove only the label

          },

          gridLines: {

            display: false,

            drawBorder: false,

          },

        },

      ],

      xAxes: [

        {

          gridLines: {

            display: false,

            drawBorder: false,

          },

          ticks: {

            display: false, //this will remove only the label

          },

        },

      ],

    },

  },

});
var ctx = document.getElementById("cardChart5").getContext("2d");

var gradientStroke2 = ctx.createLinearGradient(0, 0, 700, 0);

gradientStroke2.addColorStop(0, "rgba(135, 167, 236, 1)");

gradientStroke2.addColorStop(0.5, "rgba(81, 132, 241, 1)");

gradientStroke2.addColorStop(1, "rgba(25, 94, 242, 1)");



var myChart = new Chart(ctx, {

  type: "line",

  data: {

    labels: ["2010", "2011", "2012", "2013", "2014", "2015", "2016"],

    type: "line",

    datasets: [

      {

        label: "Income",

        data: [90, 10, 60, 75, 100, 32,],

        borderColor: gradientStroke2,

        pointBorderColor: gradientStroke2,

        pointBackgroundColor: gradientStroke2,

        pointHoverBackgroundColor: gradientStroke2,

        pointHoverBorderColor: gradientStroke2,

        pointBorderWidth: 5,

        pointHoverRadius: 5,

        pointHoverBorderWidth: 1,

        pointRadius: 0.5,

        fill: false,

        borderWidth: 4,

      },

    ],

  },

  options: {

    legend: {

      display: false,

    },

    tooltips: {},

    scales: {

      yAxes: [

        {

          ticks: {

            display: false, //this will remove only the label

          },

          gridLines: {

            display: false,

            drawBorder: false,

          },

        },

      ],

      xAxes: [

        {

          gridLines: {

            display: false,

            drawBorder: false,

          },

          ticks: {

            display: false, //this will remove only the label

          },

        },

      ],

    },

  },

});
var ctx = document.getElementById("cardChart6").getContext("2d");

var gradientStroke2 = ctx.createLinearGradient(0, 0, 700, 0);

gradientStroke2.addColorStop(0, "rgba(247, 146, 146, 1)");

gradientStroke2.addColorStop(0.5, "rgba(253, 94, 94, 1)");

gradientStroke2.addColorStop(1, "rgba(216, 29, 29, 1)");
var myChart = new Chart(ctx, {

  type: "line",

  data: {

    labels: ["2010", "2011", "2012", "2013", "2014", "2015", "2016"],

    type: "line",

    datasets: [

      {

        label: "Income",

        data: [93, 95, 94, 94, 93, 94,94],

        borderColor: gradientStroke2,

        pointBorderColor: gradientStroke2,

        pointBackgroundColor: gradientStroke2,

        pointHoverBackgroundColor: gradientStroke2,

        pointHoverBorderColor: gradientStroke2,

        pointBorderWidth: 5,

        pointHoverRadius: 5,

        pointHoverBorderWidth: 1,

        pointRadius: 0.5,

        fill: false,

        borderWidth: 4,

      },

    ],

  },

  options: {

    legend: {

      display: false,

    },

    tooltips: {},

    scales: {

      yAxes: [

        {

          ticks: {

            display: false, //this will remove only the label

          },

          gridLines: {

            display: false,

            drawBorder: false,

          },

        },

      ],

      xAxes: [

        {

          gridLines: {

            display: false,

            drawBorder: false,

          },

          ticks: {

            display: false, //this will remove only the label

          },

        },

      ],

    },

  },

});

 });

    

	function format(n) {

	    n = n.toString()

	    while (true) {

	      var n2 = n.replace(/(\d)(\d{3})($|,|\.)/g, '$1,$2$3')

	      if (n == n2) break

	      n = n2

	    }

	    return n

	}  	 
}
	      
	  	  

$("body").on("click touchstart","#btnDetalleLiquidez",function(e){

	location.replace('reportefinancierofiltrado/1&desde=1&hasta=12');
	
    // var overlay = document.getElementById("overlayIndiceLiquidez");
    // var popup   = document.getElementById("popupIndiceLiquidez");

    // overlay.classList.add('active');
    // popup.classList.add('active');
});

$("body").on("click touchstart","#btnCerrarIndiceLiquidez",function(e){
    var overlay = document.getElementById("overlayIndiceLiquidez");
    var popup   = document.getElementById("popupIndiceLiquidez");
    
    
    overlay.classList.remove('active');
    popup.classList.remove('active');
});



$("body").on("click touchstart","#btnDetalleSolidez",function(e){

	location.replace('reportefinancierofiltrado/2');
	
    // var overlay = document.getElementById("overlaySolidez");
    // var popup   = document.getElementById("popupSolidez");

    // overlay.classList.add('active');
    // popup.classList.add('active');
});

$("body").on("click touchstart","#btnCerrarSolidez",function(e){
    var overlay = document.getElementById("overlaySolidez");
    var popup   = document.getElementById("popupSolidez");
    
    
    overlay.classList.remove('active');
    popup.classList.remove('active');
});




$("body").on("click touchstart","#btnDetalleCoberturaInteres",function(e){


	location.replace('reportefinancierofiltrado/3');
    // var overlay = document.getElementById("overlayCoberturaInteres");
    // var popup   = document.getElementById("popupCoberturaInteres");

    // overlay.classList.add('active');
    // popup.classList.add('active');
});

$("body").on("click touchstart","#btnCerrarCoberturaInteres",function(e){
    var overlay = document.getElementById("overlayCoberturaInteres");
    var popup   = document.getElementById("popupCoberturaInteres");
    
    
    overlay.classList.remove('active');
    popup.classList.remove('active');
});


$("body").on("click touchstart","#btnDetalleRentabilidadPatrimonio",function(e){


	location.replace('reportefinancierofiltrado/4');
    // var overlay = document.getElementById("overlayRentabilidadPatrimonio");
    // var popup   = document.getElementById("popupRentabilidadPatrimonio");

    // overlay.classList.add('active');
    // popup.classList.add('active');
});

$("body").on("click touchstart","#btnCerrarRentabilidadPatrimonio",function(e){
    var overlay = document.getElementById("overlayRentabilidadPatrimonio");
    var popup   = document.getElementById("popupRentabilidadPatrimonio");
    
    
    overlay.classList.remove('active');
    popup.classList.remove('active');
});

$("body").on("click touchstart","#btnDetalleRentabilidadActivo",function(e){


	location.replace('reportefinancierofiltrado/5');
    // var overlay = document.getElementById("overlayRentabilidadActivo");
    // var popup   = document.getElementById("popupRentabilidadActivo");

    // overlay.classList.add('active');
    // popup.classList.add('active');
});

$("body").on("click touchstart","#btnCerrarRentabilidadActivo",function(e){
    var overlay = document.getElementById("overlayRentabilidadActivo");
    var popup   = document.getElementById("popupRentabilidadActivo");
    
    
    overlay.classList.remove('active');
    popup.classList.remove('active');
});


$("body").on("click touchstart","#btnDetalleCapitalTrabajo",function(e){


	location.replace('reportefinancierofiltrado/6');
    // var overlay = document.getElementById("overlayCapitalTrabajo");
    // var popup   = document.getElementById("popupCapitalTrabajo");

    // overlay.classList.add('active');
    // popup.classList.add('active');
});

$("body").on("click touchstart","#btnCerrarCapitalTrabajo",function(e){
    var overlay = document.getElementById("overlayCapitalTrabajo");
    var popup   = document.getElementById("popupCapitalTrabajo");
    
    
    overlay.classList.remove('active');
    popup.classList.remove('active');
});


$('[data-toggle="tooltip"]').tooltip();