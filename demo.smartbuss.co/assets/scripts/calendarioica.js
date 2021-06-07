$(document).ready(function(e){
  var  aColores=["#00bcd4","#DC35A9","#33FFA8","#FF4633","#0C31C6","#33C60C","#690CC6","#C30101","#BE33FF"];

$.ajax({
  url:URL+"functions/calendarioimpuesto/calendario.php", 
  type:"POST", 
  dataType: "json",
  }).done(function(msg){  
    console.log(msg)
    var  aData=[]; 
    msg.fechas.forEach(function(element,index){
      var aArray = element.fechaLimite.split("-");
      aData.push({
        title: 'PAGO '+element.tipo+' DIGITO '+element.digito,
        start: new Date(parseInt(aArray[0]), parseInt(aArray[1])-1, parseInt(aArray[2]), 17, 00),
        end: new Date(parseInt(aArray[0]), parseInt(aArray[1])-1, parseInt(aArray[2]), 17, 00),
        backgroundColor: aColores[parseInt(element.digito)]
      },)
    })
    msg.icas.forEach(function(element,index){
      var aArray = element.fecha.split("-");
      aData.push({
        title: 'ICA '+element.ciudad,
        start: new Date(parseInt(aArray[0]), parseInt(aArray[1])-1, parseInt(aArray[2]), 17, 00),
        end: new Date(parseInt(aArray[0]), parseInt(aArray[1])-1, parseInt(aArray[2]), 17, 00),
        backgroundColor: '#00a1ff'
      },)
    })
    msg.icasDigito.forEach(function(element,index){
      var aArray = element.fecha.split("-");
      aData.push({
        title: ' DIG. '+element.digito+' - ICA '+element.ciudad,
        start: new Date(parseInt(aArray[0]), parseInt(aArray[1])-1, parseInt(aArray[2]), 17, 00),
        end: new Date(parseInt(aArray[0]), parseInt(aArray[1])-1, parseInt(aArray[2]), 17, 00),
        backgroundColor: aColores[parseInt(element.digito)]
      },)
    })
    setTimeout(function(e){
      
      var calendar = $('#myEvent').fullCalendar({
          height: 'auto',
          defaultView: 'month',
          editable: false,
          selectable: true,
          header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listMonth'
          },
          events: aData
        });
    },1000)
    
  });

})

