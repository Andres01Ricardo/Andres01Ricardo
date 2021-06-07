$(document).ready(function(e){

    var overlay = document.getElementById("overlayImpuestos");
    var popup   = document.getElementById("popupImpuestos");

   
    overlay.classList.add('active');
    popup.classList.add('active');

    document.getElementById('divTercero').style.visibility= "hidden";
    document.getElementById('divCuenta').style.visibility= "hidden";
    document.getElementById('divTipoTercero').style.visibility= "hidden";
});



$("body").on("change","#tipoFiltro",function(e){

    var id=$(this).val(); 

    if (id==1) {
        document.getElementById('divTipoTercero').style.visibility= "visible";
        
        document.getElementById('divCuenta').style.visibility= "hidden";
        
    }
    if (id==2) {
        document.getElementById('divTipoTercero').style.visibility= "hidden";
        document.getElementById('divTercero').style.visibility= "hidden";
        document.getElementById('divCuenta').style.visibility= "visible";
    }

});
$("body").on("change","#tipoTercero",function(e){

    var idT=$(this).val(); 
    var divTercero=document.getElementById('divTercero');
    // var terceroSelect=document.getElementById('tercero');
   
    if (idT==1) {        
        divTercero.style.visibility= "visible";
        $.ajax({

        url:URL+"functions/terceros/consultarterceros.php", 

        type:"POST", 

        data: {"tipoTercero":idT}, 

        dataType: "json",

        }).done(function(msg){  

          var sHtml="<option value='0'>TODOS</option>"; 
          
           
            msg.terceros.forEach(function(element,index){

            sHtml+="<option value='"+element.idTercero+"'>"+element.razonSocial+"</option>"; 

              })

          
         
          $("[name='datos[tercero]']").html(sHtml);
         // terceroSelect.innerHTML(sHtml);

      });
        
    }if(idT==2) {        
        divTercero.style.visibility= "visible"; 
        $.ajax({

        url:URL+"functions/terceros/consultarterceros.php", 

        type:"POST", 

        data: {"tipoTercero":idT}, 

        dataType: "json",

        }).done(function(msg){  

          var sHtml="<option value='0'>TODOS</option>"; 
          
          
            msg.terceros.forEach(function(element,index){

            sHtml+="<option value='"+element.idTercero+"'>"+element.razonSocial+"</option>"; 

              })

          
         
          $("[name='datos[tercero]']").html(sHtml);
          // terceroSelect.innerHTML(sHtml);

      });       
    }if (idT==3) {        
        divTercero.style.visibility= "visible";
        $.ajax({

        url:URL+"functions/terceros/consultarterceros.php", 

        type:"POST", 

        data: {"tipoTercero":idT}, 

        dataType: "json",

        }).done(function(msg){  

          var sHtml="<option value='0'>TODOS</option>"; 
          
         
            msg.terceros.forEach(function(element,index){

            sHtml+="<option value='"+element.idTercero+"'>"+element.razonSocial+"</option>"; 

              })

          $("[name='datos[tercero]']").html(sHtml);
         
          
         // terceroSelect.innerHTML(sHtml);

      });        
    }if (idT==''){
       divTercero.style.visibility= "hidden";
    }

});


$('[data-toggle="tooltip"]').tooltip();