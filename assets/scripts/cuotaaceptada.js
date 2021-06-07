
$(document).ready(function(e){

    var overlay = document.getElementById("overlayLibranza");
    var popup   = document.getElementById("popupLibranza");

   
    overlay.classList.add('active');
    popup.classList.add('active');
});

$("body").on("click touchstart","#btnCargarPdf",function(e){

	

	
	var continuar = document.getElementById("btnContinuar");
	continuar.classList.remove('ocultar');

	var pdf = document.getElementById("btnCargarPdf");
	pdf.classList.add('ocultar');
})

$('[data-toggle="tooltip"]').tooltip();