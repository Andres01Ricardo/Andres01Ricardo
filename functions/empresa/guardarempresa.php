<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");



$oControl=new Control();



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

$datosRepresentante  = (isset($_REQUEST['representante'] ) ? $_REQUEST['representante'] : "" );

if(!isset($_SESSION)){ session_start(); }

$sFoto = "";

$sRepresentante = "";

$sCamara = "";

$sRut = "";



if( isset($_FILES['cedula']) && $_FILES['cedula'] != 'undefined')

    {

               

        $sNombre = $_FILES['cedula']['name'];                

        $sExtension = substr(strrchr($sNombre, '.'), 1);

        $sTemporal = $_FILES['cedula']['tmp_name'];

        

        $nombreEncript = uniqid(); 

        

        $nombre_archivo = "{$nombreEncript}.{$sExtension}"; 

        

        $directorioTmp = 'REPRESENTANTE/';

        $ubicacionTmp = "{$directorioTmp}{$nombre_archivo}";  



        if(move_uploaded_file($sTemporal, "../../".$directorioTmp.$nombre_archivo))

        {	

            $sRepresentante = 'REPRESENTANTE/'.$nombre_archivo;

        }

    

} 

if( isset($_FILES['logo']) && $_FILES['logo'] != 'undefined')

    {

               

        $sNombre = $_FILES['logo']['name'];                

        $sExtension = substr(strrchr($sNombre, '.'), 1);

        $sTemporal = $_FILES['logo']['tmp_name'];

        

        $nombreEncript = uniqid(); 

        

        $nombre_archivo = "{$nombreEncript}.{$sExtension}"; 

        

        $directorioTmp = 'EMPRESA/';

        $ubicacionTmp = "{$directorioTmp}{$nombre_archivo}";  



        if(move_uploaded_file($sTemporal, "../../".$directorioTmp.$nombre_archivo))

        {   

            $sFoto = 'EMPRESA/'.$nombre_archivo;

        }

    

} 

if( isset($_FILES['camaraComercio']) && $_FILES['camaraComercio'] != 'undefined')

    {

               

        $sNombre = $_FILES['camaraComercio']['name'];                

        $sExtension = substr(strrchr($sNombre, '.'), 1);

        $sTemporal = $_FILES['camaraComercio']['tmp_name'];

        

        $nombreEncript = uniqid(); 

        

        $nombre_archivo = "{$nombreEncript}.{$sExtension}"; 

        

        $directorioTmp = 'CAMARACOMERCIO/';

        $ubicacionTmp = "{$directorioTmp}{$nombre_archivo}";  



        if(move_uploaded_file($sTemporal, "../../".$directorioTmp.$nombre_archivo))

        {   

            $sCamara = 'CAMARACOMERCIO/'.$nombre_archivo;

        }

    

} 

if( isset($_FILES['rut']) && $_FILES['rut'] != 'undefined')

    {

               

        $sNombre = $_FILES['rut']['name'];                

        $sExtension = substr(strrchr($sNombre, '.'), 1);

        $sTemporal = $_FILES['rut']['tmp_name'];

        

        $nombreEncript = uniqid(); 

        

        $nombre_archivo = "{$nombreEncript}.{$sExtension}"; 

        

        $directorioTmp = 'RUT/';

        $ubicacionTmp = "{$directorioTmp}{$nombre_archivo}";  



        if(move_uploaded_file($sTemporal, "../../".$directorioTmp.$nombre_archivo))

        {   

            $sRut = 'RUT/'.$nombre_archivo;

        }

    

} 





$oItem=new Data("empresa","nit",$datos["NIT"]); 

$aValidate=$oItem->getDatos(); 

unset($oItem); 

if(empty($aValidate)){

    $aDatos["tipoPersona"]=$datos["tipoPersona"]; 
    $aDatos["nit"]=$datos["NIT"]; 
    $aDatos["digitoVerificador"]=$datos["digitoVerificador"]==""?0:$datos["digitoVerificador"]; 
    $aDatos["razonSocial"]=$datos["razonSocial"]; 
    $aDatos["email"]=$datos["correo"]; 
    $aDatos["telefono"]=$datos["telefono"]; 
    $aDatos["idDepartamento"]=$datos["idDepartamento"]; 
    $aDatos["idCiudad"]=$datos["idCiudad"]; 
    $aDatos["direccion"]=$datos["direccion"]; 
    $aDatos["estado"]=1; 
    $aDatos["periodoPago"]=1; 
    $aDatos["logo"]=$sFoto; 
    $aDatos["camaraComercio"]=$sCamara; 
    $aDatos["rut"]=$sRut; 
    $aDatos["fechaRegistro"]=date("Y-m-d H:i:s"); 

    $aDatos["manejaInventario"]=$datos["inventario"]==""?0:1;
    $aDatos["manejaContabilidad"]=$datos["contabilidad"]==""?0:1; 


    $oItem=new Data("empresa","idEmpresa"); 

    foreach($aDatos  as $key => $value){
        $oItem->$key=$value; 
    }
    $oItem->guardar(); 
    $idEmpresa=$oItem->ultimoId(); 
    unset($oItem);

    if ($_SESSION['idRol']==5) {
        $aUsuarioEmpresa["idUsuario"]=$_SESSION['idUsuario'];
        $aUsuarioEmpresa["idEmpresa"]=$idEmpresa;
        $oItem=new Data("usuario_empresa","idUsuarioEmpresa"); 

        foreach($aUsuarioEmpresa  as $keyUE => $valueUE){

            $oItem->$keyUE=$valueUE; 

        }

        $oItem->guardar(); 
        unset($oItem);
    }


    $aRepresentante["tipoDocumento"]=$datosRepresentante["tipoDocumento"];
    $aRepresentante["numeroDocumento"]=$datosRepresentante["numeroDocumento"];  
    $aRepresentante["nombres"]=$datosRepresentante["nombres"]; 
    $aRepresentante["apellidos"]=$datosRepresentante["apellidos"]; 
    $aRepresentante["email"]=$datosRepresentante["correo"]; 
    $aRepresentante["telefono"]=$datosRepresentante["telefono"]; 
    $aRepresentante["cedula"]=$sRepresentante; 
    $aRepresentante["idEmpresa"]=$idEmpresa; 
    $aRepresentante["fechaRegistro"]=date("Y-m-d H:i:s"); 

    $oItem=new Data("representante_legal","idRepresentanteLegal"); 

    foreach($aRepresentante  as $key => $value){
        $oItem->$key=$value; 
    }
    $oItem->guardar(); 
    unset($oItem);



    $clave=substr(uniqid(),0,8);

    $aUsuario["nombreUsuario"]="Administrador";
    $aUsuario["apellidoUsuario"]=$datos["razonSocial"];
    $aUsuario["clave"]=md5($clave); 
    $aUsuario["tipoDocumento"]=3; 
    $aUsuario["numeroDocumento"]=$datos["NIT"]; 
    $aUsuario["genero"]=0; 
    $aUsuario["correo"]=$datos["correo"]; 
    $aUsuario["telefono"]=$datos["telefono"]; 
    $aUsuario["direccion"]=$datos["direccion"]; 
    $aUsuario["idDepartamentoResidencia"]=$datos["idDepartamento"]; 
    $aUsuario["idCiudadResidencia"]=$datos["idCiudad"]; 
    $aUsuario["idRol"]=3; 
    $aUsuario["cambiarClave"]=1; 
    $aUsuario["ingresoPlataforma"]=1; 
    $aUsuario["estado"]=1; 
    $aUsuario["ingresoPerfilEmpresa"]=0; 
    $aUsuario["foto"]=$sFoto; 
    $aUsuario["fechaRegistro"]=date("Y-m-d H:i:s"); 

    $oItem=new Data("usuario","idUsuario"); 

    foreach($aUsuario  as $key => $value){
        $oItem->$key=$value;
    }
    $oItem->guardar(); 
    $usuario=$oItem->ultimoId(); 
    unset($oItem);

        $oItem=new Data("tercero","nit",$datos["NIT"]);
        $aCliente=$oItem->getDatos();
        if (empty($aCliente)) {
            $aDatosC["tipoPersona"]=$datos["tipoPersona"]; 
            $aDatosC["nit"]=$datos["NIT"];
            $aDatosC["digitoVerificador"]=$datos["digitoVerificador"]==""?0:$datos["digitoVerificador"];
            $aDatosC["razonSocial"]=$datos["razonSocial"]; 
            $aDatosC["email"]=$datos["correo"];  
            $aDatosC["telefono"]=$datos["telefono"]; 
            $aDatosC["idDepartamento"]=$datos["idDepartamento"]; 
            $aDatosC["idCiudad"]=$datos["idCiudad"]; 
            $aDatosC["direccion"]=$datos["direccion"]; 
            $aDatosC["fechaRegistro"]=date("Y-m-d H:i:s");
            $aDatosC["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
            $aDatosC["estado"]=1; 
            $aDatosC["responsableIva"]=$datos["responsableIva"];
            $aDatosC["periodoPago"]=30; 
            
            $aDatosC["tipoTercero"]='p'; 
            $aDatosC["idPais"]='42'; 



            $oItem=new Data("tercero","idTercero"); 
            foreach($aDatosC  as $keyC => $valueC){
                $oItem->$keyC=$valueC; 
            }
            $oItem->guardar(); 
            $idTercero=$oItem->ultimoId(); 
            unset($oItem);

            $aDatosTC["idTercero"]=$idTercero;
            $aDatosTC["idEmpresa"]=$idEmpresa;

            $oItem=new Data("tercero_empresa","idTerceroEmpresa"); 
            foreach($aDatosTC  as $keyTC => $valueTC){
                $oItem->$keyTC=$valueTC; 
            }
            $oItem->guardar(); 
            unset($oItem);

        }else{
            $oLista=new Lista("tercero_empresa");
            $oLista->setFiltro("idTercero","=",$aCliente["idTercero"]);
            $oLista->setFiltro("idEmpresa","=",$idEmpresa);
            $terceroEmp=$oLista->getLista();
            unset($oLista);

            if (empty($terceroEmp)) {
                
                $aDatosTC["idTercero"]=$aCliente["idTercero"];
                $aDatosTC["idEmpresa"]=$idEmpresa;

                $oItem=new Data("tercero_empresa","idTerceroEmpresa"); 
                foreach($aDatosTC  as $keyTC => $valueTC){
                    $oItem->$keyTC=$valueTC; 
                }
                $oItem->guardar(); 
                unset($oItem);

            }
        }

    

    $oItem=new Data("empresa_acceso","idEmpresaAcceso"); 
    $oItem->idUsuario=$usuario; 
    $oItem->idEmpresa=$idEmpresa; 
    $usuario=$oItem->guardar(); 
    unset($oItem);

    $mensaje="<p>Hola ".$datos["razonSocial"]." <br>
    Se le ha dado acceso para ingresar a la plataforma SmartBuss como empresa, sus credenciales de acceso son: <br><br>
    Usuario: ".$datos["NIT"]." <br>
    Clave: ".$clave." <br>
    Link de acceso: <a href='".$URL."login'>LINK</a></p>"; 


    $aEmail["correo"]=$datos["correo"]; 
    $aEmail["asunto"]="Acceso SmartBuss"; 
    $aEmail["mensaje"]=$mensaje;     

    $oControl->enviarCorreo($aEmail);

    $msg=true; 

}else{
    $msg=false; 
}



echo json_encode(array("msg"=>$msg));

?>