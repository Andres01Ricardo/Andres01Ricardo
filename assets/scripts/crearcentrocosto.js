var nextinput = 0;

$(document).ready(function(e){
  var divCrearSubcentros=document.getElementById('divCrearSubcentros');
  divCrearSubcentros.style.display="none";
});


$("body").on("click touchstart","#agregar",function(e){
 
nextinput++;
// campo = '<input type="text" class="form-control" id="subcentros' + nextinput + '"&nbsp; name="subcentros[' + nextinput + '][nombre]"&nbsp; />';
// $("#divSubcentros").append(campo);
label=nextinput+1;
campoS = '<div id="divCodigoSubcentros'+ nextinput +'"><label>Subcentro'+label+'</label><input type="text" class="form-control" id="codigoSubcentros' + nextinput + '"&nbsp; name="subcentros[' + nextinput + '][codigo]"&nbsp; /><br></div>';
$("#divCodigoSubcentros").append(campoS);
campo = '<div id="divNombreSubcentros'+ nextinput +'"><label>Subcentro'+label+'</label><input type="text" class="form-control" id="subcentros' + nextinput + '"&nbsp; name="subcentros[' + nextinput + '][nombre]"&nbsp; /><br></div>';
$("#divSubcentros").append(campo);
});



$("body").on("click touchstart",".eliminar",function(e){

  if(nextinput>0){
    
    // $("#subcentros"+nextinput).remove();
    // nextinput--;
    $("#divNombreSubcentros"+nextinput).remove();
    $("#divCodigoSubcentros"+nextinput).remove();
    nextinput--;
  }

});


$("#subcentroCheck").on( 'change', function() {
    if( $(this).is(':checked') ) {
        divCrearSubcentros.style.display="flex";
    } else {
        divCrearSubcentros.style.display="none";
    }
});



$("body").on("click touchstart","#btnGuardar",function(e){

    e.preventDefault();

      if(true === $("#frmGuardar").parsley().validate()){

          Swal.fire({

          title: '¿Está seguro?',

          text: 'Está a punto de crear un centro de costo!',

          icon: 'warning', 

          showCancelButton: true,

          showLoaderOnConfirm: true,

          confirmButtonText: `Si, Guardar!`,

          cancelButtonText:'Cancelar',

          preConfirm: function(result) {

          return new Promise(function(resolve) {

            var formu = document.getElementById("frmGuardar");

        

            var data = new FormData(formu);

            $.ajax({

            url:URL+"functions/centrocosto/guardarcentrocosto.php", 

            type:"POST", 

            data: data,

            contentType:false, 

            processData:false, 

            dataType: "json",

            cache:false 

            }).done(function(msg){  

              if(msg.msg){

                Swal.fire(

                  {

                  icon: 'success',

                  title: "centro de costo creado!",

                  text: 'con exito',

                  closeOnConfirm: true,

                }

                ).then((result) => {

                 location.reload(); 

                })

              }else{

                 Swal.fire(

                  'Algo ha salido mal!',

                  'Verifique su conexión a internet',

                  'error'

                )
              }

            });

          });

        }

        })

      }

  });

$('[data-toggle="tooltip"]').tooltip();