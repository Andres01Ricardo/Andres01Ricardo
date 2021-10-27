
$("body").on("click touchstart","#btnGuardarInfo",function(e){
    e.preventDefault();
      if(true === $("#frmGuardar").parsley().validate()){
         Swal.fire({
        title: '¿Está seguro?',
        text: 'Está a punto de importar los terceros!',
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
            url:URL+"functions/terceros/importarterceros.php", 
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
                  title: 'Terceros cargados!',
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
    var sHtml='<div class="col-md-12"><table class="table table-striped mayusculas" id="tableTerceros"><thead><th>Nit</th><th>DV</th> <th>Razón social</th><th>Dirección</th><th>Ciudad</th><th>Telefono</th></thead><tbody>';
    
    var j =0;
    var cont=0;
    var tipoC='';
    var tipo='';
    var comprobanteT='';
    var numero=0;
    var control=1;
    var fecha='';
    for (var i = 8; i <= numeroFilas; i++) {
        if (wb.Sheets[nameS]['A'+i] != undefined  && wb.Sheets[nameS]['B'+i] != undefined) {
          
          console.log('aca');
          console.log(wb.Sheets[nameS]['A'+i]);
          console.log('hasta');
          if (wb.Sheets[nameS]['A'+i].w!=undefined) {
          var razonSocial=wb.Sheets[nameS]['A'+i].w.trim();   
          }
          if (wb.Sheets[nameS]['A'+i].w==undefined) {
          var razonSocial=wb.Sheets[nameS]['A'+i].v.trim();
          }


          if (wb.Sheets[nameS]['C'+i].w!=undefined) {
            var nit=wb.Sheets[nameS]['C'+i].w.trim();
          }
          if (wb.Sheets[nameS]['C'+i].w==undefined) {
            var nit=wb.Sheets[nameS]['C'+i].v.trim();
          }
          
          
          if (wb.Sheets[nameS]['D'+i]!=undefined) {

            if (wb.Sheets[nameS]['D'+i].w!=undefined) {
              var digitoVerificador=wb.Sheets[nameS]['D'+i].w.trim(); 
            }
            if (wb.Sheets[nameS]['D'+i].w==undefined) {
              var digitoVerificador=wb.Sheets[nameS]['D'+i].v.trim(); 
            }
          }
          if (wb.Sheets[nameS]['D'+i]==undefined) {
            var digitoVerificador=0;
          }
          
          if (wb.Sheets[nameS]['G'+i]!=undefined) {

            if (wb.Sheets[nameS]['G'+i].w!=undefined) {
              var direccion=wb.Sheets[nameS]['G'+i].w.trim();
            }
              
            if (wb.Sheets[nameS]['G'+i].w==undefined) {
              var direccion=wb.Sheets[nameS]['G'+i].v.trim();
            }
          }
          if (wb.Sheets[nameS]['G'+i]==undefined) {
            var direccion=0;
          }
          
          if (wb.Sheets[nameS]['H'+i]!=undefined) {

            if (wb.Sheets[nameS]['H'+i].w!=undefined) {
              var ciudad=wb.Sheets[nameS]['H'+i].w.trim();
            }
              
            if (wb.Sheets[nameS]['H'+i].w==undefined) {
              var ciudad=wb.Sheets[nameS]['H'+i].v.trim();
            }
          }
          if (wb.Sheets[nameS]['H'+i]==undefined) {
            var ciudad='';
          }

          if (wb.Sheets[nameS]['I'+i]!=undefined) {

            if (wb.Sheets[nameS]['I'+i].w!=undefined) {
              var telefono=wb.Sheets[nameS]['I'+i].w.trim();
            }
              
            if (wb.Sheets[nameS]['I'+i].w==undefined) {
              var telefono=wb.Sheets[nameS]['I'+i].v.trim();
            }
          }
          if (wb.Sheets[nameS]['I'+i]==undefined) {
            var telefono=0;
          }
          
      
        
      
        sHtml+='<tr>';
        sHtml+='<td><input type="text" name="item['+cont+'][nit]" id="item['+cont+'][nit]" class="form-control nit mayusculas"  placeholder="Cuenta" value="'+nit+'"  required></td>';       
        sHtml+='<td><input type="text" name="item['+cont+'][digitoVerificador]" id="item['+cont+'][digitoVerificador]" class="form-control digitoVerificador mayusculas"  placeholder="DV" value="'+digitoVerificador+'"  required></td>';  
        sHtml+='<td><input type="text" name="item['+cont+'][razonSocial]" id="item['+cont+'][razonSocial]" class="form-control razonSocial mayusculas"  placeholder="razon social" value="'+razonSocial+'"  required></td>';
        sHtml+='<td><input type="text" name="item['+cont+'][direccion]" id="item['+cont+'][direccion]" class="form-control direccion mayusculas"  placeholder="direccion" value="'+direccion+'"  required></td>';
        sHtml+='<td><input type="text" name="item['+cont+'][ciudad]" id="item['+cont+'][ciudad]" class="form-control ciudad mayusculas"  placeholder="ciudad" value="'+ciudad+'"  required></td>';
        sHtml+='<td><input type="text" name="item['+cont+'][telefono]" id="item['+cont+'][telefono]" class="form-control telefono mayusculas"  placeholder="telefono" value="'+telefono+'"  required></td>';
        // sHtml+='<td><input type="text" name="item['+cont+'][responsable]" id="item['+cont+'][responsable]" class="form-control responsable mayusculas"  placeholder="responsabilidad" value="'+responsable+'"  required></td>';
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



