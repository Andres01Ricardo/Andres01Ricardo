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
    var controlTotal=0;
    $('.totalDebito ').each(function() {
      if ($(this).attr('total')==1) {
        controlTotal=1;
      }
      
    }); 
    if (controlTotal==0) {

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
                  if (msg.fallos.length==0) {
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
                  }
                  if (msg.fallos.length!=0) {
                    var codigosFallos='';
                     msg.fallos.forEach(function(element,index){
                      codigosFallos+=element+', ';
                    })
                    Swal.fire(
                      {
                      icon: 'success',
                      title: 'Los comprobantes'+codigosFallos+' no se cargaron porque no existe el tercero!',
                      text: 'por favor verifique los terceros',
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
    }else{
      Swal.fire(
        {
        icon: 'error',
        title: 'Hay comprobantes con debitos y creditos que no coinciden!',
        text: 'por favor reviselos y cargue nuevamento el documento',
        closeOnConfirm: true,
      }
      ).then((result) => {
       // location.reload(); 
      })
    }
  })



// ----------------------------------------------------------------------------------------------------------------------------------------------

  function decimalAdjust(type, value, exp) {
    // Si el exp no está definido o es cero...
    if (typeof exp === 'undefined' || +exp === 0) {
      return Math[type](value);
    }
    value = +value;
    exp = +exp;
    // Si el valor no es un número o el exp no es un entero...
    if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
      return NaN;
    }
    // Shift
    value = value.toString().split('e');
    value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
    // Shift back
    value = value.toString().split('e');
    return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
  }

  // Decimal round
  if (!Math.round10) {
    Math.round10 = function(value, exp) {
      return decimalAdjust('round', value, exp);
    };
  }
  // Decimal floor
  if (!Math.floor10) {
    Math.floor10 = function(value, exp) {
      return decimalAdjust('floor', value, exp);
    };
  }
  // Decimal ceil
  if (!Math.ceil10) {
    Math.ceil10 = function(value, exp) {
      return decimalAdjust('ceil', value, exp);
    };
  }


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

    var totalDebitos=0.00;
    var totalCreditos=0.00;

    var debitos=0.00;
    var creditos=0.00;



    if (numeroFilas<=308) {


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


            if (wb.Sheets[nameS]['M'+i].w!=undefined) {
              var detalle = wb.Sheets[nameS]['M'+i].w.trim();
            }
            if (wb.Sheets[nameS]['M'+i]==undefined) {
              var detalle = '';
            }

            if (wb.Sheets[nameS]['J'+i]==undefined) {
              var base = '';
            }
            if (wb.Sheets[nameS]['J'+i]!=undefined) {

              if (wb.Sheets[nameS]['J'+i].w!=undefined) {
                var base = wb.Sheets[nameS]['J'+i].w.trim();
              }else{
                var base='';
              }
            
            }

            var subcentroCosto=wb.Sheets[nameS]['I'+i].w.trim(); 
            
          }
          var letreroCC=0;
       
        
        
      
        sHtml+='<tr>';
        sHtml+='<td><input type="text" name="item['+tabla+']['+cont+'][cuentaContable]" id="item['+tabla+']['+cont+'][cuentaContable]" class="form-control cuentaContable mayusculas"  placeholder="Cuenta" value="'+cuentaC.trim()+'" readonly></td>';
        
    
        sHtml+='<td><input type="text" name="item['+tabla+']['+cont+'][centroCosto]" id="item['+tabla+']['+cont+'][centroCosto]" class="form-control centroCosto mayusculas"  placeholder="centro costo" value="'+centroCosto+'" readonly><span name="item['+tabla+']['+cont+'][letreroCentroCosto]" class="ocultar">No existe</span></td>';  
      
        sHtml+='<td><input type="text" name="item['+tabla+']['+cont+'][subcentroCosto]" id="item['+tabla+']['+cont+'][subcentroCosto]" class="form-control subcentroCosto mayusculas"  placeholder="Subcentro costo" value="'+subcentroCosto+'" readonly></td>';
        sHtml+='<td><input type="text" name="item['+tabla+']['+cont+'][tercero]" id="item['+tabla+']['+cont+'][tercero]" class="form-control mayusculas"  placeholder="tercero" value="'+tercero+'" readonly></td>';
        sHtml+='<td><input type="text" name="item['+tabla+']['+cont+'][descripcion]" id="item['+tabla+']['+cont+'][descripcion]" class="form-control descripcion mayusculas"  placeholder="Descripción" value="'+detalle+'" readonly></td>';
        sHtml+='<td><input type="text" name="item['+tabla+']['+cont+'][base]" id="item['+tabla+']['+cont+'][base]" class="form-control base mayusculas monedaComaPunto"  placeholder="base" value="'+base+'" readonly></td>';
        sHtml+='<td><input type="text" name="item['+tabla+']['+cont+'][debito]" id="item['+tabla+']['+cont+'][debito]" class="form-control debito mayusculas monedaComaPunto"  placeholder="debito" value="'+debito+'" ></td>';
        sHtml+='<td><input type="text" name="item['+tabla+']['+cont+'][credito]" id="item['+tabla+']['+cont+'][credito]" class="form-control credito mayusculas monedaComaPunto"  placeholder="credito" value="'+credito+'" ></td>';

        if (debito!='' && credito!='') {
          

          // console.log('debito=>');
          // console.log(debito);

          // console.log('credito=>');
          // console.log(credito);


          debitos=parseFloat(eliminarMoneda(debito.toString(),",",""));
          creditos=parseFloat(eliminarMoneda(credito.toString(),",",""));
          // console.log('credito=>');
          // console.log(credito);
          if (numero=='2107062') {

            console.log('creditos:');
            console.log(creditos);

            console.log('debitos=>');
            console.log(debitos);
          }

          // console.log('debitosAntes=>');
          // console.log(totalDebitos);

          totalDebitos=totalDebitos+parseFloat(Math.round((debitos)*100)/100);
          totalCreditos=totalCreditos+parseFloat(Math.round((creditos)*100)/100);
          // totalDebitos=totalDebitos+parseFloat((debitos));
          // totalCreditos=totalCreditos+parseFloat(creditos);
          if (numero=='2107062') {

            console.log('debitosTotal=>');
            console.log(totalDebitos);
            console.log('creditosTotal=>:');
            console.log(totalCreditos);
          }
        }
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

          if (totalDebitos.toFixed(2)!=totalCreditos.toFixed(2)) {

            sHtml+='<tr><td class="negrita">TOTAL</td><td></td><td></td><td></td><td></td><td></td><td><input type="text"  id="totalDebito['+tabla+']" class="form-control totalDebito mayusculas moneda"  placeholder="total debito" style="color:red;" total="1" value="'+totalDebitos.toFixed(2)+'" readonly></td><td><input type="text" id="totalCredito['+tabla+']" class="form-control totalCredito mayusculas moneda"  placeholder="total creditos" style="color:red;" value="'+totalCreditos.toFixed(2)+'" readonly></td></tr>';
          }else{
            sHtml+='<tr><td class="negrita">TOTAL</td><td></td><td></td><td></td><td></td><td></td><td><input type="text"  id="totalDebito['+tabla+']" class="form-control totalDebito mayusculas moneda"  placeholder="total debito" total="0" value="'+totalDebitos.toFixed(2)+'" readonly></td><td><input type="text" id="totalCredito['+tabla+']" class="form-control totalCredito mayusculas moneda"  placeholder="total creditos" value="'+totalCreditos.toFixed(2)+'" readonly></td></tr>';

          }
          
          

          sHtml+='</tbody></table></div>';
          $("#divComprobanteCargado").append(sHtml);
          // $(".base").formatCurrency({decimalSymbol:',',digitGroupSymbol:'.'});
          // $(".debito").formatCurrency({decimalSymbol:',',digitGroupSymbol:'.'});
          // $(".credito").formatCurrency({decimalSymbol:',',digitGroupSymbol:'.'});
          totalDebitos=0.0;
          totalCreditos=0.0;
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

   }else{
      $("#btnGuardarInfo").css("display","none");
      Swal.fire(
        'El archivo super el limite de filas!',
        'Por favor verifique que el archivo contenga maximo 300 filas',
        'error'
      )

   } //aca toca cerrar el if del numero de filas
    // recorrer();
    


  }

});






// $("body").on("change","[name='item[0][3][debito]']",function(e){

// })

$("#tableProductos").on("input", "input", function() {
  var input = $(this).val();
  console.log(input);
  // var columns = input.closest("tr").children();
  // var dc = columns.eq(7).text();
  // var calculated = input.val() * price;
  // columns.eq(5).text(calculated.toFixed(2));
  
  // sumar_columnas();
  
  
});



function sumar_columnas(){
var sumDebito=0;
var sumCredito=0;
var cont=0;
var contC=0;
var restarDebito=0;

    //itera cada input de clase .subtotal y la suma
    $('.debito').each(function() { 
      // var naturaleza=document.getElementById("item["+cont+"][naturaleza]").value;
      var debito=document.getElementById("item["+cont+"][debito]");
      var credito=document.getElementById("item["+cont+"][credito]");
      var cuentaContable=document.getElementById("item["+cont+"][cuentaContable]");
      var valorDebito=(eliminarMoneda(eliminarMoneda(eliminarMoneda($(this).val(),"$",""),".",""),",","."));
      if (valorDebito=="" || valorDebito==null) {
        valorDebito=0;
        
      }
      if (debito.value !="" && credito.value =="") {
        credito.disabled=true;
      }
      if (debito.value =="" && credito.value !="") {
        debito.disabled=true;
      }
      if (debito.value =="" && credito.value =="") {
        credito.disabled=false;
        debito.disabled=false;
      }   
      
        sumDebito +=parseFloat(valorDebito);
            cont++;                    
    }); 
      $('.credito').each(function() { 
      var valorCredito=(eliminarMoneda(eliminarMoneda(eliminarMoneda($(this).val(),"$",""),".",""),",","."));
      var cuentaContable=document.getElementById("item["+contC+"][cuentaContable]");
      if (valorCredito=="" || valorCredito==null) {
        valorCredito=0;  
      } 
      
      var valorCuentaContable=cuentaContable.value;
        sumCredito +=parseFloat(valorCredito); 
        contC++; 
    }); 
    //cambia valor del total y lo redondea a la segunda decimal
    var totalD=sumDebito-restarDebito;
    // var totalC=
    $('#totalDebito').val(totalD.toFixed(2));
    $('#totalCredito').val(sumCredito.toFixed(2));
    var diferencia=totalD - sumCredito;
    $('#totalDiferencia').val(diferencia.toFixed(2));

}




function verificarTotal(){
  var cuenta=0;
    var estado=true;
    $('.idCuentaContable').each(function() { 

        var cuentaContable=document.getElementById('item['+cuenta+'][cuentaContable]');
        var idCuentaContable=document.getElementById('item['+cuenta+'][idCuentaContable]');
        var letreroCuentaContable=document.getElementById('item['+cuenta+'][letreroCuentaContable]');

        if ($(this).val()=='') {
          letreroCuentaContable.classList.remove("ocultar");
          estado= false;
        }


        cuenta++;
    });
    return estado;
}





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
                //  Swal.fire(
                //   'Algo ha salido mal!',
                //   'Verifique su conexión a internet',
                //   'error'
                // )
//               }
//           }); 
//           });
//         }
//       })
//       }
//   })

