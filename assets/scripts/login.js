// $("body").on("click","#btnIniciara",function(e){
// 		e.preventDefault();
      
// 	})

function ingresar(){
  if(true === $("#frmLogin").parsley().validate()){
            var formu = document.getElementById("frmLogin");
            
            var data = new FormData(formu);
            $.ajax({
            url:"functions/sesion/sesion.php", 
            type:"POST", 
            data: data,
            contentType:false, 
            processData:false, 
            dataType: "json",
            cache:false 
            }).done(function(msg){  
              if(!msg.error){
                swal({   
                  title: "Algo ha salido mal!",   
                  text: msg.msg,
                  type: "error",        
                  closeOnConfirm: true 
                  }).then((element)=>{

                  }) 
                  
              }else{
                location.href=msg.msg; 
              }

                  
              
            
          });
       
      }
}