$("body").on("click","#btnGuardar",function(e){

    e.preventDefault();

      if(true === $("#frmGuardar").parsley().validate()){

        Swal.fire({

        title: 'Está seguro?',

        text: 'Está a punto de crear una nueva cuenta bancaria!',

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

            url:URL+"functions/cuentabancaria/guardarcuentabancaria.php", 

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

                  title: 'Cuenta Bancaria Creada!',

                  text: 'con exito',

                  closeOnConfirm: true,

                }

                ).then((result) => {

                 location.reload(); 

                })

              }else{

                 Swal.fire(

                  'Algo ha salido mal!',

                  'Revise su conexión a internet',

                  'error'

                ).then((result) => {

                  

                })

              }

            

          });

          });

        }

      }).then((result) => {

        if (result.isConfirmed) {



        } 



       })

       

      }

  })



$("body").on("change","[name='datos[tipoCuenta]']",function(e){

  
    if($(this).val()==1 || $(this).val()==2){
      $("#idBanco").css("display", "block");
      $("#selectIdBanco").attr("required","required");
      $("#numeroCuenta").css("display", "block");
      $("#aplicaCuatroMil").css("display", "block");
      $("#inputNumeroCuenta").attr("required","required");
      
    }
    if($(this).val()==3){
      $("#idBanco").css("display", "none");
      $("#selectIdBanco").removeAttr("required");
      $("#numeroCuenta").css("display", "none");
      $("#inputNumeroCuenta").removeAttr("required");
      $("#aplicaCuatroMil").css("display", "none");
      $("#aplicaCuatroMilSi").removeAttr("checked");
      $("#aplicaCuatroMilNo").attr("checked","checked");
    }
})









$( window ).on( "load", function() {


 var idEmpresa=$("[name='datos[idEmpresa]'").val();
 console.log(idEmpresa);

    $.ajax({
      url:URL+"functions/cuentascontables/cargarcuentascontables.php", 
      type:"POST", 
      data: {"idEmpresa":idEmpresa}, 
      dataType: "json",
      }).done(function(msg){  
        // var $aDatos=[];
        console.log(msg);
        if (msg.length==0) {
          $(".cuentaContable").val('No hay cuentas contables creadas');
          $(".cuentaContable").attr('disabled','disabled');

        }
        if (msg.length!=0) {
          var sHtml='<option value="">Seleccione</option>';

        msg.forEach(function(element,index){
          sHtml+='<option value="'+element.idCuentaContable+'">'+element.codigoCuentaContable+' - '+element.nombre+'</option>';
          // datos.push({
          //     value: element.idCuentaContable,
          //     label: element.codigoCuentaContable+" - "+element.nombre,
              
          //   })
        })
        $("#cuentaContable").html(sHtml);
        
      }
    }); 

});