// $('body').on('change', '#xml', function(e) {
//   var obj = e.target.files[0];
  


//     // $("#json").val(JSON.stringify(x2js.xml_str2json(obj)));


// xml2json(obj);





// });


$("body").on("click","#btnCargar",function(e){
	// alert('click');

    e.preventDefault();

    if($("#xml").val()!=""){

      var formu = document.getElementById("frmCargar");



      var data = new FormData(formu);

      $.ajax({

      url:URL+"functions/facturacompra/leerxml.php", 

      type:"POST", 

      data: data, 

      contentType:false, 

      processData:false, 

      dataType: "json",

      cache:false

      }).done(function(msg){  

        
      		console.log(msg.archivo);

			// xmlDoc=AbrirFichero(msg.archivo).then($("#json").val(xmlDoc)); 
			// console.log(xmlDoc);
$.get(msg.archivo,{},function(xml){ //Abrimos el archivo xml


  

		console.log(xml);
	// alert(xml);
	console.log(xml);
	// alert( "Data Loaded: " + xml );
	nodos=xml.getElementsByTagName("cac:Attachment")[0].childNodes;
	var xmlFacturaE=xml.getElementsByTagName("cac:Attachment")[0].getElementsByTagName("cac:ExternalReference")[0].getElementsByTagName("cbc:Description")[0].childNodes;
	console.log(nodos);
	// if (xmlFacturaE.length==1) {
		for (var i = 0; i <xmlFacturaE.length; i++) {
			if (xmlFacturaE[i].nodeName=='#cdata-section') {
				var pr =xmlFacturaE[i].nodeValue;

			}
		}
		
	xmlDoc = $.parseXML(pr);
	// var pruebaD=xmlDoc.getElementsByTagName("")
	console.log(xmlDoc);
	// console.log(xml);// xmlDoc is your xml document
	var jsonText=xmlToJson(xmlDoc);

	var fechaFactura =xmlDoc.getElementsByTagName('cbc:IssueDate')[0].innerHTML;
	if (xmlDoc.getElementsByTagName('cbc:DueDate').length!=0) {
		var fechaVencimientoFactura =xmlDoc.getElementsByTagName('cbc:DueDate')[0].innerHTML;
	}
	if (xmlDoc.getElementsByTagName('cbc:DueDate').length==0) {
		var fechaVencimientoFactura=fechaFactura;
	}
	var numeroFactura =xmlDoc.getElementsByTagName('cbc:ID')[0].innerHTML;
	if (xmlDoc.getElementsByTagName('cbc:Note').length!=0) {
		var observaciones =xmlDoc.getElementsByTagName('cbc:Note')[0].innerHTML;
		$("#observaciones").val(observaciones);
	}
	if (xmlDoc.getElementsByTagName('cbc:Note').length==0) {
		var observaciones='';
	}
	if (xmlDoc.getElementsByTagName('cac:LegalMonetaryTotal')[0].getElementsByTagName('cbc:LineExtensionAmount').length!=0) {
		var sinImpuestos =xmlDoc.getElementsByTagName('cac:LegalMonetaryTotal')[0].getElementsByTagName('cbc:LineExtensionAmount')[0].innerHTML;	
	}
	if (xmlDoc.getElementsByTagName('cac:LegalMonetaryTotal')[0].getElementsByTagName('cbc:LineExtensionAmount').length==0) {
		var sinImpuestos=0;
	}
	if (xmlDoc.getElementsByTagName('cac:LegalMonetaryTotal')[0].getElementsByTagName('cbc:TaxInclusiveAmount').length!=0) {
		var conImpuestos =xmlDoc.getElementsByTagName('cac:LegalMonetaryTotal')[0].getElementsByTagName('cbc:TaxInclusiveAmount')[0].innerHTML;
	}
	if (xmlDoc.getElementsByTagName('cac:LegalMonetaryTotal')[0].getElementsByTagName('cbc:TaxInclusiveAmount').length==0) {
		var conImpuestos=0;
	}
	// var subtotal =xmlDoc.getElementsByTagName('cbc:LineExtensionAmount')[0].innerHTML;
	var ivaFactura= (parseFloat(conImpuestos)-parseFloat(sinImpuestos)).toFixed(2);


	// Informacion del emisor de la factura
	var digitoVerificadorEmisor =xmlDoc.getElementsByTagName('cac:AccountingSupplierParty')[0].getElementsByTagName('cbc:CompanyID')[0].getAttribute("schemeID");


	if (xmlDoc.getElementsByTagName('cac:AccountingSupplierParty')[0].getElementsByTagName('cbc:CompanyID').length!=0) {
		var nitEmisor =xmlDoc.getElementsByTagName('cac:AccountingSupplierParty')[0].getElementsByTagName('cbc:CompanyID')[0].innerHTML;
	}
	if (xmlDoc.getElementsByTagName('cac:AccountingSupplierParty')[0].getElementsByTagName('cbc:CompanyID').length==0) {
		var nitEmisor ='';
	}
	if (xmlDoc.getElementsByTagName('cac:AccountingSupplierParty')[0].getElementsByTagName('cbc:RegistrationName').length!=0) {
		var emisor =xmlDoc.getElementsByTagName('cac:AccountingSupplierParty')[0].getElementsByTagName('cbc:RegistrationName')[0].innerHTML;	
	}
	if (xmlDoc.getElementsByTagName('cac:AccountingSupplierParty')[0].getElementsByTagName('cbc:RegistrationName').length==0) {
		var emisor='';
	}
	if (xmlDoc.getElementsByTagName('cac:AccountingSupplierParty')[0].getElementsByTagName('cbc:Line').length!=0) {
		var direccionEmisor =xmlDoc.getElementsByTagName('cac:AccountingSupplierParty')[0].getElementsByTagName('cbc:Line')[0].innerHTML;	
	}
	if (xmlDoc.getElementsByTagName('cac:AccountingSupplierParty')[0].getElementsByTagName('cbc:Line').length==0) {
		var direccionEmisor ='';
	}
	if (xmlDoc.getElementsByTagName('cac:AccountingSupplierParty')[0].getElementsByTagName('cbc:Telephone').length!=0) {
		var telefonoEmisor =xmlDoc.getElementsByTagName('cac:AccountingSupplierParty')[0].getElementsByTagName('cbc:Telephone')[0].innerHTML;	
	}
	if (xmlDoc.getElementsByTagName('cac:AccountingSupplierParty')[0].getElementsByTagName('cbc:Telephone').length==0) {
		var telefonoEmisor ='';
	}
	
	if (xmlDoc.getElementsByTagName('cac:AccountingSupplierParty')[0].getElementsByTagName('cbc:ElectronicMail').length!=0) {
		var emailEmisor =xmlDoc.getElementsByTagName('cac:AccountingSupplierParty')[0].getElementsByTagName('cbc:ElectronicMail')[0].innerHTML;
	}
	if (xmlDoc.getElementsByTagName('cac:AccountingSupplierParty')[0].getElementsByTagName('cbc:ElectronicMail').length==0) {
		var emailEmisor='';
	}
	if (xmlDoc.getElementsByTagName('cac:AccountingSupplierParty')[0].getElementsByTagName('cbc:CityName').length!=0) {
		var ciudadEmisor =xmlDoc.getElementsByTagName('cac:AccountingSupplierParty')[0].getElementsByTagName('cbc:CityName')[0].innerHTML;
	}
	if (xmlDoc.getElementsByTagName('cac:AccountingSupplierParty')[0].getElementsByTagName('cbc:CityName').length==0) {
		var ciudadEmisor='';
	}
	if (xmlDoc.getElementsByTagName('cac:AccountingSupplierParty')[0].getElementsByTagName('cbc:TaxLevelCode').length!=0) {
		var responsabilidadFiscalEmisor =xmlDoc.getElementsByTagName('cac:AccountingSupplierParty')[0].getElementsByTagName('cbc:TaxLevelCode')[0].innerHTML;		
	}
	if (xmlDoc.getElementsByTagName('cac:AccountingSupplierParty')[0].getElementsByTagName('cbc:TaxLevelCode').length==0) {
		var responsabilidadFiscalEmisor='';
	}
	
	
//Informacion del receptor de la factura  ---------------------------------------------


	if (xmlDoc.getElementsByTagName('cac:AccountingCustomerParty')[0].getElementsByTagName('cbc:CompanyID').length!=0) {
		var nitReceptor =xmlDoc.getElementsByTagName('cac:AccountingCustomerParty')[0].getElementsByTagName('cbc:CompanyID')[0].innerHTML;
	}
	if (xmlDoc.getElementsByTagName('cac:AccountingCustomerParty')[0].getElementsByTagName('cbc:CompanyID').length==0) {
		var nitReceptor ='';
	}
	
	if (xmlDoc.getElementsByTagName('cac:AccountingCustomerParty')[0].getElementsByTagName('cbc:RegistrationName').length!=0) {
		var receptor =xmlDoc.getElementsByTagName('cac:AccountingCustomerParty')[0].getElementsByTagName('cbc:RegistrationName')[0].innerHTML;	
	}
	if (xmlDoc.getElementsByTagName('cac:AccountingCustomerParty')[0].getElementsByTagName('cbc:RegistrationName').length==0) {
		var receptor ='';
	}
	
	
	if (xmlDoc.getElementsByTagName('cac:AccountingCustomerParty')[0].getElementsByTagName('cbc:Line').length==1) {
		var direccionReceptor =xmlDoc.getElementsByTagName('cac:AccountingCustomerParty')[0].getElementsByTagName('cbc:Line')[0].innerHTML;
	}
	if (xmlDoc.getElementsByTagName('cac:AccountingCustomerParty')[0].getElementsByTagName('cbc:Line').length>1) {
		var direccionReceptor =xmlDoc.getElementsByTagName('cac:AccountingCustomerParty')[0].getElementsByTagName('cbc:Line')[1].innerHTML;
	}
	if (xmlDoc.getElementsByTagName('cac:AccountingCustomerParty')[0].getElementsByTagName('cbc:Telephone').length==0) {
		var telefonoReceptor ='';
	}

	if (xmlDoc.getElementsByTagName('cac:AccountingCustomerParty')[0].getElementsByTagName('cbc:Telephone').length!=0) {
		var telefonoReceptor =xmlDoc.getElementsByTagName('cac:AccountingCustomerParty')[0].getElementsByTagName('cbc:Telephone')[0].innerHTML;

	}

	if (xmlDoc.getElementsByTagName('cac:AccountingCustomerParty')[0].getElementsByTagName('cbc:ElectronicMail').length!=0) {
		var emailReceptor =xmlDoc.getElementsByTagName('cac:AccountingCustomerParty')[0].getElementsByTagName('cbc:ElectronicMail')[0].innerHTML;
	}
	if (xmlDoc.getElementsByTagName('cac:AccountingCustomerParty')[0].getElementsByTagName('cbc:ElectronicMail').length==0) {
		var emailReceptor ='';
	}

	if (xmlDoc.getElementsByTagName('cac:AccountingCustomerParty')[0].getElementsByTagName('cbc:CityName')[0].length!=0) {

		var ciudadReceptor =xmlDoc.getElementsByTagName('cac:AccountingCustomerParty')[0].getElementsByTagName('cbc:CityName')[0].innerHTML;
	}
	if (xmlDoc.getElementsByTagName('cac:AccountingCustomerParty')[0].getElementsByTagName('cbc:CityName')[0].length==0) {
		var ciudadReceptor ='';
	}

	if (xmlDoc.getElementsByTagName('cac:AccountingCustomerParty')[0].getElementsByTagName('cbc:TaxLevelCode').length!=0) {

		var responsabilidadFiscalReceptor =xmlDoc.getElementsByTagName('cac:AccountingCustomerParty')[0].getElementsByTagName('cbc:TaxLevelCode')[0].innerHTML;
	}else{
		var responsabilidadFiscalReceptor='';
	}

		

	// var formu = document.getElementById("frmGuardar");
	          	
 //    var data = new FormData(formu);

   






				$("#fechaFactura").val(fechaFactura);
				$("#fechaVencimientoFactura").val(fechaVencimientoFactura);
				$("#numeroFactura").val(numeroFactura);
				

				$("#subtotalFactura").val(sinImpuestos);
				$("#ivaFactura").val(ivaFactura);
				$("#totalFactura").val(conImpuestos);
				$("[name='datos[totalPago]']").val(conImpuestos).trigger("change");

				$(".ivaFactura").formatCurrency({decimalSymbol:',',digitGroupSymbol:'.'});
				$(".subtotalFactura").formatCurrency({decimalSymbol:',',digitGroupSymbol:'.'});
				$(".totalFactura").formatCurrency({decimalSymbol:',',digitGroupSymbol:'.'});


				$("#producto").val(producto);
				$("#precio").val(precio);
				$("#cantidad").val(cantidad);

				$("#digitoVerificadorEmisor").val(digitoVerificadorEmisor);
				$("#nitEmisor").val(nitEmisor);
				$("#emisor").val(emisor);
				$("#ciudadEmisor").val(ciudadEmisor);
				$("#direccionEmisor").val(direccionEmisor);
				$("#telefonoEmisor").val(telefonoEmisor);
				$("#emailEmisor").val(emailEmisor);
				$("#responsabilidadFiscalEmisor").val(responsabilidadFiscalEmisor);
				

				$("#nitReceptor").val(nitReceptor);
				$("#receptor").val(receptor);
				$("#ciudadReceptor").val(ciudadReceptor);
				$("#direccionReceptor").val(direccionReceptor);
				$("#telefonoReceptor").val(telefonoReceptor);
				$("#emailReceptor").val(emailReceptor);
				$("#responsabilidadFiscalReceptor").val(responsabilidadFiscalReceptor);



var productos =xmlDoc.getElementsByTagName('cac:InvoiceLine');
				var cantidadProductos=productos.length;
				// alert(cantidadProductos);

	var sHtmlA=""; 			


	for (var i =0 ; i < productos.length; i++) {
		var producto =xmlDoc.getElementsByTagName('cac:InvoiceLine')[i].getElementsByTagName('cac:Item')[0].getElementsByTagName('cbc:Description')[0].innerHTML;
		var precio =xmlDoc.getElementsByTagName('cac:InvoiceLine')[i].getElementsByTagName('cac:Price')[0].getElementsByTagName('cbc:PriceAmount')[0].innerHTML;
		var cantidad =xmlDoc.getElementsByTagName('cbc:BaseQuantity')[i].innerHTML;
		if (xmlDoc.getElementsByTagName('cac:InvoiceLine')[i].getElementsByTagName('cbc:Percent').length==0) {
			var iva ='0.00';
		}
		if (xmlDoc.getElementsByTagName('cac:InvoiceLine')[i].getElementsByTagName('cbc:Percent').length!=0) {
			var iva =xmlDoc.getElementsByTagName('cac:InvoiceLine')[i].getElementsByTagName('cbc:Percent')[0].innerHTML;
		}
			var subtotal =xmlDoc.getElementsByTagName('cac:InvoiceLine')[i].getElementsByTagName('cbc:LineExtensionAmount')[0].innerHTML;
				
			var total=((parseFloat(subtotal)*parseFloat(iva))/100)+parseFloat(subtotal);
			total=total.toFixed(2);
sHtmlA+='<tr>'+

      '<td class="text-center">'+(i+1)+'</td>'+
      '<input type="hidden" name="item['+i+'][idProducto]" id="item['+i+'][idProducto]" class="form-control idProducto mayusculas" required >'+
      '<td><input type="text" name="item['+i+'][producto]" id="item['+i+'][producto]" class="form-control producto mayusculas" required ></td>'+
      '<td><input type="text" name="item['+i+'][descripcion]" id="item['+i+'][descripcion]" class="form-control descripcion mayusculas" value="'+producto+'" required readonly></td>'+

        '<td><input type="text" name="item['+i+'][cantidad]" id="item['+i+'][cantidad]" class="form-control cantidad decimales" value="'+cantidad+'" readonly></td>'+
        '<td><input type="text" name="item['+i+'][valorUnitario]" id="item['+i+'][precio]" class="form-control precio decimales" value="'+precio+'" readonly></td>'+
        '<input type="hidden" name="item['+i+'][idUnidad]" id="item['+i+'][idUnidad]" class="form-control idUnidad" value="1" readonly>'+
        '<td><input type="text" name="item['+i+'][subtotal]" id="item['+i+'][subtotal]" class="form-control subtotal decimales" value="'+subtotal+'" readonly></td>'+
        '<td><input type="text" name="item['+i+'][iva]" id="item['+i+'][iva]" class="form-control iva decimales" value="'+iva+'" readonly></td>'+
        '<td><input type="text" name="item['+i+'][total]" id="item['+i+'][total]" class="form-control total decimales" value="'+total+'" readonly></td>'+
    '</tr>'; 

		}

$("#tableProductos tbody").html(sHtmlA);
				
$(".precio").formatCurrency({decimalSymbol:',',digitGroupSymbol:'.'});
$(".subtotal").formatCurrency({decimalSymbol:',',digitGroupSymbol:'.'});
$(".total").formatCurrency({decimalSymbol:',',digitGroupSymbol:'.'});
			}).then(function( data ){

          // if (result.isConfirmed) {

        // alert($("#nitReceptor").val());
        // alert($("#nitEmisor").val());
    	$.ajax({

      url:URL+"functions/empresa/consultarempresa.php", 

      type:"POST", 

	  data: {"nit":$("#nitReceptor").val(),"nitP":$("#nitEmisor").val()}, 

	  dataType: "json",

      }).done(function(msg){  

	          $("#idEmpresa").val(msg.idEmpresa);
	          if (msg.idProveedor==null) {
	          	alert('El proveedor no esta registrado');
	          	// alert($("#ciudadEmisor").val());
	  //         	 $.ajax({

   //  url:URL+"functions/proveedor/consultarciudad.php", 

   //    type:"POST", 

	  // data: {"ciudad":$("#ciudadEmisor").val()}, 

	  // dataType: "json",

   //  }).done(function(msg){
   //  	alert(msg.idCiudad);
   //  	alert(msg.idDepartamento);
   //  	$("#idCiudad").val(msg.idCiudad);
   //  	$("#idDepartamento").val(msg.idDepartamento);
   //   });

	          	
	          }
	          if (msg.idProveedor!=null) {
	          	$("#idProveedor").val(msg.idProveedor);
	          	// alert(msg.idProveedor);

	          }
	          
	          cargarProducto();

	      });

          // } 



         });

    })


    }

    

})


$('.decimales').keyup(function () { 
    this.value = this.value.replace(/[^0-9\,]/g,'');
    

});
$('.monedaD').change(function () { 
  	$(this).formatCurrency({decimalSymbol:',',digitGroupSymbol:'.'});
    

});



$( '.tipoCompra' ).on( 'click', function() {
  cargarProducto();
});

$('[data-toggle="tooltip"]').tooltip();


cargarProducto=function(){

  // var idB=$("[name='datos[tipoCompraB]']");
  // var idS=$("[name='datos[tipoCompraS]']");
  // var id=0;
  //   if( idB.is(':checked') && idS.is(':checked') ){
  //       // Hacer algo si el checkbox ha sido seleccionado
  //       id=3;
  //   } else if( idB.is(':checked') ){
  //       // Hacer algo si el checkbox ha sido deseleccionado
  //       id=1;
  //   }else if( idS.is(':checked') ){
  //       // Hacer algo si el checkbox ha sido deseleccionado
  //       id=2;
  //   }
  var id=3;
    // console.log(idB,idS, $("[name='datos[idEmpresa]'").val());
    if(id!=""&&$("[name='datos[idEmpresa]'").val()!=""){

      var titulo="Servicios"; 

      if(id==1){

        titulo="Productos"; 

        $("#tableProductos thead tr").find("th").eq(1).html(titulo); 

      }

      $.ajax({

        url:URL+"functions/productosservicios/listarproductoscontable.php", 

        type:"POST", 

        data: {"tipo":id,"idEmpresa":$("[name='datos[idEmpresa]'").val()}, 

        dataType: "json",

        }).done(function(msg){  

          aDatos=[]; 

          $(".producto").val("");

          $(".idProducto").val("");

         //  if (msg.tipo==1) {
          
	        //   msg.productos.forEach(function(element,index){
	            
	        //     // console.log("productosFOR");
	        //     // console.log(msg.productos);
	        //     aDatos.push({
	        //         value: element.idProductoContable,
	        //         label: element.codigo+" - "+element.descripcion,
	                
	        //       })
	        //   })
	        // }
          
         
        // if (msg.tipo==2) {
          
          msg.productos.forEach(function(element,index){
            aDatos.push({
                value: element.idProductoServicio,
                label: element.codigo+" - "+element.nombre,
              })
          })
        // }
        $("#tipoProdcutos").val(msg.tipo);

        autocomplete(); 

      });

    }else{

      $(".producto").val("");

    }

}

autocomplete=function(){

	$( ".producto" ).autocomplete({

      minLength: 0,

      source: aDatos,

      focus: function( event, ui ) {

      	var index=$(this).index(".producto")

        $( ".producto" ).eq(index).val( ui.item.label );

        $( ".idProducto" ).eq(index).val( ui.item.value );

        return false;

      },

      select: function( event, ui ) {

      	var index=$(this).index(".producto")

        $( ".producto" ).eq(index).val( ui.item.label );

        $( ".idProducto" ).eq(index).val( ui.item.value );

        var idEmpresa = $("[name='datos[idEmpresa]'").val();

         $.ajax({
          url:URL+"functions/facturacompra/consultarcuentaproducto.php", 
          type:"POST", 
          data: {"producto":ui.item.value ,"empresa":idEmpresa,"tipoFactura":'compra',"tipoProdcutos":$("#tipoProdcutos").val()}, 
          dataType: "json",
          }).done(function(msg){             
              if(msg.length!=0){

                  console.log(msg);
              }
              if(msg.length==0){

                Swal.fire(
                {
                  icon: 'error',
                  title: "El producto no se encuentra parametrizado!",   
                  text: "Por favor parametrice la cuenta contable",
                  closeOnConfirm: true,
                })
                // .then((element)=>{

                  // $( ".registrar" ).eq(index).removeClass('ocultar');

                // });
              }

            })

        return false;

      },

      change: function(event, ui){

        var index=$(this).index(".producto")



        if(ui.item==null){

          $( ".idProducto" ).eq(index).val('');

        }

        return false;

      }

    })

}

function xmlToJson(xml) {
	
	// Create the return object
	var obj = {};

	if (xml.nodeType == 1) { // element
		// do attributes
		if (xml.attributes.length > 0) {
		obj["@attributes"] = {};
			for (var j = 0; j < xml.attributes.length; j++) {
				var attribute = xml.attributes.item(j);
				obj["@attributes"][attribute.nodeName] = attribute.nodeValue;
			}
		}
	} else if (xml.nodeType == 3) { // text
		obj = xml.nodeValue;
	}

	// do children
	if (xml.hasChildNodes()) {
		for(var i = 0; i < xml.childNodes.length; i++) {
			var item = xml.childNodes.item(i);
			var nodeName = item.nodeName;
			if (typeof(obj[nodeName]) == "undefined") {
				obj[nodeName] = xmlToJson(item);
			} else {
				if (typeof(obj[nodeName].push) == "undefined") {
					var old = obj[nodeName];
					obj[nodeName] = [];
					obj[nodeName].push(old);
				}
				obj[nodeName].push(xmlToJson(item));
			}
		}
	}
	return obj;
};





 function xml2json(xml) {
  try {
    var obj = {};
    if (xml.children.length > 0) {
      for (var i = 0; i < xml.children.length; i++) {
        var item = xml.children.item(i);
        var nodeName = item.nodeName;

        if (typeof (obj[nodeName]) == "undefined") {
          obj[nodeName] = xml2json(item);
        } else {
          if (typeof (obj[nodeName].push) == "undefined") {
            var old = obj[nodeName];

            obj[nodeName] = [];
            obj[nodeName].push(old);
          }
          obj[nodeName].push(xml2json(item));
        }
      }
    } else {
      obj = xml.textContent;
    }
    return obj;
  } catch (e) {
      console.log(e.message);
  }
}

// $("body").on("click touchstart","#btnGuardar",function(e){

    

//   e.preventDefault();

//   Swal.fire({

//     title: '¿Está seguro?',

//     text: 'Está a punto de enviar esta factura para su gestion!',

//     icon: 'warning', 

//     showCancelButton: true,

//     showLoaderOnConfirm: true,

//     confirmButtonText: `Si, Continuar!`,

//     cancelButtonText:'Cancelar',

//     preConfirm: function(result) {

//         return new Promise(function(resolve) {

//           var formu = document.getElementById("frmGuardar");

  

//           var data = new FormData(formu);

//           $.ajax({

//           url:URL+"functions/facturacompra/guardarfacturaxml.php", 

//           type:"POST", 

//           data: data,

//           contentType:false, 

//           processData:false, 

//           dataType: "json",

//           cache:false 

//           }).done(function(msg){  

//             if(msg.msg){

//               Swal.fire(

//                 {

//                 icon: 'success',

//                 title: 'Factura Registrada!',

//                 text: 'con exito',

//                 closeOnConfirm: true,

//               }

//               ).then((result) => {

//                location.reload(); 

//               })

//             }else{

//                 Swal.fire(

//                 'Algo ha salido mal!',

//                 'Verifique su conexión a internet',

//                 'error'

//               )


//             }
//         });    

//         });

//       }

//   })

//   })



$("body").on("click touchstart","#btnGuardar",function(e){

    e.preventDefault();

      if(true === $("#frmGuardar").parsley().validate()){

        Swal.fire({

          title: 'Está seguro?',

          text: 'Está a punto de enviar está factura para su gestión!',

          icon: 'warning', 

          showCancelButton: true,

          showLoaderOnConfirm: true,

          confirmButtonText: `Si, Continuar!`,

          cancelButtonText:'Cancelar',

          preConfirm: function(result) {

          return new Promise(function(resolve) {

            var formu = document.getElementById("frmGuardar");

        

            var data = new FormData(formu);

            $.ajax({

            url:URL+"functions/facturacompra/guardarfacturacompra.php", 

            type:"POST", 

            data: data,

            contentType:false, 

            processData:false, 

            dataType: "json",

            cache:false 

            }).done(function(msg){  

              if(msg.msg){

                Swal.fire({

                  icon: 'success',

                  title: "Factura enviada!",

                  text: 'con exito',

                  closeOnConfirm: true,

                }

                ).then((result) => {

                 window.history.back(); 

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







$("body").on("click","#btnAgregar",function(e){

  var tipo=$("#tipoDeduccion").val(); 

  var tipoDeduccion=$("#tipoDeduccion").find("option:selected").html(); 



  var concepto=$("#conceptoText").val(); 

  var idConcepto=''; 

  var base=0; 

  if($("#tipoDeduccion").val()==1||$("#tipoDeduccion").val()==2){

    concepto=$("#conceptoSelect").find("option:selected").html()

    idConcepto=$("#conceptoSelect").val(); 

    base=$("#baseImpuestos").val(); 

  }

  var valor=$("#valor").val(); 

  if(valor!=""){

    var valorMoneda=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda(valor,"$",""),".",""),",","."));
    valorMoneda=Math.round(valorMoneda);
  }

  

  var cantidad=$("#tableDeducciones tbody tr").length; 

  var totalDeduccion=0; 

  var totalPago=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($("[name='datos[total]']").val(),"$",""),".",""),",","."));

  if($("[name='datos[totalDeduccion]']").val()!=""){

    totalDeduccion=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($("[name='datos[totalDeduccion]']").val(),"$",""),".",""),",","."));

  }



  if((totalDeduccion+valorMoneda)>totalPago){

    Swal.fire(

      {

        icon: 'error',

        title: 'Algo ha salido mal!',

        text: 'El valor de las deducciones no puede superar el valor del pago',

        closeOnConfirm: true,

      }

      ).then((result) => {

       $("#valor").val("")

      })

      return false;

  }

  if(concepto!=""&&tipo!=""&&valor!=""){

    

    if(base!=""){

      base=eliminarMoneda(eliminarMoneda(eliminarMoneda(base,".",""),"$",""),",",".");

    }



    $("#tableDeducciones tbody:last").append("<tr>"

    +"<td><input type='hidden' name='impuesto["+cantidad+"][tipoDeduccion]' id='item["+cantidad+"][tipoDeduccion]' class='form-control tipoDeduccion' value='"+tipo+"' >"

    +"<input type='hidden' name='impuesto["+cantidad+"][concepto]' id='item["+cantidad+"][concepto]' class='form-control concepto' value='"+concepto+"' >"

    +"<input type='hidden' name='impuesto["+cantidad+"][idConcepto]' id='item["+cantidad+"][idConcepto]' class='form-control idConcepto' value='"+idConcepto+"' >"

    +"<input type='hidden' name='impuesto["+cantidad+"][baseImpuestos]' id='item["+cantidad+"][baseImpuestos]' class='form-control baseImpuestos' value='"+base+"' >"

    +"<input type='hidden' name='impuesto["+cantidad+"][valor]' id='item["+cantidad+"][valor]' class='form-control valor' value='"+valorMoneda+"' >"+

      tipoDeduccion+"</td>"

    +"<td>"+concepto+"</td>"

    +"<td>"+valor+"</td>"

    +"<td><a href='javascript:void(0)' data-toggle='tooltip' id='eliminar' data-placement='top' title='Eliminar' class='btnEliminar btn btn-icon btn-sm btn-danger'><i class='fas fa-trash'></i></a></td>"

    +"</tr>"); 



    $("#tipoDeduccion").val(''); 

    $("#conceptoText").val(''); 

    $("#conceptoSelect").val('');

    $("#valor").val('');

    $("#baseImpuestos").val('');

  }

  calcularDeduccion(); 

})

$("body").on("change","#tipoDeduccion",function(e){

  if($(this).val()==1||$(this).val()==2){

    $(".concepto-select").removeClass("ocultar")

    $(".baseimpuestos").removeClass("ocultar")

    $(".concepto-texto").addClass("ocultar")

    $(".boton-agregar").addClass("col-md-2").removeClass("col-md-3")

    $(".valor").addClass("col-md-2").removeClass("col-md-3")

    $("#valor").attr("readonly","readonly"); 

     $.ajax({

          url:URL+"functions/configuracion/listarretencioneica.php", 

          type:"POST", 

          data: {"tipo":$(this).val()}, 

          dataType: "json",

          }).done(function(msg){  

            var sHtml="<option value=''>Seleccione una opción</option>"; 

            msg.retenciones.forEach(function(element,index){

              var ciudad=""; 

              if(element.ciudad!=""){

                ciudad="("+element.ciudad+")"; 

              }

              sHtml+="<option porcentaje='"+element.valor+"' value='"+element.idRetencion+"'>"+element.valor+"% - "+element.descripcion+" "+ciudad+"</option>"; 

            })



            $("#conceptoSelect").html(sHtml);

        });

  }else{

    $(".concepto-select").addClass("ocultar")

    $(".baseimpuestos").addClass("ocultar")

    $(".concepto-texto").removeClass("ocultar")

    $(".boton-agregar").addClass("col-md-3").removeClass("col-md-2")

    $(".valor").addClass("col-md-3").removeClass("col-md-2")

    $("#valor").removeAttr("readonly")

    

  }

})

$("body").on("change","#baseImpuestos",function(e){



   var base=parseInt(eliminarMoneda(eliminarMoneda(eliminarMoneda($(this).val(),".",""),"$",""),",","."))

   var subtotal=parseInt(eliminarMoneda(eliminarMoneda(eliminarMoneda($('[name="datos[subtotal]"]').val(),".",""),"$",""),",","."))

   if(base>subtotal){

    swal({   

      title: "Algo ha salido mal!",   

      text: "La base de impuestos no puede ser mayor al subtotal",

      type: "error",        

      closeOnConfirm: true 

      }).then((element)=>{

        $("#baseImpuestos").val("")

      });

      return false; 

   }

  if($("#conceptoSelect").val()!=""){

    var porcentaje=parseFloat($("#conceptoSelect").find("option:selected").attr("porcentaje")); 

    var valor=base*(porcentaje/100); 


    $("#valor").val(valor).trigger("change"); 
    $("#valor").formatCurrency({decimalSymbol:',',digitGroupSymbol:'.'});	

  }

})

calcularDeduccion=function(){

  var valor=0;

  $("#tableDeducciones .valor").each(function(index,element){

    valor+=parseFloat($(element).val()); 

  })

  // var valorTotal=eliminarMoneda(eliminarMoneda($("[name='datos[total]']").val(),",",""),"$",""); 
   var valorTotal=parseFloat(eliminarMoneda(eliminarMoneda(eliminarMoneda($("[name='datos[total]']").val(),"$",""),".",""),",",".")); 

  // var amortizacion=eliminarMoneda(eliminarMoneda($("[name='datos[amortizacion]']").val(),",",""),"$",""); 

  $("[name='datos[totalDeduccion]']").val(valor).trigger("change");

  pago=valorTotal-valor; 

  $("[name='datos[totalPago]']").val(pago).trigger("change");


}


$("body").on("change","[name='datos[tipoDocumento]']",function(e){
  var numero =$("#tipoDocumento").find("option:selected").attr("numeracion");
  console.log(numero);

  $("#numeroComprobante").val(numero);
});

