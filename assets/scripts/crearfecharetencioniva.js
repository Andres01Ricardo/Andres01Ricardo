$("body").on("change","[name='datos[periocidad]']",function(e){

	var aMes=Array(); 

	aMes[1]="Enero"; 

	aMes[2]="Febrero"; 

	aMes[3]="Marzo"; 

	aMes[4]="Abril"; 

	aMes[5]="Mayo"; 

	aMes[6]="Junio"; 

	aMes[7]="Julio"; 

	aMes[8]="Agosto"; 

	aMes[9]="Septiembre"; 

	aMes[10]="Octubre"; 

	aMes[11]="Noviembre"; 

	aMes[12]="Diciembre"; 



	if($("[name='datos[anio]']").val()!=""&&$("[name='datos[tipo]']").val()!=""&&$("[name='datos[periocidad]']").val()!=""){

		var periodo=$(this).find("option:selected").attr("valor"); 

		var filas=12/parseInt(periodo); 



		var anio=$("[name='datos[anio]']").val(); 

		

		$("#tablaDigitos thead tr").eq(0).html("<th class='centrar'></th>"); 

		$("#tablaDigitos thead tr").eq(1).html("<th class='centrar'>Ultimo Digito</th>"); 

		for (var k = 0; k<10; k++) {

			$("#tablaDigitos tbody tr").eq(k).html("<td class='centrar'><input type='hidden' name='item["+k+"][digito]' id='item["+k+"][digito]' value='"+k+"'/>"+k+"</td>"); 

		}

		for (var i = 0; i < filas; i++) {

			var sHtml=Array(); 

			var periodoInicio=(periodo*i)+1; 

			var periodoFin=periodoInicio+parseInt(periodo); 

			var complemento=""; 

			var iMeses=Array(); 

			for(var j=periodoInicio; j<periodoFin;j++ ){

				sHtml.push(aMes[j]);

				iMeses.push(j);

			}



			if(periodoFin>12){

				periodoFin=1; 

				anio=parseInt(anio)+1;

				complemento="/"+anio;

			}

			$("#tablaDigitos thead tr").eq(0).append("<th class='centrar'>"+sHtml.join(" - ")+"</th>"); 

			$("#tablaDigitos thead tr").eq(1).append("<th class='centrar'>Plazo hasta "+aMes[periodoFin]+""+complemento+"</th>"); 

			

			for (var j = 0; j<10; j++) {

				$("#tablaDigitos tbody tr").eq(j).append("<td>"

					+"<input type='hidden' name='item["+j+"][periodos]["+i+"]' id='item["+j+"][periodos]["+i+"]' value='"+iMeses.join()+"'/>"

					+"<input type='hidden' name='item["+j+"][anio]["+i+"]' id='item["+j+"][anio]["+i+"]' value='"+anio+"'/>"

					+"<input type='hidden' name='item["+j+"][mes]["+i+"]' id='item["+j+"][mes]["+i+"]' value='"+periodoFin+"'/>"

					+"<input type='text' name='item["+j+"][dia]["+i+"]' id='item["+j+"][dia]["+i+"]' class='form-control numero dia' required/></td>"); 

			}

		}

	}

	

})



$("body").on("blur",".dia",function(e){

	if($(this).val()<1||$(this).val()>31){

		$(this).val("")

	}

})



$("body").on("click touchstart","#btnGuardar",function(e){

    e.preventDefault();

      if(true === $("#frmGuardar").parsley().validate()){

        Swal.fire({

        title: 'Está seguro?',

        text: 'Está a punto de guardar la configuracion de fechas de impuestos!',

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

            url:URL+"functions/calendarioimpuesto/guardarcalendario.php", 

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

                  title: 'Calendario creado!',

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

      }).then((result) => {

        if (result.isConfirmed) {



        } 



       })

       

      }

  })

