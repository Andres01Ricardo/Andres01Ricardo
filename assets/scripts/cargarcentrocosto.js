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
        text: 'Está a punto de importar los centros de costo!',
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
            url:URL+"functions/centrocosto/importarcentrocosto.php", 
            type:"POST", 
            data: data,
            contentType:false, 
            processData:false, 
            dataType: "json",
            cache:false 
            }).done(function(msg){  
              if(msg){
                Swal.fire(
                  {
                  icon: 'success',
                  title: 'Centros de costo cargados!',
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
    var sHtml='<div class="col-md-12"><table class="table table-striped mayusculas" id="tableCentroCosto"><thead><th>Codigo centro costo</th><th>Centro costo</th> <th>Codigo subcentro costo</th><th>Subcentro costo</th></thead><tbody>';
    
    var j =0;
    var cont=0;
    var tipoC='';
    var tipo='';
    var comprobanteT='';
    var numero=0;
    var control=1;
    var fecha='';
    for (var i = 8; i <= numeroFilas; i++) {
        if (wb.Sheets[nameS]['A'+i] != undefined) {
          
          if (wb.Sheets[nameS]['A'+i].w!=undefined) {
          var centroCosto=parseInt(wb.Sheets[nameS]['A'+i].w.trim());   
          }
          
        if (wb.Sheets[nameS]['C'+i].w!=undefined) {
          var subcentroCosto=wb.Sheets[nameS]['C'+i].w.trim(); 
        }
          
        if (wb.Sheets[nameS]['D'+i].w!=undefined) {
          var nombreSubcentroCosto=wb.Sheets[nameS]['D'+i].w.trim();
        }
          
        if (wb.Sheets[nameS]['B'+i].w!=undefined) {
          var nombreCentroCosto=wb.Sheets[nameS]['B'+i].w.trim();
        }


        if (wb.Sheets[nameS]['A'+i].w==undefined) {
          var centroCosto=parseInt(wb.Sheets[nameS]['A'+i].v.trim());   
          }
          
        if (wb.Sheets[nameS]['C'+i].w==undefined) {
          var subcentroCosto=wb.Sheets[nameS]['C'+i].v.trim(); 
        }
          
        if (wb.Sheets[nameS]['D'+i].w==undefined) {
          var nombreSubcentroCosto=wb.Sheets[nameS]['D'+i].v.trim();
        }
          
        if (wb.Sheets[nameS]['B'+i].w==undefined) {
          var nombreCentroCosto=wb.Sheets[nameS]['B'+i].v.trim();
        }


        console.log(centroCosto);
        console.log(subcentroCosto);
        console.log(nombreCentroCosto);
        console.log(nombreSubcentroCosto);
        
      
        sHtml+='<tr>';
        sHtml+='<td><input type="text" name="item['+cont+'][codigoCentroCosto]" id="item['+cont+'][codigoCentroCosto]" class="form-control codigoCentroCosto mayusculas"  placeholder="Cuenta" value="'+centroCosto+'" readonly></td>';       
        sHtml+='<td><input type="text" name="item['+cont+'][centroCosto]" id="item['+cont+'][centroCosto]" class="form-control centroCosto mayusculas"  placeholder="centro costo" value="'+nombreCentroCosto+'" readonly></td>';  
        sHtml+='<td><input type="text" name="item['+cont+'][codigoSubcentroCosto]" id="item['+cont+'][codigoSubcentroCosto]" class="form-control codigoSubcentroCosto mayusculas"  placeholder="Subcentro costo" value="'+subcentroCosto+'" readonly></td>';
        sHtml+='<td><input type="text" name="item['+cont+'][subcentroCosto]" id="item['+cont+'][subcentroCosto]" class="form-control subcentroCosto mayusculas"  placeholder="Subcentro costo" value="'+nombreSubcentroCosto+'" readonly></td>';
        // sHtml+='<td><input type="text" name="item['+tabla+']['+cont+'][tercero]" id="item['+tabla+']['+cont+'][tercero]" class="form-control mayusculas"  placeholder="tercero" value="'+wb.Sheets[nameS]['E'+i].w.trim()+'" readonly></td>';
        // sHtml+='<td><input type="text" name="item['+tabla+']['+cont+'][descripcion]" id="item['+tabla+']['+cont+'][descripcion]" class="form-control descripcion mayusculas"  placeholder="Descripción" value="'+wb.Sheets[nameS]['M'+i].w.trim()+'" readonly></td>';
        // sHtml+='<td><input type="text" name="item['+tabla+']['+cont+'][base]" id="item['+tabla+']['+cont+'][base]" class="form-control base mayusculas moneda"  placeholder="base" value="'+wb.Sheets[nameS]['J'+i].w.trim()+'" readonly></td>';
        // sHtml+='<td><input type="text" name="item['+tabla+']['+cont+'][debito]" id="item['+tabla+']['+cont+'][debito]" class="form-control debito mayusculas moneda"  placeholder="debito" value="'+debito+'" readonly></td>';
        // sHtml+='<td><input type="text" name="item['+tabla+']['+cont+'][credito]" id="item['+tabla+']['+cont+'][credito]" class="form-control credito mayusculas moneda"  placeholder="credito" value="'+credito.trim()+'" readonly></td>';
        
        
        sHtml+='</tr>';
        cont++;
        // control=0;
      }  
      
    }
    if(sHtml!=''){
      sHtml+='</tbody></table></div>';
      $("#divComprobanteCargado").append(sHtml);
      console.log('termino');
    }
    // recorrer();
    $("#btnGuardarInfo").removeClass('ocultar');


  }

});



