$(document).ready(function(e){
            getMorris('line_chart');
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