var aDatos=[];

$(document).ready(function(e){

  idEmpresa=0;
 

});







$("body").on("click touchstart","#btnGuardar",function(e){

    e.preventDefault();

      if(true === $("#frmGuardar").parsley().validate()){

          Swal.fire({

          title: '¿Está seguro?',

          text: 'Está a punto de crear un parametro de documentos!',

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

            url:URL+"functions/parametrosdocumentos/guardarparametrosdocumentos.php", 

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

                  title: "parametro documento creado!",

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

  })

$('[data-toggle="tooltip"]').tooltip();



$("body").on("change","#tipoDocumento",function(e){
    var tipoDocumento=$(this).val();
    var idEmpresa=$("#idEmpresa").val();
    
    $.ajax({

            url:URL+"functions/parametrosdocumentos/consultarparametro.php", 

            type:"POST", 

            data: {"tipoDocumento":tipoDocumento,"idEmpresa":idEmpresa},

            dataType: "json"

            }).done(function(msg){  
              console.log(msg);
              // alert(msg);
              if (msg.parametro!=null) {
                var numero=msg.parametro.comprobante;
                $("#comprobante").val(parseInt(numero)+1);
              }
              if (msg.parametro==null) {
                var numero=0;
              $("#comprobante").val(parseInt(numero)+1);
              }
              
              // alert(numero);


            });

            // alert($("#comprobante").val());
})

//     var id=$(this).val(); 
//     var cuenta=document.getElementById('ctaRIVA');
//     var tipoCruce=document.getElementById('cruce');
//     var manejoDescuento=document.getElementById('divManejoDescuento');
//     var numeroItems=document.getElementById('numeroItems');
//     var formatoImpresion=document.getElementById('formatoImpresion');
//     var numeroCopias=document.getElementById('numeroCopias');
//     var creceE=document.getElementById('cruceE');
//     var obligaCruce=document.getElementById('divObligaCruce');
//     var cuentaBancoG=document.getElementById('cuentaBancoG');
//     var marcaBaseGrabable=document.getElementById('marcaBaseGrabable');
//     var ensamble=document.getElementById('ensamble');
//     var cuentasR=document.getElementById('cuentasR');
//     var cuentaReteIVA=document.getElementById('cuentaReteIVA');
//     if(id!=""){
//       if (id==1) {
//         numeroItems.style.visibility="visible";
//         formatoImpresion.style.visibility="visible";
//         numeroCopias.style.visibility="visible";
//         cruceE.style.visibility="hidden";
//         obligaCruce.style.visibility="hidden";
//         cuentaBancoG.style.display="none";
//         cuentasR.style.display="none";
//         marcaBaseGrabable.style.visibility="hidden";
//       }
//       if (id==2 || id==10) {
//         numeroItems.style.visibility="hidden";
//         formatoImpresion.style.visibility="hidden";
//         numeroCopias.style.visibility="hidden";
//         cruceE.style.visibility="hidden";
//         obligaCruce.style.visibility="hidden";
//         cuentaBancoG.style.display="none";
//         cuentasR.style.display="none";
//         marcaBaseGrabable.style.visibility="hidden";
//       }
//       if (id==3) {
//         numeroItems.style.visibility="visible";
//         formatoImpresion.style.visibility="visible";
//         numeroCopias.style.visibility="visible";
//         cruceE.style.visibility="hidden";
//         obligaCruce.style.visibility="hidden";
//         cuentaBancoG.style.display="none";
//         cuentasR.style.display="none";
//         marcaBaseGrabable.style.visibility="hidden";
//       }
//       if (id==4) {
//         numeroItems.style.visibility="visible";
//         formatoImpresion.style.visibility="visible";
//         numeroCopias.style.visibility="visible";
//         cruceE.style.visibility="hidden";
//         obligaCruce.style.visibility="hidden";
//         cuentaBancoG.style.display="none";
//         cuentasR.style.display="none";
//         marcaBaseGrabable.style.visibility="hidden";
//       }
//       if (id==5) {
//         numeroItems.style.visibility="visible";
//         formatoImpresion.style.visibility="visible";
//         numeroCopias.style.visibility="visible";
//         cruceE.style.visibility="visible";
//         obligaCruce.style.visibility="visible";
//         cuentaBancoG.style.display="none";
//         cuentasR.style.display="none";
//         marcaBaseGrabable.style.visibility="hidden";
              
//         sHtml="<option value='1'>Ninguno</option>"+"<option value='2'>Cruce con O.compra</option> "; 
//         $("#tipoCruceE").html(sHtml);

//       }
//       if (id==6 || id==9) {
//         cuenta.style.display= "block";
//         tipoCruce.style.visibility= "visible";
//         manejoDescuento.style.visibility= "visible";
//         numeroItems.style.visibility="visible";
//         formatoImpresion.style.visibility="visible";
//         numeroCopias.style.visibility="visible";
//         cruceE.style.visibility="hidden";
//         obligaCruce.style.visibility="hidden";
//         cuentaBancoG.style.display="none";
//         cuentasR.style.display="none";
//         marcaBaseGrabable.style.visibility="hidden";
//         cuentaReteIVA.style.visibility="visible";
//       }
//       if (id==7) {
//         numeroItems.style.visibility="visible";
//         formatoImpresion.style.visibility="visible";
//         numeroCopias.style.visibility="visible";
//         cruceE.style.visibility="hidden";
//         obligaCruce.style.visibility="hidden";
//         cuentaBancoG.style.display="block";
//         cuentasR.style.display="none";
//         marcaBaseGrabable.style.visibility="hidden";
//       }
//       if (id==8 || id==17) {
//         numeroItems.style.visibility="visible";
//         formatoImpresion.style.visibility="visible";
//         numeroCopias.style.visibility="visible";
//         cruceE.style.visibility="visible";
//         obligaCruce.style.visibility="hidden";
//         cuentaBancoG.style.display="none";
//         cuentasR.style.display="none";
//         marcaBaseGrabable.style.visibility="hidden";
//         sHtml2="<option value='1'>Ninguno</option>"+"<option value='3'>Cruce con pedido</option>"; 
//         $("#tipoCruceE").html(sHtml2);

//       }
      
//       if (id==11) {
        
//         cuenta.style.display = "none";
//         tipoCruce.style.visibility= "hidden";
//         manejoDescuento.style.visibility= "hidden";
//         numeroItems.style.visibility="visible";
//         formatoImpresion.style.visibility="visible";
//         numeroCopias.style.visibility="visible";
//         cruceE.style.visibility="hidden";
//         obligaCruce.style.visibility="hidden";
//         cuentaBancoG.style.display="none";
//         cuentasR.style.display="none";
//         marcaBaseGrabable.style.visibility="hidden";
//       }
//       if (id==12) {
//         marcaBaseGrabable.style.visibility="visible";
//         numeroItems.style.visibility="visible";
//         formatoImpresion.style.visibility="visible";
//         numeroCopias.style.visibility="visible";
//         cruceE.style.visibility="hidden";
//         obligaCruce.style.visibility="hidden";
//         cuentaBancoG.style.display="none";
//         cuentasR.style.display="none";


//         cuenta.style.display = "none";
//         tipoCruce.style.visibility= "hidden";
//         manejoDescuento.style.visibility= "hidden";
        
//         ensamble.style.visibility="hidden";
//       }
//       if (id==13) {
//         marcaBaseGrabable.style.visibility="hidden";
//         cuenta.style.display= "none";
//         ensamble.style.visibility="visible";
//         numeroItems.style.visibility="visible";
//         formatoImpresion.style.visibility="visible";
//         numeroCopias.style.visibility="visible";
//         cruceE.style.visibility="hidden";
//         obligaCruce.style.visibility="hidden";
//         cuentaBancoG.style.display="none";
//         cuentasR.style.display="none";
//       }
//       if (id==14) {
//         marcaBaseGrabable.style.visibility="hidden";
//         cuenta.style.display= "none";
//         numeroItems.style.visibility="visible";
//         formatoImpresion.style.visibility="visible";
//         numeroCopias.style.visibility="visible";
//         cruceE.style.visibility="hidden";
//         obligaCruce.style.visibility="hidden";
//         cuentaBancoG.style.display="none";
//         ensamble.style.visibility="hidden";
//         cuentasR.style.display="none";
//       }
//       if (id==15) {
//         marcaBaseGrabable.style.visibility="hidden";
//         cuenta.style.display= "none";
//         numeroItems.style.visibility="visible";
//         formatoImpresion.style.visibility="visible";
//         numeroCopias.style.visibility="visible";
//         cruceE.style.visibility="hidden";
//         obligaCruce.style.visibility="hidden";
//         cuentaBancoG.style.display="none";
//         cuentasR.style.display="block";
//       }
//       if (id==16) {
//         marcaBaseGrabable.style.visibility="hidden";
//         cuenta.style.display= "none";
//         tipoCruce.style.visibility= "visible";
//         numeroItems.style.visibility="visible";
//         formatoImpresion.style.visibility="visible";
//         numeroCopias.style.visibility="visible";
//         cruceE.style.visibility="hidden";
//         obligaCruce.style.visibility="hidden";
//         cuentaBancoG.style.display="none";
//         cuentasR.style.display="none";
//       }
//       if (id==18) {
//         marcaBaseGrabable.style.visibility="hidden";
//         cuentaReteIVA.style.visibility="hidden";
//         cuenta.style.display= "block";
//         numeroItems.style.visibility="visible";
//         formatoImpresion.style.visibility="visible";
//         numeroCopias.style.visibility="visible";
//         cruceE.style.visibility="hidden";
//         obligaCruce.style.visibility="hidden";
//         cuentaBancoG.style.display="none";
//         cuentasR.style.display="none";
//       }
//       if (id!=11 && id!=6 && id!=9 && id!=12 && id!=13 && id!=16 && id!=18){
//         cuenta.style.display = "none";
//         tipoCruce.style.visibility= "hidden";
//         manejoDescuento.style.visibility= "hidden";
//         marcaBaseGrabable.style.visibility="hidden";
//         ensamble.style.visibility="hidden";

//       }

//     }else{

//       cuenta.style.display= "none";
//       tipoCruce.style.visibility= "hidden";
//       manejoDescuento.style.visibility= "hidden";
//       cruceE.style.visibility="hidden";
//       obligaCruce.style.visibility="hidden";

//     }
// });

