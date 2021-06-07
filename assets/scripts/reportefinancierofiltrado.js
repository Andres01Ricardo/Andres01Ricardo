$("body").on("click touchstart","#btnAbrirFiltrar",function(e){

    var overlay = document.getElementById("overlayIndiceLiquidez");
    var popup   = document.getElementById("popupIndiceLiquidez");

    overlay.classList.add('active');
    popup.classList.add('active');
});

$("body").on("click touchstart","#btnCerrarIndiceLiquidez",function(e){
    var overlay = document.getElementById("overlayIndiceLiquidez");
    var popup   = document.getElementById("popupIndiceLiquidez");
    
    
    overlay.classList.remove('active');
    popup.classList.remove('active');
});

$("body").on("click touchstart","#btnFiltrar",function(e){

  var desde = document.getElementById('periodoDesde').value;
  var hasta = document.getElementById('periodoHasta').value;
  var cuentaReporteFiltrar = document.getElementById('cuentaReporteFiltrar').value;

  location.replace('../reportefinancierofiltrado/'+cuentaReporteFiltrar+'&desde='+desde+'&hasta='+hasta);
});
