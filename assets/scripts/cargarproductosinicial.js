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
        text: 'Está a punto de crear estos productos cargados!',
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
            url:URL+"functions/inventario/guardarproductoscargados.php", 
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
                        title: 'Los productos '+codigosFallos+ 'no se puedieron crear',
                        text: 'El grupo no existe o el producto ya existe',
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
                    title: 'Productos creados!',
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

    var sHtml='<div class="col-md-12"><table class="table table-striped mayusculas centrar" id="tableLineasGrupos"><thead><th>Cód Grupo</th><th>Cód producto</th><th>Descripción</th><th>IVA</th><th>Costo promedio</th><th>Tarifa</th><th>Precio1</th><th>Precio2</th><th>Precio3</th><th>Precio4</th></thead><tbody>';

    for (var i = 6; i <= numeroFilas; i++) {
        if (wb.Sheets[nameS]['A'+i] != undefined) {
          // if (control==1) {


            // if (wb.Sheets[nameS]['A'+i].w==undefined) {
            //   var codigoLinea=wb.Sheets[nameS]['A'+i].v.trim();
            // }
            // if (wb.Sheets[nameS]['A'+i].w!=undefined) {
            //   var codigoLinea=wb.Sheets[nameS]['A'+i].w.trim();
            // }


            if (wb.Sheets[nameS]['A'+i].w==undefined) {
              var codigoGrupo=wb.Sheets[nameS]['A'+i].v.trim();
            }

            if (wb.Sheets[nameS]['A'+i].w!=undefined) {
              var codigoGrupo=wb.Sheets[nameS]['A'+i].w.trim();
            }


            if (wb.Sheets[nameS]['B'+i].w==undefined) {
              var codigoProducto=wb.Sheets[nameS]['B'+i].v.trim();
            }
            if (wb.Sheets[nameS]['B'+i].w!=undefined) {
              var codigoProducto=wb.Sheets[nameS]['B'+i].w.trim();
            }


            if (wb.Sheets[nameS]['C'+i].w==undefined) {
              var producto=wb.Sheets[nameS]['C'+i].v.trim();
            }
            if (wb.Sheets[nameS]['C'+i].w!=undefined) {
              var producto=wb.Sheets[nameS]['C'+i].w.trim();
            }




            if (wb.Sheets[nameS]['D'+i].w==undefined) {
              var iva=wb.Sheets[nameS]['D'+i].v.trim();
            }
            if (wb.Sheets[nameS]['D'+i].w!=undefined) {
              var iva=wb.Sheets[nameS]['D'+i].w.trim();
            }




            if (wb.Sheets[nameS]['E'+i].w==undefined) {
              var costoPromedio=wb.Sheets[nameS]['E'+i].v.trim();
            }
            if (wb.Sheets[nameS]['E'+i].w!=undefined) {
              var costoPromedio=wb.Sheets[nameS]['E'+i].w.trim();
            }

            if (wb.Sheets[nameS]['F'+i].w==undefined) {
              var tarifa=wb.Sheets[nameS]['F'+i].v.trim();
            }
            if (wb.Sheets[nameS]['F'+i].w!=undefined) {
              var tarifa=wb.Sheets[nameS]['F'+i].w.trim();
            }


            if(wb.Sheets[nameS]['G'+i]!=undefined){
                if (wb.Sheets[nameS]['G'+i].w==undefined) {
                  if (wb.Sheets[nameS]['G'+i].v!=undefined) {
  
                  var precio1=wb.Sheets[nameS]['G'+i].v.trim();
                  }
                  if (wb.Sheets[nameS]['G'+i].v==undefined) {
                    var precio1='';
                  }
                }
                if (wb.Sheets[nameS]['G'+i].w!=undefined) {
                  var precio1=wb.Sheets[nameS]['G'+i].w.trim();
                }
              }
              if(wb.Sheets[nameS]['G'+i]==undefined){
                var precio1='';
              }


            if(wb.Sheets[nameS]['H'+i]!=undefined){
                if (wb.Sheets[nameS]['H'+i].w==undefined) {
                  if (wb.Sheets[nameS]['H'+i].v!=undefined) {
  
                  var precioDos=wb.Sheets[nameS]['H'+i].v.trim();
                  }
                  if (wb.Sheets[nameS]['H'+i].v==undefined) {
                    var precioDos='';
                  }
                }
                if (wb.Sheets[nameS]['H'+i].w!=undefined) {
                  var precioDos=wb.Sheets[nameS]['H'+i].w.trim();
                }
              }
              if(wb.Sheets[nameS]['H'+i]==undefined){
                var precioDos='';
              }


              if(wb.Sheets[nameS]['I'+i]!=undefined){
                if (wb.Sheets[nameS]['I'+i].w==undefined) {
                  if (wb.Sheets[nameS]['I'+i].v!=undefined) {
  
                  var precioTres=wb.Sheets[nameS]['I'+i].v.trim();
                  }
                  if (wb.Sheets[nameS]['I'+i].v==undefined) {
                    var precioTres='';
                  }
                }
                if (wb.Sheets[nameS]['I'+i].w!=undefined) {
                  var precioTres=wb.Sheets[nameS]['I'+i].w.trim();
                }
              }
              if(wb.Sheets[nameS]['I'+i]==undefined){
                var precioTres='';
              }
            
            if(wb.Sheets[nameS]['J'+i]!=undefined){
                if (wb.Sheets[nameS]['J'+i].w==undefined) {
                  if (wb.Sheets[nameS]['J'+i].v!=undefined) {
  
                  var precioCuatro=wb.Sheets[nameS]['J'+i].v.trim();
                  }
                  if (wb.Sheets[nameS]['J'+i].v==undefined) {
                    var precioCuatro='';
                  }
                }
                if (wb.Sheets[nameS]['J'+i].w!=undefined) {
                  var precioCuatro=wb.Sheets[nameS]['J'+i].w.trim();
                }
              }
              if(wb.Sheets[nameS]['J'+i]==undefined){
                var precioCuatro='';
              }
            
            var index=i-6;

            sHtml+='<tr>';
              // sHtml+='<td><input type="text" name="item['+i+'][codigoLinea]" id="item['+i+'][codigoLinea]" class="form-control mayusculas centrar"  placeholder="credito" value="'+codigoLinea+'" readonly></td>';
              sHtml+='<td><input type="text" name="item['+index+'][grupo]" id="item['+index+'][grupo]" class="form-control mayusculas centrar"  placeholder="" value="'+codigoGrupo+'" readonly></td>';
              sHtml+='<td><input type="text" name="item['+index+'][codigo]" id="item['+index+'][codigo]" class="form-control mayusculas centrar"  placeholder="" value="'+codigoProducto+'" readonly></td>';
              sHtml+='<td><input type="text" name="item['+index+'][nombre]" id="item['+index+'][nombre]" class="form-control mayusculas centrar"  placeholder="" value="'+producto+'" readonly></td>';
              sHtml+='<td><input type="text" name="item['+index+'][iva]" id="item['+index+'][iva]" class="form-control mayusculas centrar"  placeholder="" value="'+iva+'" readonly></td>';
              sHtml+='<td><input type="text" name="item['+index+'][costoPromedio]" id="item['+index+'][costoPromedio]" class="form-control mayusculas centrar"  placeholder="" value="'+costoPromedio+'" readonly></td>';
              
              sHtml+='<td><input type="text" name="item['+index+'][tarifa]" id="item['+index+'][tarifa]" class="form-control mayusculas centrar"  placeholder="" value="'+tarifa+'" readonly></td>';
              sHtml+='<td><input type="text" name="item['+index+'][precioUno]" id="item['+index+'][precioUno]" class="form-control mayusculas centrar"  placeholder="" value="'+precio1+'" readonly></td>';
              sHtml+='<td><input type="text" name="item['+index+'][precioDos]" id="item['+index+'][precioDos]" class="form-control mayusculas centrar"  placeholder="" value="'+precioDos+'" readonly></td>';
              sHtml+='<td><input type="text" name="item['+index+'][precioTres]" id="item['+index+'][precioTres]" class="form-control mayusculas centrar"  placeholder="" value="'+precioTres+'" readonly></td>';
              sHtml+='<td><input type="text" name="item['+index+'][precioCuatro]" id="item['+index+'][precioCuatro]" class="form-control mayusculas centrar"  placeholder="" value="'+precioCuatro+'" readonly></td>';
              
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