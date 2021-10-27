$("body").on("click touchstart","#btnGuardar",function(e){
    e.preventDefault();
    if($("#excel").val()!=""){
      var formu = document.getElementById("frmGuardar");
      var data = new FormData(formu);
      $.ajax({
      url:URL+"functions/comprobantes/leercomprobante.php", 
      type:"POST", 
      data: data, 
      contentType:false, 
      processData:false, 
      dataType: "json",
      cache:false
      }).done(function(msg){  
        console.log(msg);
  
    });
    }
})

// $("body").on("click touchstart","#btnGuardarInfo",function(e){
//     e.preventDefault();
    
//       var formu = document.getElementById("frmGuardar");
//       var data = new FormData(formu);
//       $.ajax({
//       url:URL+"functions/comprobantes/leercomprobante.php", 
//       type:"POST", 
//       data: data, 
//       contentType:false, 
//       processData:false, 
//       dataType: "json",
//       cache:false
//       }).done(function(msg){  
//         console.log(msg);
  
//     });
    
// }

$("body").on("click touchstart","#btnGuardarInfo",function(e){
    e.preventDefault();
      if(true === $("#frmGuardar").parsley().validate()){
         Swal.fire({
        title: '¿Está seguro?',
        text: 'Está a punto de cargar estas lineas y grupos de inventario!',
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
            url:URL+"functions/inventario/guardarlineasgruposcargados.php", 
            type:"POST", 
            data: data,
            contentType:false, 
            processData:false, 
            dataType: "json",
            cache:false 
            }).done(function(msg){  
              if(msg.msg){
                if (msg.fallos.length!=0) {
                  var codigosFallos='';
                   msg.fallos.forEach(function(element,index){
                    codigosFallos+=element+', ';
                  })
                    Swal.fire(
                      {
                        icon: 'success',
                        title: 'Los grupos '+codigosFallos+ 'no se puedieron crear',
                        text: 'Falta crear las cuentas contables',
                        closeOnConfirm: true,
                      }
                    ).then((result) => {
                     location.reload(); 
                    })
                }
                if (msg.fallos.length==0) {
                  Swal.fire(
                    {
                    icon: 'success',
                    title: 'Lineas y grupos cargados!',
                    text: 'con exito',
                    closeOnConfirm: true,
                  }
                  ).then((result) => {
                   location.reload(); 
                  })
                }


              }else{
                 Swal.fire(
                  'Algo ha salido mal!',
                  'Verifique su conexión a internet',
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


var sHtmlSelect='';
  var idEmpresa=$("#idEmpresa").val();
// ----------------------------------------------------------------------------------------------------------------------------------------------
// $( window ).on( "load", function() {

// var idEmpresa=$("#idEmpresa").val();
// sHtmlSelect='<option value="">Seleccione</option>';

//     $.ajax({
//         url:URL+"functions/cuentascontables/cargarcuentascontables.php", 
//         type:"POST", 
//         data: {"idEmpresa":idEmpresa}, 
//         dataType: "json",
//         }).done(function(msg){  
//           // var $aDatos=[];
//           console.log(msg);
//           if (msg.length==0) {

//           }
//           if (msg.length!=0) {
//           msg.forEach(function(element,index){
//             sHtmlSelect+='<option value="'+element.idCuentaContable+'00" codigo="'+element.codigoCuentaContable+'">'+element.codigoCuentaContable+' - '+element.nombre+'</option>';
//           })
//           // $("#idCuentaDevolucion").html(sHtmlSelect);
//         }
//       }); 

// })
// ----------------------------------------------------------------------------------------------------------------------------------------------

$("#excel").change(function(e){



  

  var reader = new FileReader();
  reader.readAsArrayBuffer(e.target.files[0]);
  reader.onload = function(e){
    var data = new Uint8Array(reader.result);
    var wb = XLSX.read(data,  {type:"array"});
    // console.log('ingreso');
    // console.log(wb);
    // console.log('paso');


    var name = wb.SheetNames[0];
    var nameS=name.toString();
    
    var regex = /(\d+)/g;
    var filas = wb.Sheets[nameS]['!ref'].split(':');
    var numeroFilas=filas[1].match(regex)
    console.log(numeroFilas);
    console.log(wb.Sheets[nameS]);
    if (numeroFilas>306) {
      numeroFilas=306;
      alert('solo se pueden cargar 300 items por archivo');
    }

    var sHtml='<div class="col-md-12"><table class="table table-striped mayusculas centrar" id="tableLineasGrupos"><thead><th>Código Línea</th><th>Línea</th><th>Código Grupo</th><th>Grupo</th><th>Inventario</th><th>Costo</th><th>Venta</th><th>Devolución</th></thead><tbody>';

    for (var i = 6; i <= numeroFilas; i++) {
        if (wb.Sheets[nameS]['A'+i] != undefined) {
          // if (control==1) {


            if (wb.Sheets[nameS]['A'+i].w==undefined) {
              var codigoLinea=wb.Sheets[nameS]['A'+i].v.trim();
            }
            if (wb.Sheets[nameS]['A'+i].w!=undefined) {
              var codigoLinea=wb.Sheets[nameS]['A'+i].w.trim();
            }


            if (wb.Sheets[nameS]['B'+i].w==undefined) {
              var linea=wb.Sheets[nameS]['B'+i].v.trim();
            }

            if (wb.Sheets[nameS]['B'+i].w!=undefined) {
              var linea=wb.Sheets[nameS]['B'+i].w.trim();
            }


            if (wb.Sheets[nameS]['C'+i].w==undefined) {
              var codigoGrupo=wb.Sheets[nameS]['C'+i].v.trim();
            }
            if (wb.Sheets[nameS]['C'+i].w!=undefined) {
              var codigoGrupo=wb.Sheets[nameS]['C'+i].w.trim();
            }


            if (wb.Sheets[nameS]['D'+i].w==undefined) {
              var grupo=wb.Sheets[nameS]['D'+i].v.trim();
            }
            if (wb.Sheets[nameS]['D'+i].w!=undefined) {
              var grupo=wb.Sheets[nameS]['D'+i].w.trim();
            }




            if (wb.Sheets[nameS]['E'+i].w==undefined) {
              var inventario=wb.Sheets[nameS]['E'+i].v.trim();
            }
            if (wb.Sheets[nameS]['E'+i].w!=undefined) {
              var inventario=wb.Sheets[nameS]['E'+i].w.trim();
            }




            if (wb.Sheets[nameS]['F'+i].w==undefined) {
              var costo=wb.Sheets[nameS]['F'+i].v.trim();
            }
            if (wb.Sheets[nameS]['F'+i].w!=undefined) {
              var costo=wb.Sheets[nameS]['F'+i].w.trim();
            }




            if (wb.Sheets[nameS]['G'+i].w==undefined) {
              var venta=wb.Sheets[nameS]['G'+i].v.trim();
            }
            if (wb.Sheets[nameS]['G'+i].w!=undefined) {
              var venta=wb.Sheets[nameS]['G'+i].w.trim();
            }




            if (wb.Sheets[nameS]['H'+i].w==undefined) {
              var devolucion=wb.Sheets[nameS]['H'+i].v.trim();
            }
            if (wb.Sheets[nameS]['H'+i].w!=undefined) {
              var devolucion=wb.Sheets[nameS]['H'+i].w.trim();
            }



 
            sHtml+='<tr>';
              sHtml+='<td><input type="text" name="item['+i+'][codigoLinea]" id="item['+i+'][codigoLinea]" class="form-control mayusculas centrar"  placeholder="credito" value="'+codigoLinea+'" readonly></td>';
              sHtml+='<td><input type="text" name="item['+i+'][linea]" id="item['+i+'][linea]" class="form-control mayusculas centrar"  placeholder="credito" value="'+linea+'" readonly></td>';
              sHtml+='<td><input type="text" name="item['+i+'][codigoGrupo]" id="item['+i+'][codigoGrupo]" class="form-control mayusculas centrar"  placeholder="credito" value="'+codigoGrupo+'" readonly></td>';
              sHtml+='<td><input type="text" name="item['+i+'][grupo]" id="item['+i+'][grupo]" class="form-control mayusculas centrar"  placeholder="credito" value="'+grupo+'" readonly></td>';
              sHtml+='<td><input type="text" name="item['+i+'][inventario]" id="item['+i+'][inventario]" class="form-control mayusculas centrar"  placeholder="credito" value="'+inventario+'" readonly></td>';
              sHtml+='<td><input type="text" name="item['+i+'][costo]" id="item['+i+'][costo]" class="form-control mayusculas centrar"  placeholder="credito" value="'+costo+'" readonly></td>';
              sHtml+='<td><input type="text" name="item['+i+'][venta]" id="item['+i+'][venta]" class="form-control mayusculas centrar"  placeholder="credito" value="'+venta+'" readonly></td>';
              sHtml+='<td><input type="text" name="item['+i+'][devolucion]" id="item['+i+'][devolucion]" class="form-control mayusculas centrar"  placeholder="credito" value="'+devolucion+'" readonly></td>';

            sHtml+='</tr>';

      }

    }
    sHtml+='</tbody></table></div>';
    $("#divComprobanteCargado").append(sHtml);
    $("#btnGuardarInfo").removeClass('ocultar');


    // recorrer();
  
  }

});





recorrer = function(){

  $("#tableLineasGrupos tbody tr").each(function (index) {
      // $(this).children("td").each(function (index2) {

      //   alert(index2);

      // }) 


      var inventario=document.getElementById("item["+i+"][inventario]");
      var costo=document.getElementById("item["+i+"][costo]");
      var venta=document.getElementById("item["+i+"][venta]");
      var devolucion=document.getElementById("item["+i+"][devolucion]");


      var idEmpresa=$("#idEmpresa").val();
    // sHtmlSelect='<option value="">Seleccione</option>';

        $.ajax({
            url:URL+"functions/inventario/cargarcuentacontable.php", 
            type:"POST", 
            data: {"idEmpresa":idEmpresa,"codigo":inventario.value}, 
            dataType: "json",
            }).done(function(msg){  
              // var $aDatos=[];
              console.log(msg);
              if (msg.length==0) {
                
              }
              if (msg.length!=0) {
              msg.forEach(function(element,index){
                sHtmlSelect+='<option value="'+element.idCuentaContable+'" codigo="'+element.codigoCuentaContable+'">'+element.codigoCuentaContable+' - '+element.nombre+'</option>';
              })
              // $("#idCuentaDevolucion").html(sHtmlSelect);
            }
          }); 


          $.ajax({
            url:URL+"functions/inventario/cargarcuentacontable.php", 
            type:"POST", 
            data: {"idEmpresa":idEmpresa,"codigo":costo.value}, 
            dataType: "json",
            }).done(function(msg){  
              // var $aDatos=[];
              console.log(msg);
              // if (msg.length==0) {

              // }
              if (msg.length!=0) {
              msg.forEach(function(element,index){
                sHtmlSelect+='<option value="'+element.idCuentaContable+'00" codigo="'+element.codigoCuentaContable+'">'+element.codigoCuentaContable+' - '+element.nombre+'</option>';
              })
              // $("#idCuentaDevolucion").html(sHtmlSelect);
            }
          }); 


          $.ajax({
            url:URL+"functions/inventario/cargarcuentacontable.php", 
            type:"POST", 
            data: {"idEmpresa":idEmpresa,"codigo":venta.value}, 
            dataType: "json",
            }).done(function(msg){  
              // var $aDatos=[];
              console.log(msg);
              // if (msg.length==0) {

              // }
              if (msg.length!=0) {
              msg.forEach(function(element,index){
                sHtmlSelect+='<option value="'+element.idCuentaContable+'00" codigo="'+element.codigoCuentaContable+'">'+element.codigoCuentaContable+' - '+element.nombre+'</option>';
              })
              // $("#idCuentaDevolucion").html(sHtmlSelect);
            }
          }); 


          $.ajax({
            url:URL+"functions/inventario/cargarcuentacontable.php", 
            type:"POST", 
            data: {"idEmpresa":idEmpresa,"codigo":devolucion.value}, 
            dataType: "json",
            }).done(function(msg){  
              // var $aDatos=[];
              console.log(msg);
              // if (msg.length==0) {

              // }
              if (msg.length!=0) {
              msg.forEach(function(element,index){
                sHtmlSelect+='<option value="'+element.idCuentaContable+'00" codigo="'+element.codigoCuentaContable+'">'+element.codigoCuentaContable+' - '+element.nombre+'</option>';
              })
              // $("#idCuentaDevolucion").html(sHtmlSelect);
            }
          }); 

  })

}