<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");



$oControl=new Control();



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );





if( isset($_FILES['file']) && $_FILES['file'] != 'undefined')

    {

               

        $sNombre = $_FILES['file']['name'];                

        $sExtension = substr(strrchr($sNombre, '.'), 1);

        $sTemporal = $_FILES['file']['tmp_name'];

        

        $nombreEncript = uniqid(); 

        

        $nombre_archivo = "{$nombreEncript}.{$sExtension}"; 

        

        $directorioTmp = 'USUARIOS/';

        $ubicacionTmp = "{$directorioTmp}{$nombre_archivo}";  

        

        if(move_uploaded_file($sTemporal, "../../".$directorioTmp.$nombre_archivo))

        {	                                               

            $sFoto = 'USUARIOS/'.$nombre_archivo;

        }

        else

        {

            $sFoto = "";

        }

    

} 



$oItem=new Data("usuario","numeroDocumento",$datos["numeroDocumento"]); 

$aValidate=$oItem->getDatos(); 

unset($oItem); 



if(empty($aValidate)){



    $clave=substr(uniqid(),0,8); 

    $aDatos["nombreUsuario"]=$datos["nombres"]; 

    $aDatos["apellidoUsuario"]=$datos["apellidos"]; 

    $aDatos["clave"]=md5($clave); 

    $aDatos["tipoDocumento"]=$datos["tipoDocumento"]; 

    $aDatos["numeroDocumento"]=$datos["numeroDocumento"]; 

    $aDatos["genero"]=$datos["genero"]; 

    $aDatos["correo"]=$datos["correo"]; 

    $aDatos["telefono"]=$datos["telefono"]; 

    $aDatos["direccion"]=$datos["direccion"]; 

    $aDatos["idDepartamentoResidencia"]=$datos["idDepartamentoResidencia"]; 

    $aDatos["idCiudadResidencia"]=$datos["idCiudadResidencia"]; 

    $aDatos["idRol"]=$datos["idRol"]; 

    $aDatos["ingresoPerfilEmpresa"]=$datos["ingresoPerfilEmpresa"]; 

    $aDatos["cambiarClave"]=1; 

    $aDatos["ingresoPlataforma"]=1; 

    $aDatos["estado"]=1; 

    $aDatos["foto"]=$sFoto; 

    $aDatos["fechaRegistro"]=date("Y-m-d H:i:s"); 

    



    $oItem=new Data("usuario","idUsuario"); 

    foreach($aDatos  as $key => $value){

        $oItem->$key=$value; 

    }

    $oItem->guardar(); 

    $idusuario=$oItem->ultimoId(); 

    unset($oItem);



    $mensaje="<p>Estimado ".$datos["nombres"]." ".$datos["apellidos"]." <br>

    Ud ha sido registrado en la plataforma SmartBuss, sus credenciales de acceso son: <br><br>

    Usuario: ".$datos["numeroDocumento"]." <br>

    Clave: ".$clave." <br>

    Link de acceso: <a href='".$URL."login'>LINK</a></p>"; 



    $aEmail["correo"]=$datos["correo"]; 

    $aEmail["asunto"]="Usuario creado"; 

    $aEmail["mensaje"]=$mensaje; 



    

    $oControl->enviarCorreo($aEmail); 

    

    if($datos["idRol"]!=1){

        $aEncript["cadena"]=$idusuario; 

        $usuario=$oControl->encriptar($aEncript);

    }

    

    $msg=true; 

}else{

    $msg=false; 

}



 



echo json_encode(array("msg"=>$msg,"idUsuario"=>$usuario));

?>