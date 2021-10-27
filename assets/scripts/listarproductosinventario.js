$("body").on("click touchstart","#btnEliminar",function(e){
	// alert('click');


	e.preventDefault();
	var idEliminar=$(this).attr("value");
	Swal.fire({
		title:'¿Está seguro?',
		text:'Está a punto de eliminar este producto',
		icon:'warning',
		showCancelButton:true,
		showLoaderOnConfirm:true,
		confirmButtonText:'Si, eliminar!',
		cancelButtonText:'Cancelar',
		preConfirm: function(result) {
         return new Promise(function(resolve) {
         	$.ajax({
			url:URL+"functions/inventario/eliminarproducto.php",
			type:"POST",
			data:{"idEliminar":idEliminar},
			dataType:"json"
		}).done(function(msg){
			if (msg.msg) {
				Swal.fire({
					icon:"success",
					title:"Producto eliminado",
					text:'con exito',
					closeOnConfirm:true
				}).then((result)=>{
					location.reload();
				})
			}else{
				Swal.fire(
					'Ocurrio un error',
					'No se pudo eliminar el producto',
					'error'
				)
			}
		})
         })
     }
		
	})
})