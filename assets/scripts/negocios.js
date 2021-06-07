$("body").on("click touchstart","#btnGuardar",function(e){

    e.preventDefault();

      if(true === $("#frmGuardar").parsley().validate()){

        Swal.fire({

        title: 'Está seguro?',

        text: 'Está a punto de guardar un nuevo posible negocio!',

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

            url:URL+"functions/crm/insertarnegocio.php", 

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

                  title: 'Posible negocio creado!',

                  text: 'con exito',

                  closeOnConfirm: true,

                }

                ).then((result) => {

                 location.reload(); 

                })

              }else{

                 Swal.fire(

                  'Algo ha salido mal!',

                  'El cliente ya se encuentra registrado en el sistema',

                  'error'

                ).then((result) => {

                  

                })

              }

            

          });

          });

        }

      })

      }

  })



$("body").on("click touchstart","#btnCerrarNegocio",function(e){

    e.preventDefault();

      if(true === $("#frmCerrarNegocio").parsley().validate()){

        Swal.fire({

        title: '¿Está seguro?',

        text: 'Está a punto de cerrar este negocio!',

        icon: 'warning', 

        showCancelButton: true,

        showLoaderOnConfirm: true,

        confirmButtonText: `Si, Guardar!`,

        cancelButtonText:'Cancelar',

        preConfirm: function(result) {

          return new Promise(function(resolve) {

            var formu = document.getElementById("frmCerrarNegocio");

      

            var data = new FormData(formu);

            $.ajax({

            url:URL+"functions/crm/cerrarnegocio.php", 

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

                  title: 'Negocio cerrado!',

                  text: 'con exito',

                  closeOnConfirm: true,

                }

                ).then((result) => {

                 location.reload(); 

                })

              }else{

                 Swal.fire(

                  'Algo ha salido mal!',

                  'El cliente ya se encuentra registrado en el sistema',

                  'error'

                ).then((result) => {

                  

                })

              }

            

          });

          });

        }

      })

      }

  })





$('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);
  var id = button.data('id');
  var descripcion = button.data('descripcion');
  var valor = button.data('valor'); 


  var modal = $(this);
  // $('#valorfinal')
  modal.find('#idActividadCerrar').val(id);
  modal.find('#valorfinal').val(valor).trigger('change');
  modal.find('#motivo').val(descripcion);
  // modal.find('.modal-body input').val(recipient)
})

$("[name='datos[renovacion]']").click(function(){
  if ($(this).val()=='no') {
    $("#renovacion").removeAttr('required');
    $("#renovacion").css('display','none');
    $("#divAlarma").css('display','none');
    $("#alarmaRenovacion").removeAttr('required');

  }
  if ($(this).val()=='si') {
    $("#renovacion").attr('required','required');
    $("#alarmaRenovacion").attr('required','required');
    $("#renovacion").css('display','block');
    $("#divAlarma").css('display','block');

  }
})


$("[name='datos[cerrado]']").click(function(){
  if ($(this).val()=='perdido') {
    $("#renovacion").removeAttr('required');
    $("#renovacion").css('display','none');
    $("#divAlarma").css('display','none');
    $("#divRenovacion").css('display','none');
    $("#alarmaRenovacion").removeAttr('required');

  }
  if ($(this).val()=='ganado') {
    $("#renovacion").attr('required','required');
    $("#alarmaRenovacion").attr('required','required');
    $("#renovacion").css('display','block');
    $("#divAlarma").css('display','block');
    $("#divRenovacion").css('display','block');

  }
})


