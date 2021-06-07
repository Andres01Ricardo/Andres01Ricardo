$(function () {

  graphFinanciero();

 

});



graphFinanciero=function(){



	$.ajax({

	    url:URL+"functions/dashboard/dashboardempresa.php", 

	    type:"POST", 

	    dataType: "json",

	    }).done(function(msg){  

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

	      $("#rentabilidadPatrimonio").html(parseFloat(msg.indicador.rentabilidadPatrimonio).toFixed(7)); 

	      $("#rentabilidadActivo").html(parseFloat(msg.indicador.rentabilidadActivo).toFixed(2));

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

	  	 	

		  var chart = am4core.create("utilidad", am4charts.XYChart);

		  chart.data = aData;



		  // Create axes

		  var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());

		  categoryAxis.dataFields.category = "country";

		  categoryAxis.renderer.grid.template.location = 0;

		  categoryAxis.renderer.minGridDistance = 30;

		  categoryAxis.renderer.labels.template.horizontalCenter = "right";

		  categoryAxis.renderer.labels.template.verticalCenter = "middle";

		  categoryAxis.renderer.labels.template.rotation = 270;

		  categoryAxis.tooltip.disabled = true;

		  categoryAxis.renderer.minHeight = 110;

		  categoryAxis.renderer.labels.template.fill = am4core.color("#8e8da4");



		  var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

		  valueAxis.renderer.minWidth = 50;

		  valueAxis.renderer.labels.template.fill = am4core.color("#8e8da4");



		  // Create series

		  var series = chart.series.push(new am4charts.ColumnSeries());

		  series.sequencedInterpolation = true;

		  series.dataFields.valueY = "visits";

		  series.dataFields.categoryX = "country";

		  series.tooltipText = "[{categoryX}: bold]{valueY}[/]";

		  series.columns.template.strokeWidth = 0;





		  series.tooltip.pointerOrientation = "vertical";



		  series.columns.template.column.cornerRadiusTopLeft = 10;

		  series.columns.template.column.cornerRadiusTopRight = 10;

		  series.columns.template.column.fillOpacity = 0.8;



		  // on hover, make corner radiuses bigger

		  let hoverState = series.columns.template.column.states.create("hover");

		  hoverState.properties.cornerRadiusTopLeft = 0;

		  hoverState.properties.cornerRadiusTopRight = 0;

		  hoverState.properties.fillOpacity = 1;



		  series.columns.template.adapter.add("fill", (fill, target) => {

		    return chart.colors.getIndex(target.dataItem.index);

		  })



		  // Cursor

		  chart.cursor = new am4charts.XYCursor();



		  //////////////////////////////////////////////////////////

		  var aActivo=[]; 

		  var aPasivo=[]; 

		  var aPatrimonio=[];

		  var aLabel=[]; 

		  if(msg.situacion!=null){

		  	msg.situacion.forEach(function(element,index){

	  	 		aActivo.push(element.activo);

	  	 		aPasivo.push(element.pasivo);

	  	 		aPatrimonio.push(element.patrimonio);

	  	 		aLabel.push(element.periodo)

          })

		  }

	  	 	

		  var options = {

		        chart: {

		            height: 350,

		            type: 'bar',

		        },

		        plotOptions: {

		            bar: {

		                horizontal: false,

		                endingShape: 'rounded',

		                columnWidth: '75%',

		            },

		        },

		        dataLabels: {

		            enabled: false

		        },

		        stroke: {

		            show: true,

		            width: 2,

		            colors: ['transparent']

		        },

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

		        xaxis: {

		            categories: aLabel,

		            labels: {

		                style: {

		                    colors: '#8e8da4',

		                }

		            }

		        },

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

		        fill: {

		            opacity: 1



		        },

		        tooltip: {

		            y: {

		                formatter: function (val) {

		                			                	

		                    return "$ " + format((val*1000000));

		                }

		            }

		        }

		    }



		    var chart2 = new ApexCharts(

		        document.querySelector("#situacion"),

		        options

		    );



		    chart2.render();



		    ///////////////////////////////////////////////////

		      var aCompra=[]; 

			  var aVenta=[]; 

			  var aLabels=[]; 

			  if(msg.facturacion!=null){

			  	msg.facturacion.forEach(function(element,index){

		  	 		aCompra.push(element.compra);

		  	 		aVenta.push(element.venta);

		  	 		aLabels.push(element.periodo)

		      })

			  }

		  	 	



			  var options2 = {

		        chart: {

		            height: 350,

		            type: 'line',

		        },

		        series: [{

		            name: 'Facturación Compra',

		            type: 'column',

		            data: aCompra

		        }, {

		            name: 'Facturación Venta',

		            type: 'line',

		            data: aVenta

		        }],

		        stroke: {

		            width: [0, 4]

		        },

		        // labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],

		        labels: aLabels,

		        xaxis: {

		            type: 'category',

		            labels: {

		            	style: {

		                    colors: '#8e8da4',

		                }

		            }

		        },

		        yaxis: [{

		            title: {

		                text: 'Facturación Compra',

		            },

		            labels: {

		                style: {

		                    color: '#8e8da4',

		                }

		            }



		        }, {

		            opposite: true,

		            title: {

		                text: 'Facturación Venta'

		            },

		            labels: {

		                style: {

		                    color: '#8e8da4',

		                }

		            }

		        }]



		    }



		    var chart3 = new ApexCharts(

		        document.querySelector("#facturacion"),

		        options2

		    );



		    chart3.render();



		    ///////////////////////////////////////////

		    am4core.useTheme(am4themes_animated);

		  // Themes end







		  // Create chart instance

		  var chart4 = am4core.create("gaugeChart", am4charts.RadarChart);

		  console.log(msg.indicador); 

		  var nivel=0; 



		  if(msg.indicador!=null){

		  	nivel=msg.indicador.nivelEndeudamiento; 

		  }

		  // Add data

		  chart4.data = [{

		    "category": "Nivel Endeudamiento",

		    "value": nivel,

		    "full": 100

		   },

		  // {

		  //   "category": "Indice Liquidez",

		  //   "value": 35,

		  //   "full": 100

		  // }, {

		  //   "category": "Razon Cobertura Interes",

		  //   "value": 92,

		  //   "full": 100

		  // }, {

		  //   "category": "Rentabilidad Patrimonio",

		  //   "value": 68,

		  //   "full": 100

		  // }

		  ];



		  // Make chart not full circle

		  chart4.startAngle = -90;

		  chart4.endAngle = 180;

		  chart4.innerRadius = am4core.percent(20);



		  // Set number format

		  chart4.numberFormatter.numberFormat = "#.#'%'";



		  // Create axes

		  var categoryAxis = chart4.yAxes.push(new am4charts.CategoryAxis());

		  categoryAxis.dataFields.category = "category";

		  categoryAxis.renderer.grid.template.location = 0;

		  categoryAxis.renderer.grid.template.strokeOpacity = 0;

		  categoryAxis.renderer.labels.template.horizontalCenter = "right";

		  categoryAxis.renderer.labels.template.fontWeight = 500;

		  categoryAxis.renderer.labels.template.adapter.add("fill", function (fill, target) {

		    return (target.dataItem.index >= 0) ? chart.colors.getIndex(target.dataItem.index) : fill;

		  });

		  categoryAxis.renderer.minGridDistance = 10;



		  var valueAxis = chart4.xAxes.push(new am4charts.ValueAxis());

		  valueAxis.renderer.grid.template.strokeOpacity = 0;

		  valueAxis.min = 0;

		  valueAxis.max = 100;

		  valueAxis.strictMinMax = true;

		  valueAxis.renderer.labels.template.fill = am4core.color("#8e8da4");



		  // Create series

		  var series1 = chart4.series.push(new am4charts.RadarColumnSeries());

		  series1.dataFields.valueX = "full";

		  series1.dataFields.categoryY = "category";

		  series1.clustered = false;

		  series1.columns.template.fill = new am4core.InterfaceColorSet().getFor("alternativeBackground");

		  series1.columns.template.fillOpacity = 0.08;

		  series1.columns.template.cornerRadiusTopLeft = 20;

		  series1.columns.template.strokeWidth = 0;

		  series1.columns.template.radarColumn.cornerRadius = 20;



		  var series2 = chart4.series.push(new am4charts.RadarColumnSeries());

		  series2.dataFields.valueX = "value";

		  series2.dataFields.categoryY = "category";

		  series2.clustered = false;

		  series2.columns.template.strokeWidth = 0;

		  series2.columns.template.tooltipText = "{category}: [bold]{value}[/]";

		  series2.columns.template.radarColumn.cornerRadius = 20;



		  series2.columns.template.adapter.add("fill", function (fill, target) {

		    return chart.colors.getIndex(target.dataItem.index);

		  });



		  // Add cursor

		  chart4.cursor = new am4charts.RadarCursor();

		  });



		  am4core.useTheme(am4themes_animated);

		// Themes end







		// create chart

		setTimeout(function(e){

			var chart = am4core.create("chartdiv", am4charts.GaugeChart);

			chart.innerRadius = -15;



			var axis = chart.xAxes.push(new am4charts.ValueAxis());

			axis.min = -100;

			axis.max = 100;

			axis.strictMinMax = true;



			var colorSet = new am4core.ColorSet();



			var gradient = new am4core.LinearGradient();

			gradient.stops.push({color:am4core.color("red")})

			gradient.stops.push({color:am4core.color("yellow")})

			gradient.stops.push({color:am4core.color("green")})



			axis.renderer.line.stroke = gradient;

			axis.renderer.line.strokeWidth = 15;

			axis.renderer.line.strokeOpacity = 1;



			axis.renderer.grid.template.disabled = true;



			var hand = chart.hands.push(new am4charts.ClockHand());

			hand.radius = am4core.percent(97);

			hand.showValue(msg.indicador.indiceLiquidez, 1000, am4core.ease.cubicOut);

		},5000)

		

		// setInterval(function() {

		//     hand.showValue(Math.random() * 100, 1000, am4core.ease.cubicOut);

		// }, 2000);

			//am4core.ready(function() {



			// Themes begin

			//am4core.useTheme(am4themes_animated);

			// Themes end



			// var chart5 = am4core.create("chartdiv", am4charts.XYChart);

			// chart5.hiddenState.properties.opacity = 0; // this makes initial fade in effect

			

			// chart5.data = [{

			//   "country": "Indice Liquidez",

			//   "value": msg.indicador.solidez

			// },

			// {

			//   "country": "Solidez",

			//   "value": msg.indicador.indiceLiquidez

			// },];





			// var categoryAxis = chart5.xAxes.push(new am4charts.CategoryAxis());

			// categoryAxis.renderer.grid.template.location = 0;

			// categoryAxis.dataFields.category = "country";

			// categoryAxis.renderer.minGridDistance = 40;



			// var valueAxis = chart5.yAxes.push(new am4charts.ValueAxis());



			// var series = chart5.series.push(new am4charts.CurvedColumnSeries());

			// series.dataFields.categoryX = "country";

			// series.dataFields.valueY = "value";

			// series.tooltipText = "{valueY.value}"

			// series.columns.template.strokeOpacity = 0;



			// series.columns.template.fillOpacity = 0.75;



			// var hoverState = series.columns.template.states.create("hover");

			// hoverState.properties.fillOpacity = 1;

			// hoverState.properties.tension = 0.4;



			// chart5.cursor = new am4charts.XYCursor();



			// // Add distinctive colors for each column using adapter

			// series.columns.template.adapter.add("fill", function(fill, target) {

			//   return chart.colors.getIndex(target.dataItem.index);

			// });



			// chart5.scrollbarX = new am4core.Scrollbar();



			//}); 

var draw = Chart.controllers.line.prototype.draw;

Chart.controllers.lineShadow = Chart.controllers.line.extend({

  draw: function () {

    draw.apply(this, arguments);

    var ctx = this.chart.chart.ctx;

    var _stroke = ctx.stroke;

    ctx.stroke = function () {

      ctx.save();

      ctx.shadowColor = "#00000075";

      ctx.shadowBlur = 10;

      ctx.shadowOffsetX = 8;

      ctx.shadowOffsetY = 8;

      _stroke.apply(this, arguments);

      ctx.restore();

    };

  },

});	  	

var ctx = document.getElementById("cardChart1").getContext("2d");

var gradientStroke2 = ctx.createLinearGradient(0, 0, 700, 0);

gradientStroke2.addColorStop(0, "rgba(255, 204, 128, 1)");

gradientStroke2.addColorStop(0.5, "rgba(255, 152, 0, 1)");

gradientStroke2.addColorStop(1, "rgba(239, 108, 0, 1)");



var myChart = new Chart(ctx, {

  type: "lineShadow",

  data: {

    labels: ["2010", "2011", "2012", "2013", "2014", "2015", "2016"],

    type: "line",

    datasets: [

      {

        label: "Income",

        data: [20, 50, 10, 10, 50, 90, 35],

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



// card chart 2

var ctx = document.getElementById("cardChart2").getContext("2d");

var gradientStroke2 = ctx.createLinearGradient(500, 0, 0, 0);

gradientStroke2.addColorStop(0, "rgba(55, 154, 80, 1)");

gradientStroke2.addColorStop(1, "rgba(131, 210, 151, 1)");



var myChart = new Chart(ctx, {

  type: "lineShadow",

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



// card chart 3

var ctx = document.getElementById("cardChart3").getContext("2d");

var gradientStroke2 = ctx.createLinearGradient(0, 0, 700, 0);

gradientStroke2.addColorStop(0, "rgba(103, 119, 239, 1)");

gradientStroke2.addColorStop(0.5, "rgba(106, 120, 220, 1)");

gradientStroke2.addColorStop(1, "rgba(92, 103, 187, 1)");



var myChart = new Chart(ctx, {

  type: "lineShadow",

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



// card chart 4

var ctx = document.getElementById("cardChart4").getContext("2d");

var gradientStroke2 = ctx.createLinearGradient(0, 0, 700, 0);

gradientStroke2.addColorStop(0, "rgba(61, 199, 190, 1)");

gradientStroke2.addColorStop(0.5, "rgba(57, 171, 163, 1)");

gradientStroke2.addColorStop(1, "rgba(40, 142, 135, 1)");



var myChart = new Chart(ctx, {

  type: "lineShadow",

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



// card chart 4

var ctx = document.getElementById("cardChart5").getContext("2d");

var gradientStroke2 = ctx.createLinearGradient(0, 0, 700, 0);

gradientStroke2.addColorStop(0, "rgba(135, 167, 236, 1)");

gradientStroke2.addColorStop(0.5, "rgba(81, 132, 241, 1)");

gradientStroke2.addColorStop(1, "rgba(25, 94, 242, 1)");



var myChart = new Chart(ctx, {

  type: "lineShadow",

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





// card chart 4

var ctx = document.getElementById("cardChart6").getContext("2d");

var gradientStroke2 = ctx.createLinearGradient(0, 0, 700, 0);

gradientStroke2.addColorStop(0, "rgba(247, 146, 146, 1)");

gradientStroke2.addColorStop(0.5, "rgba(253, 94, 94, 1)");

gradientStroke2.addColorStop(1, "rgba(216, 29, 29, 1)");



var myChart = new Chart(ctx, {

  type: "lineShadow",

  data: {

    labels: ["2010", "2011", "2012", "2013", "2014", "2015", "2016"],

    type: "line",

    datasets: [

      {

        label: "Income",

        data: [25, 94, 36, 115, 100, 70,],

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

}

function format(n) {

    n = n.toString()

	  while (true) {

	    var n2 = n.replace(/(\d)(\d{3})($|,|\.)/g, '$1,$2$3')

	    if (n == n2) break

	    n = n2

	  }

	  return n

}


$("body").on("click","#btnDetalleLiquidez",function(e){


	
    var overlay = document.getElementById("overlayIndiceLiquidez");
    var popup   = document.getElementById("popupIndiceLiquidez");

    overlay.classList.add('active');
    popup.classList.add('active');
});

$("body").on("click","#btnCerrarIndiceLiquidez",function(e){
    var overlay = document.getElementById("overlayIndiceLiquidez");
    var popup   = document.getElementById("popupIndiceLiquidez");
    
    
    overlay.classList.remove('active');
    popup.classList.remove('active');
});



$("body").on("click","#btnDetalleSolidez",function(e){


	
    var overlay = document.getElementById("overlaySolidez");
    var popup   = document.getElementById("popupSolidez");

    overlay.classList.add('active');
    popup.classList.add('active');
});

$("body").on("click","#btnCerrarSolidez",function(e){
    var overlay = document.getElementById("overlaySolidez");
    var popup   = document.getElementById("popupSolidez");
    
    
    overlay.classList.remove('active');
    popup.classList.remove('active');
});




// $("body").on("click","#btnDetalleCoberturaInteres",function(e){


	
//     var overlay = document.getElementById("overlayCoberturaInteres");
//     var popup   = document.getElementById("popupCoberturaInteres");

//     overlay.classList.add('active');
//     popup.classList.add('active');
// });

// $("body").on("click","#btnCerrarCoberturaInteres",function(e){
//     var overlay = document.getElementById("overlayCoberturaInteres");
//     var popup   = document.getElementById("popupCoberturaInteres");
    
    
//     overlay.classList.remove('active');
//     popup.classList.remove('active');
// });
$("body").on("click","#btnDetalleRentabilidadPatrimonio",function(e){


	
    var overlay = document.getElementById("overlayRentabilidadPatrimonio");
    var popup   = document.getElementById("popupRentabilidadPatrimonio");

    overlay.classList.add('active');
    popup.classList.add('active');
});

$("body").on("click","#btnCerrarRentabilidadPatrimonio",function(e){
    var overlay = document.getElementById("overlayRentabilidadPatrimonio");
    var popup   = document.getElementById("popupRentabilidadPatrimonio");
    
    
    overlay.classList.remove('active');
    popup.classList.remove('active');
});

$("body").on("click","#btnDetalleRentabilidadActivo",function(e){


	
    var overlay = document.getElementById("overlayRentabilidadActivo");
    var popup   = document.getElementById("popupRentabilidadActivo");

    overlay.classList.add('active');
    popup.classList.add('active');
});

$("body").on("click","#btnCerrarRentabilidadActivo",function(e){
    var overlay = document.getElementById("overlayRentabilidadActivo");
    var popup   = document.getElementById("popupRentabilidadActivo");
    
    
    overlay.classList.remove('active');
    popup.classList.remove('active');
});


$("body").on("click","#btnDetalleCapitalTrabajo",function(e){


	
    var overlay = document.getElementById("overlayCapitalTrabajo");
    var popup   = document.getElementById("popupCapitalTrabajo");

    overlay.classList.add('active');
    popup.classList.add('active');
});

$("body").on("click","#btnCerrarCapitalTrabajo",function(e){
    var overlay = document.getElementById("overlayCapitalTrabajo");
    var popup   = document.getElementById("popupCapitalTrabajo");
    
    
    overlay.classList.remove('active');
    popup.classList.remove('active');
});


$('[data-toggle="tooltip"]').tooltip();