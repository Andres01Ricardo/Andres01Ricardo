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
        text: 'Está a punto de cargar estos comprobantes a la contabilidad!',
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
            url:URL+"functions/comprobantes/guardarcomprobantecargado.php", 
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
                  title: 'Comprobantes cargados!',
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
                ).then((result) => {
                })
              }
          });
          });
        }
      })
      }
  })



// ----------------------------------------------------------------------------------------------------------------------------------------------



// ----------------------------------------------------------------------------------------------------------------------------------------------

$("#excel").change(function(e){

  var reader = new FileReader();
  reader.readAsArrayBuffer(e.target.files[0]);
  reader.onload = function(e){
    var data = new Uint8Array(reader.result);
    var wb = XLSX.read(data,  {type:"array"});
    console.log('ingreso');
    // console.log(wb);
    var name = wb.SheetNames[0];
    var nameS=name.toString();
    console.log(wb.Sheets[nameS]);
    var regex = /(\d+)/g;
    var filas = wb.Sheets[nameS]['!ref'].split(':');
    var numeroFilas=filas[1].match(regex)
  
    var tabla=0;
    var sHtml='<div class="col-md-12"><table class="table table-striped mayusculas" id="tableComprobantes['+tabla+']"><thead><th>Cuenta</th><th>CC</th> <th>SC</th><th>Tercero</th><th>Descripción</th><th>Base</th><th>Débito</th><th>crédito</th></thead><tbody>';
    var eHtml='';
    var debito='0';
    var credito='0';
    var j =0;
    var cont=0;
    var tipoC='';
    var tipo='';
    var comprobanteT='';
    var numero=0;
    var control=1;
    var fecha='';
    var corrido=0;
    for (var i = 8; i <= numeroFilas; i++) {
        if (wb.Sheets[nameS]['A'+i] != undefined) {
          if (control==1) {
            tipoC=wb.Sheets[nameS]['B'+i].w.split('-');
            tipo=tipoC[0];
            comprobanteT=parseInt(tipoC[1]);
            numero=parseInt(wb.Sheets[nameS]['C'+i].w);
            fecha=wb.Sheets[nameS]['A'+i].w;
            sHtml+='<div class="row"><div class="col-md-3"><div class="form-group"><label class="negrita">Tipo:</label><input type="text" class="form-control" name="item['+tabla+'][tipo]" value="'+tipo+'" readonly></div></div><div class="col-md-3"><div class="form-group"><label class="negrita">Comprobante:</label><input type="text" class="form-control" name="item['+tabla+'][comprobante]" value="'+comprobanteT+'" readonly></div></div><div class="col-md-3"><div class="form-group"><label class="negrita">Fecha:</label><input type="text" class="form-control" name="item['+tabla+'][fecha]" value="'+fecha+'" readonly></div></div><div class="col-md-3"><div class="form-group"><label class="negrita">Número:</label><input type="text" class="form-control" name="item['+tabla+'][numero]" value="'+numero+'" readonly></div></div></div>';  
            // $("#divEncabezado").append(eHtml);
          }
          if (wb.Sheets[nameS]['N'+i]!=undefined) {
            if (wb.Sheets[nameS]['N'+i].w==undefined) {
              if (wb.Sheets[nameS]['N'+i].v!=undefined) {
                debito=wb.Sheets[nameS]['N'+i].v;
              }
              if (wb.Sheets[nameS]['N'+i].v==undefined) {
                debito=' 0.0 ';
              }
            }
            // if () {

            // }
            if (wb.Sheets[nameS]['N'+i].w!=undefined) {
              if (isNaN(eliminarMoneda(wb.Sheets[nameS]['N'+i].w,",",""))) {
                  if (wb.Sheets[nameS]['O'+i].w!=undefined) {
                    debito=wb.Sheets[nameS]['O'+i].w.trim();
                  }
                  if (wb.Sheets[nameS]['O'+i].w==undefined) {
                    debito=wb.Sheets[nameS]['O'+i].v;
                  }
                  if (wb.Sheets[nameS]['P'+i]!=undefined) {
                    if (wb.Sheets[nameS]['P'+i].w!=undefined) {
                      credito=wb.Sheets[nameS]['P'+i].w.trim();
                    }
                    if (wb.Sheets[nameS]['P'+i].w==undefined) {
                      credito=wb.Sheets[nameS]['P'+i].v;
                    }
                  }
                  

                  var centroCosto=wb.Sheets[nameS]['I'+i].w.trim(); 
                  var subcentroCosto=wb.Sheets[nameS]['J'+i].w.trim(); 
                  var detalle = wb.Sheets[nameS]['N'+i].w.trim();
                  var base = wb.Sheets[nameS]['K'+i].w.trim();

                    corrido=1;
              }
              if (!isNaN(eliminarMoneda(wb.Sheets[nameS]['N'+i].w,",",""))) {
                debito=wb.Sheets[nameS]['N'+i].w.trim();

                if (wb.Sheets[nameS]['O'+i]!=undefined) {
                  if (wb.Sheets[nameS]['O'+i].w!=undefined) {
                    credito=wb.Sheets[nameS]['O'+i].w.trim();
                  }
                  if (wb.Sheets[nameS]['O'+i].w==undefined) {
                    credito=wb.Sheets[nameS]['O'+i].v;
                  }
                }

                corrido=0;
              }
            }
          }
          if (corrido==0) {
            if (wb.Sheets[nameS]['O'+i]!=undefined) {
              if (wb.Sheets[nameS]['O'+i].w==undefined) {
                if (wb.Sheets[nameS]['O'+i].v!=undefined) {
                  credito=wb.Sheets[nameS]['O'+i].v;
                }
                if (wb.Sheets[nameS]['O'+i].v==undefined) {
                  credito='0.0';
                }
              }
              
              if (wb.Sheets[nameS]['O'+i].w!=undefined) {
                credito=wb.Sheets[nameS]['O'+i].w.trim();
              }
            }  
          }
          

        var cuentaC=wb.Sheets[nameS]['F'+i].w+'-'+wb.Sheets[nameS]['G'+i].w;
        if (wb.Sheets[nameS]['F'+i].w=='0000000000') {
          var tercero=wb.Sheets[nameS]['E'+i].w;
        }
        if (wb.Sheets[nameS]['F'+i].w!='0000000000') {
          var tercero=wb.Sheets[nameS]['E'+i].w.trim();
        }

          // var centroCosto=$(elemento).val();
          if (corrido==0) {
            if (wb.Sheets[nameS]['H'+i]!=undefined) {
              if (wb.Sheets[nameS]['H'+i].w==undefined) {
                if (wb.Sheets[nameS]['H'+i].v!=undefined) {
                
                  var centroCosto=wb.Sheets[nameS]['H'+i].v.trim(); 
                }
                
              }
              if (wb.Sheets[nameS]['H'+i].w!=undefined) {
                
                var centroCosto=wb.Sheets[nameS]['H'+i].w.trim(); 
              }
            }
            if (wb.Sheets[nameS]['H'+i]==undefined) {
              var centroCosto='';
            }
            var subcentroCosto=wb.Sheets[nameS]['I'+i].w.trim(); 
            var detalle = wb.Sheets[nameS]['M'+i].w.trim();
            var base = wb.Sheets[nameS]['J'+i].w.trim();
          }
          var letreroCC=0;
          // if (centroCosto!="") {
          //   $.ajax({
          //     url:URL+"functions/comprobantes/verificarcentrocosto.php", 
          //     type:"POST", 
          //     data: {"centroCosto":centroCosto,"subcentroCosto":subcentroCosto,"idEmpresa":$("#idEmpresa").val()},             
          //     dataType: "json",
          //     }).done(function(msg){  
          //       console.log(msg);
          //       console.log('****');
          //       if (msg.msg==0) {
          //         letreroCC=1;
          //         $("[name='item["+tabla+"]["+cont+"][letreroCentroCosto]']").removeClass("ocultar");
                  
          //         console.log('ingreso');
          //         console.log(tabla);
          //         console.log(cont);
          //       }
          //       if (msg.msg==2 || msg.msg==1 || msg.msg==3) {
          //         letreroCC=0;
          //       }

          //   });  
          // }
        
        
        
      
        sHtml+='<tr>';
        sHtml+='<td><input type="text" name="item['+tabla+']['+cont+'][cuentaContable]" id="item['+tabla+']['+cont+'][cuentaContable]" class="form-control cuentaContable mayusculas"  placeholder="Cuenta" value="'+cuentaC.trim()+'" readonly></td>';
        
    
        sHtml+='<td><input type="text" name="item['+tabla+']['+cont+'][centroCosto]" id="item['+tabla+']['+cont+'][centroCosto]" class="form-control centroCosto mayusculas"  placeholder="centro costo" value="'+centroCosto+'" readonly><span name="item['+tabla+']['+cont+'][letreroCentroCosto]" class="ocultar">No existe</span></td>';  
      
        sHtml+='<td><input type="text" name="item['+tabla+']['+cont+'][subcentroCosto]" id="item['+tabla+']['+cont+'][subcentroCosto]" class="form-control subcentroCosto mayusculas"  placeholder="Subcentro costo" value="'+subcentroCosto+'" readonly></td>';
        sHtml+='<td><input type="text" name="item['+tabla+']['+cont+'][tercero]" id="item['+tabla+']['+cont+'][tercero]" class="form-control mayusculas"  placeholder="tercero" value="'+tercero+'" readonly></td>';
        sHtml+='<td><input type="text" name="item['+tabla+']['+cont+'][descripcion]" id="item['+tabla+']['+cont+'][descripcion]" class="form-control descripcion mayusculas"  placeholder="Descripción" value="'+detalle+'" readonly></td>';
        sHtml+='<td><input type="text" name="item['+tabla+']['+cont+'][base]" id="item['+tabla+']['+cont+'][base]" class="form-control base mayusculas moneda"  placeholder="base" value="'+base+'" readonly></td>';
        sHtml+='<td><input type="text" name="item['+tabla+']['+cont+'][debito]" id="item['+tabla+']['+cont+'][debito]" class="form-control debito mayusculas moneda"  placeholder="debito" value="'+debito+'" readonly></td>';
        sHtml+='<td><input type="text" name="item['+tabla+']['+cont+'][credito]" id="item['+tabla+']['+cont+'][credito]" class="form-control credito mayusculas moneda"  placeholder="credito" value="'+credito+'" readonly></td>';

        
        // if (wb.Sheets[nameS]['N'+i].w==undefined) {
        //   console.log(wb.Sheets[nameS]['N'+i].v);
        // }
        // if (wb.Sheets[nameS]['N'+i].w!=undefined) {
        //   console.log(wb.Sheets[nameS]['N'+i].w);
        // }
        // // console.log(wb.Sheets[nameS]['O'+i].w);
        
        sHtml+='</tr>';
        cont++;
        control=0;
      }
      if (wb.Sheets[nameS]['A'+i] == undefined) {
        if(sHtml!=''){
          sHtml+='</tbody></table></div>';
          $("#divComprobanteCargado").append(sHtml);
          // $(".base").formatCurrency({decimalSymbol:',',digitGroupSymbol:'.'});
          // $(".debito").formatCurrency({decimalSymbol:',',digitGroupSymbol:'.'});
          // $(".credito").formatCurrency({decimalSymbol:',',digitGroupSymbol:'.'});
          $("#btnGuardarInfo").removeClass('ocultar');
        }
        j=i+1;
        sHtml='';
        cont=0;
        if (wb.Sheets[nameS]['A'+j] != undefined) {
          control=1;

        sHtml='<div class="col-md-12"><table class="table table-striped mayusculas" id="tableComprobantes['+tabla+']"><thead><th>Cuenta</th><th>Centro de costo</th> <th>Subcentro costo</th><th>Tercero </th><th>Descripción</th><th>Base</th><th>Débito</th><th>crédito</th></thead><tbody>';
         tabla++;
       }
      }
    }
    // recorrer();
    


  }

});



















  /*jshint browser:true */
/* eslint-env browser */
/*global Uint8Array */
/*global XLSX */
/* exported b64it, setfmt */
/* eslint no-use-before-define:0 */
// var X = XLSX;
// var XW = {
//   /* worker message */
//   msg: 'xlsx',
//   /* worker scripts */
//   worker: './../bundles/sheetjs/xlsxworker.js'
// };


// var global_wb;

// var process_wb = (function() {
//   var OUT = document.getElementById('out');
//   var HTMLOUT = document.getElementById('htmlout');

//   var get_format = (function() {
//     var radios = document.getElementsByName( "format" );
//     return function() {
//       for(var i = 0; i < radios.length; ++i) if(radios[i].checked || radios.length === 1) return radios[i].value;
//     };
//   })();

//   var to_json = function to_json(workbook) {
//     var result = {};
//     workbook.SheetNames.forEach(function(sheetName) {
//       var roa = X.utils.sheet_to_json(workbook.Sheets[sheetName], {header:1});
//       if(roa.length) result[sheetName] = roa;
//     });
//     console.log(result);
//     return JSON.stringify(result, 2, 2);
//   };

//   var to_csv = function to_csv(workbook) {
//     var result = [];
//     workbook.SheetNames.forEach(function(sheetName) {
//       var csv = X.utils.sheet_to_csv(workbook.Sheets[sheetName]);
//       if(csv.length){
//         result.push("SHEET: " + sheetName);
//         result.push("");
//         result.push(csv);
//       }
//     });
//     return result.join("\n");
//   };

//   var to_fmla = function to_fmla(workbook) {
//     var result = [];
//     workbook.SheetNames.forEach(function(sheetName) {
//       var formulae = X.utils.get_formulae(workbook.Sheets[sheetName]);
//       if(formulae.length){
//         result.push("SHEET: " + sheetName);
//         result.push("");
//         result.push(formulae.join("\n"));
//       }
//     });
//     return result.join("\n");
//   };

//   var to_html = function to_html(workbook) {
//     HTMLOUT.innerHTML = ""; 
//     console.log(workbook.SheetNames);
//     workbook.SheetNames.forEach(function(sheetName) {
//       var htmlstr = X.write(workbook, {sheet:sheetName, type:'string', bookType:'html'});
//       HTMLOUT.innerHTML += htmlstr;
//       console.log(htmlstr);
//     });
//     return "";
//   };

//   return function process_wb(wb) {
//     global_wb = wb;
//     var output = "";
//     switch(get_format()) {
//       case "form": output = to_fmla(wb); break;
//       case "html": output = to_html(wb); break;
//       case "json": output = to_json(wb); break;
//       default: output = to_csv(wb);
//     }
//     if(OUT.innerText === undefined) OUT.textContent = output;
//     else OUT.innerText = output;
//     if(typeof console !== 'undefined') console.log("output", new Date());
//   };
// })();

// var setfmt = window.setfmt = function setfmt() { if(global_wb) process_wb(global_wb); };

// var b64it = window.b64it = (function() {
//   var tarea = document.getElementById('b64data');
//   return function b64it() {
//     if(typeof console !== 'undefined') console.log("onload", new Date());
//     var wb = X.read(tarea.value, {type:'base64', WTF:false});
//     process_wb(wb);
//   };
// })();

// var do_file = (function() {
//   var rABS = typeof FileReader !== "undefined" && (FileReader.prototype||{}).readAsBinaryString;
//   // var domrabs = document.getElementsByName("userabs")[0];
//   // if(!rABS) domrabs.disabled = !(domrabs.checked = false);

//   // var use_worker = typeof Worker !== 'undefined';
//   var domwork = document.getElementsByName("useworker")[0];
//   // if(!use_worker) domwork.disabled = !(domwork.checked = false);

//   var xw = function xw(data, cb) {
//     var worker = new Worker(XW.worker);
//     worker.onmessage = function(e) {
//       switch(e.data.t) {
//         case 'ready': break;
//         case 'e': console.error(e.data.d); break;
//         case XW.msg: cb(JSON.parse(e.data.d)); break;
//       }
//     };
//     worker.postMessage({d:data,b:rABS?'binary':'array'});
//   };

//   return function do_file(files) {
//     // rABS = domrabs.checked;
//     // use_worker = domwork.checked;
//     var f = files[0];
//     var reader = new FileReader();
//     reader.onload = function(e) {
//       // if(typeof console !== 'undefined') console.log("onload", new Date(), rABS, use_worker);
//       var data = e.target.result;
//       if(!rABS) data = new Uint8Array(data);
//       // if(use_worker) xw(data, process_wb);
//       else process_wb(X.read(data, {type: rABS ? 'binary' : 'array'}));
//     };
//     if(rABS) reader.readAsBinaryString(f);
//     else reader.readAsArrayBuffer(f);
//   };
// })();

// (function() {
//   var drop = document.getElementById('drop');
//   if(!drop.addEventListener) return;

//   function handleDrop(e) {
//     e.stopPropagation();
//     e.preventDefault();
//     do_file(e.dataTransfer.files);
//   }

//   function handleDragover(e) {
//     e.stopPropagation();
//     e.preventDefault();
//     e.dataTransfer.dropEffect = 'copy';
//   }

//   drop.addEventListener('dragenter', handleDragover, false);
//   drop.addEventListener('dragover', handleDragover, false);
//   drop.addEventListener('drop', handleDrop, false);
// })();

// (function() {
//   var xlf = document.getElementById('xlf');
//   if(!xlf.addEventListener) return;
//   function handleFile(e) { do_file(e.target.files); }
//   xlf.addEventListener('change', handleFile, false);
// })();
//   var _gaq = _gaq || [];
//   _gaq.push(['_setAccount', 'UA-36810333-1']);
//   _gaq.push(['_trackPageview']);

//   (function() {
//     var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
//     ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
//     var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
//   })();


// var wb; // lee los datos completos
// var rABS = false; // Si leer el archivo como una cadena binaria

// function importf (obj) {// import
//   console.log('en la funcion');
//   console.log(obj);
//                 if(!obj.files) {
//                   console.log('retorno vacio');
//                     return;
//                 }
//                 var f = obj.files[0];
//                 var reader = new FileReader();
//                 reader.onload = function(e) {
//                     var data = e.target.result;
//                     console.log(data);
//                     if(rABS) {
//                                                  wb = XLSX.read (btoa (fixdata (data)), {// conversión manual
//                             type: 'base64'
//                         });
//                     } else {
//                         wb = XLSX.read(data, {
//                             type: 'binary'
//                         });
//                     }
//                                          //wb.SheetNames[0] es el nombre de la primera hoja en Obtener hojas
//                                          //wb.Sheets[Sheet name] Obtenga los datos de la primera Hoja
//                    console.log('ingreso');
//                    console.log(wb.Sheets[wb.SheetNames[0]]);
//                     document.getElementById("wrapper").innerHTML= JSON.stringify( XLSX.utils.sheet_to_json(wb.Sheets[wb.SheetNames[0]]) );
//                 };
//                 if(rABS) {
//                     reader.readAsArrayBuffer(f);
//                 } else {
//                     reader.readAsBinaryString(f);
//                 }
//             }
 
//               function fixdata (data) {// Transferencia de archivos BinaryString
//                 var o = "",
//                     l = 0,
//                     w = 10240;
//                 for(; l < data.byteLength / w; ++l) o += String.fromCharCode.apply(null, new Uint8Array(data.slice(l * w, l * w + w)));
//                 o += String.fromCharCode.apply(null, new Uint8Array(data.slice(l * w)));
//                 return o;
//             }



// var excelFile;
//     // lee el contenido del archivo
//     function showfile(obj) {
//       if(!obj.files) {
//         return;
//       }
//       var f = obj.files[0];
//       var reader = new FileReader();
//       reader.readAsBinaryString(f);
//       reader.onload = function(e) {
//         var data = e.target.result;
//         excelFile = XLSX.read(data, {
//           type: 'binary'
//         });

        // Mostrar todas las tablas
        // for(var i=0;i<excelFile.SheetNames.length;i++){
        //  　document.getElementById("excelFile").innerHTML +=excelFile.SheetNames[i]+"="+JSON.stringify(XLSX.utils.sheet_to_json(excelFile.Sheets[excelFile.SheetNames[i]]))+"<br/>";
        // 　　　　　　}

        // var dataTable1 = "";
        // Mostrar solo la primera tabla
        // var headers = new Array();
        // var str = XLSX.utils.sheet_to_json(excelFile.Sheets[excelFile.SheetNames[0]])
        // console.log(str);
        // dataTable1+= "<table border='1'><tr>"
        // for(var key in str[0]){
          // headers.push(key)  // Obtener el encabezado
          // dataTable1 += "<th>" + key + "</th>"
        // }
        // dataTable1 += "</tr>"
        // console.log(headers)
        
        // Las primeras cinco líneas se muestran aquí
        // for(var i=0;i<5;i++){
        //   // var json = JSON.stringify(str[i])
        //   dataTable1 += "<tr>"
        //   var json = str[i]
        //   for( var j=0;j<headers.length;j++){
        //     dataTable1 += "<td>" + json[headers[j]] + "</td>";
        //   }
        //   dataTable1 += "</tr><br/>";
        // }

        // dataTable1 += "</table>"
        // document.getElementById("excelFile").innerHTML = dataTable1
// 
      // }
    // }



// $("body").on("click touchstart","#btnGuardarInfo",function(e){

//     e.preventDefault();

//       if(true === $("#frmGuardar").parsley().validate()){
//       Swal.fire({
//         title: 'Está seguro?',
//         text: 'Está a punto de guardar este estado financiero!',
//         icon: 'warning', 
//         showCancelButton: true,
//         showLoaderOnConfirm: true,
//         confirmButtonText: `Si, Guardar!`,
//         cancelButtonText:'Cancelar',
//         preConfirm: function(result) {
//           return new Promise(function(resolve) {
//             var formu = document.getElementById("frmGuardar");
//             var data = new FormData(formu);
//             $.ajax({
//             url:URL+"functions/dashboard/guardarestadofinanciero.php", 
//             type:"POST", 
//             data: data,
//             contentType:false, 
//             processData:false, 
//             dataType: "json",
//             cache:false 
//             }).done(function(msg){  
//               if(msg.msg){
//                 Swal.fire(
//                  {icon: 'success',
//                   title: 'Estado Financiero Guardado!',
//                   text: 'con exito',
//                   closeOnConfirm: true,
//                 }
//                 ).then((result) => {
//                  location.reload(); 
//                 })
//               }else{
//                  Swal.fire(
//                   'Algo ha salido mal!',
//                   'Verifique su conexión a internet',
//                   'error'
//                 )
//               }
//           }); 
//           });
//         }
//       })
//       }
//   })

