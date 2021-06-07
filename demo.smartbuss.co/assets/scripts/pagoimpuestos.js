
$("body").on("click","#btnPagarICA",function(e){


	
    var overlay = document.getElementById("overlayICA");
    var popup   = document.getElementById("popupICA");

    // document.getElementById('codigoEtapaEliminar').value = codigoEtapaEliminar;

    // document.getElementById('nombreEtapaEliminar').innerHTML =nombreEtapaEliminar ;
    overlay.classList.add('active');
    popup.classList.add('active');
});

$("body").on("click","#btnCerrarICA",function(e){
    var overlay = document.getElementById("overlayICA");
    var popup   = document.getElementById("popupICA");
    
    
    overlay.classList.remove('active');
    popup.classList.remove('active');
});


$("body").on("click","#btnPagarRetencion",function(e){


	
    var overlay = document.getElementById("overlayRetencion");
    var popup   = document.getElementById("popupRetencion");

    // document.getElementById('codigoEtapaEliminar').value = codigoEtapaEliminar;

    // document.getElementById('nombreEtapaEliminar').innerHTML =nombreEtapaEliminar ;
    overlay.classList.add('active');
    popup.classList.add('active');
});

$("body").on("click","#btnCerrarRetencion",function(e){
    var overlay = document.getElementById("overlayRetencion");
    var popup   = document.getElementById("popupRetencion");
    
    
    overlay.classList.remove('active');
    popup.classList.remove('active');
});
$("body").on("click","#btnPagarIVA",function(e){


	
    var overlay = document.getElementById("overlayIVA");
    var popup   = document.getElementById("popupIVA");

    // document.getElementById('codigoEtapaEliminar').value = codigoEtapaEliminar;

    // document.getElementById('nombreEtapaEliminar').innerHTML =nombreEtapaEliminar ;
    overlay.classList.add('active');
    popup.classList.add('active');
});

$("body").on("click","#btnCerrarIVA",function(e){
    var overlay = document.getElementById("overlayIVA");
    var popup   = document.getElementById("popupIVA");
    
    
    overlay.classList.remove('active');
    popup.classList.remove('active');
});

$("body").on("click","#btnPagarSeguridadSocial",function(e){



    var overlay = document.getElementById("overlaySeguridadSocial");
    var popup   = document.getElementById("popupSeguridadSocial");

    // document.getElementById('codigoEtapaEliminar').value = codigoEtapaEliminar;

    // document.getElementById('nombreEtapaEliminar').innerHTML =nombreEtapaEliminar ;
    overlay.classList.add('active');
    popup.classList.add('active');
});

$("body").on("click","#btnCerrarSeguridadSocial",function(e){
    var overlay = document.getElementById("overlaySeguridadSocial");
    var popup   = document.getElementById("popupSeguridadSocial");
    
    
    overlay.classList.remove('active');
    popup.classList.remove('active');
});

$('[data-toggle="tooltip"]').tooltip();