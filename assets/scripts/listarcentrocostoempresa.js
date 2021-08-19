// $(document).ready(function(){
// 	alert('ingreso');
// })


$("body").on("click touchstart","#btnEliminar",function(e){
	// alert('click');


	e.preventDefault();
	var idEliminar=$(this).attr("value");
	Swal.fire({
		title:'¿Está seguro?',
		text:'Está a punto de eliminar este centro de costos',
		icon:'warning',
		showCancelButton:true,
		showLoaderOnConfirm:true,
		confirmButtonText:'Si, eliminar!',
		cancelButtonText:'Cancelar',
		preConfirm: function(result) {
         return new Promise(function(resolve) {
         	$.ajax({
			url:URL+"functions/centrocosto/eliminarcentrocosto.php",
			type:"POST",
			data:{"idEliminar":idEliminar},
			dataType:"json"
		}).done(function(msg){
			if (msg.msg) {
				Swal.fire({
					icon:"success",
					title:"Centro de costos eliminado",
					text:'con exito',
					closeOnConfirm:true
				}).then((result)=>{
					location.reload();
				})
			}else{
				Swal.fire(
					'Ocurrio un error',
					'No se pudo eliminar el centro de cosots',
					'error'
				)
			}
		})
         })
     }
		
	})
})

$("body").on("click touchstart","#btnEliminarSubcentro",function(e){
	// alert('click');


	e.preventDefault();
	var idEliminar=$(this).attr("value");
	Swal.fire({
		title:'¿Está seguro?',
		text:'Está a punto de eliminar este subcentro de costos',
		icon:'warning',
		showCancelButton:true,
		showLoaderOnConfirm:true,
		confirmButtonText:'Si, eliminar!',
		cancelButtonText:'Cancelar',
		preConfirm: function(result) {
         return new Promise(function(resolve) {
         	$.ajax({
			url:URL+"functions/centrocosto/eliminarsubcentrocosto.php",
			type:"POST",
			data:{"idEliminar":idEliminar},
			dataType:"json"
		}).done(function(msg){
			if (msg.msg) {
				Swal.fire({
					icon:"success",
					title:"Subcentro de costos eliminado",
					text:'con exito',
					closeOnConfirm:true
				}).then((result)=>{
					location.reload();
				})
			}else{
				Swal.fire(
					'Ocurrio un error',
					'No se pudo eliminar el subcentro de cosots',
					'error'
				)
			}
		})
         })
     }
		
	})
})


$("body").on("click touchstart","#btnGuardar",function(e){
	// alert('click');
	e.preventDefault();
	// var idEliminar=$(this).attr("value");
	Swal.fire({
		title:'¿Está seguro?',
		text:'Está a punto de agregar este subcentro de costos',
		icon:'warning',
		showCancelButton:true,
		showLoaderOnConfirm:true,
		confirmButtonText:'Si, guardar!',
		cancelButtonText:'Cancelar',
		preConfirm: function(result) {
         return new Promise(function(resolve) {

         	var formu = document.getElementById("frmGuardar");
            var data = new FormData(formu);

         	$.ajax({
			url:URL+"functions/centrocosto/guardarsubcentrocosto.php",
			type:"POST",
			data:data,
			contentType:false, 
           	processData:false, 
			cache:false,
			dataType:"json"
		}).done(function(msg){
			if (msg.msg) {
				Swal.fire({
					icon:"success",
					title:"Subcentro de costos agregado",
					text:'con exito',
					closeOnConfirm:true
				}).then((result)=>{
					location.reload();
				})
			}else{
				Swal.fire(
					'Ocurrio un error',
					'No se pudo agregar el subcentro de cosots',
					'error'
				)
			}
		})
         })
     }
		
	})
})


// $('#Modal').on('show.bs.modal', function (event) {
//   var button = $(event.relatedTarget) // Button that triggered the modal
//   var id = button.data('value') // Extract info from data-* attributes
//   alert(id);
//   // var modal = $(this)
//   // modal.find('.modal-title').text('New message to ' + recipient)
//   // modal.find('.modal-body input').val(recipient)
// })


$("body").on("click touchstart",".idCentroCosto",function(e){
	// $("#frmGuardar").reset();
	
	var id = $(this).attr("value");


	$("[name='datos[idCentroCosto]']").val(id);
	// alert(id);
})

