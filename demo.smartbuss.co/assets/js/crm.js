


function ocultar(){
	var formulario = document.getElementById('formagregar');
	
	formulario.style.visibility = 'collapse';
}



function validar(){
    var form = document.getElementById('form');
    var tipoDocumento = document.getElementById('tipoDocumento').value;
    var documento = document.getElementById('documento');
	var nombre= document.getElementById('nombre');
    var apellidos= document.getElementById('apellidos');
	var email = document.getElementById('email');
    var direccion = document.getElementById('direccion');
    var telefono = document.getElementById('telefono');
    var procedencia = document.getElementById('procedencia').value;
    var encargado = document.getElementById('encargado').value;
    
	expresionCorreo= /\w+@+\w+\.+\w/;

    const documentoValue = documento.value.trim();
    const nombreValue = nombre.value.trim();
    const apellidosValue = apellidos.value.trim();
    const emailValue = email.value.trim();
    const direccionValue = direccion.value.trim();
    const telefonoValue = telefono.value.trim();
    
    if(tipoDocumento == 0) {
        
        alert('Seleccione el tipo de documento');
        return false;
    }
    if(documentoValue === '') {
        
        alert('Ingrese el numero de documento');
        return false;
    }

    if(nombreValue === '') {
        alert('Ingrese el nombre');
        return false;
    }
    if(apellidosValue === '') {
        alert('Ingrese los apellidos');
        return false;
    }
    
    if(emailValue === '') {
        alert('Ingrese el email');
        return false;
    } else if (!expresionCorreo.test(emailValue)) {
        alert('No ingreso un email válido');
        return false;
    }
    
    if(direccionValue === '') {
        alert('Ingrese la dirección');
        return false;
    }
   if(telefonoValue === '') {
        alert('Ingrese el telefono');
        return false;
    }
    if(procedencia == 0) {
        
        alert('Seleccione la procedencia del cliente');
        return false;
    }
    if(encargado == 0) {
        
        alert('Seleccione el encargado');
        return false;
    }
}




function aMayusculas(obj,id){
    obj = obj.toUpperCase();
    document.getElementById(id).value = obj;
}
function letras(e) { 
    tecla = (document.all) ? e.keyCode : e.which; 
    if (tecla==8) return true; 
    patron =/[A-ZÑa-zñ\s]/; 
    te = String.fromCharCode(tecla); 
    return patron.test(te); 
}
function numeros(evt) {
    evt = (evt) ? evt : window.event
    var charCode = (evt.which) ? evt.which : evt.keyCode

    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        status = "Este campo solo acepta números."
        return false
    }
    status = ""
    return true
}
function colornuevo(){
var color_picker = document.getElementById('color');
var color_picker_wrapper = document.getElementById('nuevo');
var input_nuevo = document.getElementById('inputnuevo');
color_picker.oninput = function() {
	color_picker_wrapper.style.backgroundColor = color_picker.value; 
    input_nuevo.style.backgroundColor = color_picker.value;   
}
color_picker_wrapper.style.backgroundColor = color_picker.value;
input_nuevo.style.backgroundColor = color_picker.value;
}

function agregaretapa(visibilidad,boton){
    var color_picker = document.getElementById('color');
    var input_nuevo = document.getElementById('inputnuevo');
    var nuevo = document.getElementById('nuevo');
    var agregaretapa = document.getElementById('agregaretapa');
    var cancelaretapa = document.getElementById('cancelaretapa');

    color_picker.style.visibility = visibilidad;
    input_nuevo.style.visibility = visibilidad;
    nuevo.style.visibility = visibilidad;
    if (boton == 'agregar') {
        cancelaretapa.style.visibility = 'visible';
        agregaretapa.style.visibility = 'collapse';
        nuevo.style.visibility = 'visible';
        
    }
    if (boton == 'cancelar') {
        cancelaretapa.style.visibility = 'collapse';
        agregaretapa.style.visibility = 'visible';
        nuevo.style.visibility = 'collapse';
    }
    
}
function agregarcliente(boton){
    var agregar = document.getElementById('formagregar');
    var agregarcliente = document.getElementById('agregarcliente');
    var cancelarcliente = document.getElementById('cancelarcliente');

    if (boton == 'agregar') {
        agregar.style.visibility = 'visible';
        cancelarcliente.style.visibility = 'visible';
        agregarcliente.style.visibility = 'collapse';
    }
    if (boton == 'cancelar') {
        agregar.style.visibility = 'collapse';
        cancelarcliente.style.visibility = 'collapse';
        agregarcliente.style.visibility = 'visible';
    }
}

function eliminaretapa(){
    var etapa = confirm("¿Desea eliminar la etapa?");
    var codigoEtapa = document.getElementById('eliminaretapa').value;

    if (etapa) {
        location.href="eliminaretapa?etapa="+codigoEtapa;
        alert("etapa eliminada");

    }
    else{
        alert("No se elimino");
    }
}
    

    var inicio=0;
    var timeout=0;
 
  function empezarDetener(elemento)
  {
    var icon = document.getElementById('iconoCrono');
      icon.classList.toggle('fa-pause');
      icon.classList.toggle('fa-play');
    if(timeout==0)
    {
      elemento.value="Detener";
      inicio=vuelta=new Date().getTime();
      funcionando();
    }else{
      
      elemento.value="Empezar";
      clearTimeout(timeout);
      timeout=0;
    }
  }
 
  function funcionando()
  {
    var crono = document.getElementById('crono').innerText;

    document.getElementById('duracion').value = crono;
    var actual = new Date().getTime();
    var diff=new Date(actual-inicio);
     
    var result=LeadingZero(diff.getUTCHours())+":"+LeadingZero(diff.getUTCMinutes())+":"+LeadingZero(diff.getUTCSeconds());
    document.getElementById('crono').innerHTML = result;
 
    
    timeout=setTimeout("funcionando()",1000);
  }
 
  
  function LeadingZero(Time) {
    return (Time < 10) ? "0" + Time : + Time;
  }

  function mostrar(){
    var cardtarea = document.getElementById("cardtarea").style.display="block";
    var btnmostrar = document.getElementById("btnmostrar").style.display="none";
    var btnocultar = document.getElementById("btnocultar").style.display="block";
    
  }
  function ocultar(){
    var cardtarea = document.getElementById("cardtarea").style.display="none";
    var btnmostrar = document.getElementById("btnmostrar").style.display="block";
    var btnocultar = document.getElementById("btnocultar").style.display="none";
    }


function abrirpopup(idActividad){
    var overlay = document.getElementById("overlay");
    var popup   = document.getElementById("popup");
    var btncerrar= document.getElementById("btn-cerrar");
    var idActividad= idActividad;
    
    document.getElementById('idActividadCerrar').value = idActividad;
    overlay.classList.add('active');
    popup.classList.add('active');
}

function cerrarpopup(){
    var overlay = document.getElementById("overlay");
    var popup   = document.getElementById("popup");
    var btncerrar= document.getElementById("btn-cerrar");
    
    overlay.classList.remove('active');
    popup.classList.remove('active');
}



function negocioperdido(){
    var ganado = document.getElementById('ganado');
    var perdido = document.getElementById('perdido');
    var descripcionfinal = document.getElementById('descripcionfinal');
    var valorfinal = document.getElementById('valorfinal');
    if (perdido.checked) {
        descripcionfinal.disabled = true;
        valorfinal.disabled = true;
    }else{
        descripcionfinal.disabled = false;
        valorfinal.disabled = false;
    }
}



function abrirpopup1(codigoClienteCambiar){
    var overlay1 = document.getElementById("overlay1");
    var popup1   = document.getElementById("popup1");
    var btncerrar= document.getElementById("btn-cerrar1");
    var codigoClienteCambiar= codigoClienteCambiar;
    
    document.getElementById('codigoClienteCambiar').value = codigoClienteCambiar;
    overlay1.classList.add('active');
    popup1.classList.add('active');
}

function cerrarpopup1(){
    var overlay1 = document.getElementById("overlay1");
    var popup1   = document.getElementById("popup1");
    var btncerrar= document.getElementById("btn-cerrar1");
    
    overlay1.classList.remove('active');
    popup1.classList.remove('active');
}



function abrirpopup2(codigoClienteCambiar){
    var overlay = document.getElementById("overlay2");
    var popup   = document.getElementById("popup2");
    var btncerrar= document.getElementById("btn-cerrar2");
    var codigoClienteCambiar= codigoClienteCambiar;
    
    document.getElementById('codigoClienteCambiar2').value = codigoClienteCambiar;
    overlay.classList.add('active');
    popup.classList.add('active');
}

function cerrarpopup2(){
    var overlay = document.getElementById("overlay2");
    var popup   = document.getElementById("popup2");
    var btncerrar= document.getElementById("btn-cerrar2");
    
    overlay.classList.remove('active');
    popup.classList.remove('active');
}

function abrirpopupetapa(codigoEtapaCambiar,colorEtapa,nombreEtapa){
    var overlay = document.getElementById("overlayetapa");
    var popup   = document.getElementById("popupetapa");
    var btncerrar= document.getElementById("btn-cerraretapa");
    var codigoEtapaCambiar= codigoEtapaCambiar;
    var nombreEtapaCambiar= nombreEtapa;
    var colorEtapaCambiar= colorEtapa;
    
    document.getElementById('codigoEtapaCambiar').value = codigoEtapaCambiar;
    document.getElementById('coloretapacambiar').value = colorEtapaCambiar;
    document.getElementById('nombreEtapaCambiar').value =nombreEtapaCambiar ;
    overlay.classList.add('active');
    popup.classList.add('active');
}

function cerrarpopupetapa(){
    var overlay = document.getElementById("overlayetapa");
    var popup   = document.getElementById("popupetapa");
    var btncerrar= document.getElementById("btn-cerraretapa");
    
    overlay.classList.remove('active');
    popup.classList.remove('active');
}


function coloretapacambiar(){
var color_picker = document.getElementById('coloretapacambiar');
var color_picker_wrapper = document.getElementById('nombreEtapaCambiar');

color_picker.oninput = function() {
    color_picker_wrapper.style.backgroundColor = color_picker.value; 

}
color_picker_wrapper.style.backgroundColor = color_picker.value;
    
}

function abrirpopup3(codigoClienteEliminar){
    var overlay = document.getElementById("overlay3");
    var popup   = document.getElementById("popup3");
    var btncerrar= document.getElementById("btn-cerrar3");
    var codigoClienteEliminar= codigoClienteEliminar;
    
    document.getElementById('codigoClienteEliminar').value = codigoClienteEliminar;
    overlay.classList.add('active');
    popup.classList.add('active');
}

function cerrarpopup3(){
    var overlay = document.getElementById("overlay3");
    var popup   = document.getElementById("popup3");
    var btncerrar= document.getElementById("btn-cerrar3");
    
    overlay.classList.remove('active');
    popup.classList.remove('active');
}


function abrirpopupeliminaretapa(codigoEtapaEliminar,nombreEtapaEliminar){
    var overlay = document.getElementById("overlayeliminaretapa");
    var popup   = document.getElementById("popupeliminaretapa");
    var btncerrar= document.getElementById("btn-cerraretapaEliminar");
    var codigoEtapaEliminar= codigoEtapaEliminar;
    var nombreEtapaEliminar= nombreEtapaEliminar;
    
    
    document.getElementById('codigoEtapaEliminar').value = codigoEtapaEliminar;

    document.getElementById('nombreEtapaEliminar').innerHTML =nombreEtapaEliminar ;
    overlay.classList.add('active');
    popup.classList.add('active');
}

function cerrarpopupeliminaretapa(){
    var overlay = document.getElementById("overlayeliminaretapa");
    var popup   = document.getElementById("popupeliminaretapa");
    var btncerrar= document.getElementById("btn-cerraretapaEliminar");
    
    overlay.classList.remove('active');
    popup.classList.remove('active');
}