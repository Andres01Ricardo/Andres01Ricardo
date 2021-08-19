<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

$datosRepresentante  = (isset($_REQUEST['representante'] ) ? $_REQUEST['representante'] : "" );

$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );

$idRepresentanteLegal  = (isset($_REQUEST['idRepresentanteLegal'] ) ? $_REQUEST['idRepresentanteLegal'] : "" );



$sFoto = "";

$sRepresentante = "";

$sCamara = "";

$sRut = "";

if(!isset($_SESSION)){ session_start(); }

if( isset($_FILES['cedula']) && $_FILES['file'] != 'undefined')

    {

               

        $sNombre = $_FILES['file']['name'];                

        $sExtension = substr(strrchr($sNombre, '.'), 1);

        $sTemporal = $_FILES['file']['tmp_name'];

        

        $nombreEncript = uniqid(); 

        

        $nombre_archivo = "{$nombreEncript}.{$sExtension}"; 

        

        $directorioTmp = $URL.'REPRESENTANTE/'.$directorio;

        $ubicacionTmp = "{$directorioTmp}{$nombre_archivo}";  



        if(move_uploaded_file($sTemporal, '/'.$directorioTmp.$nombre_archivo))

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

        

        $directorioTmp = $URL.'EMPRESA/'.$directorio;

        $ubicacionTmp = "{$directorioTmp}{$nombre_archivo}";  



        if(move_uploaded_file($sTemporal, '/'.$directorioTmp.$nombre_archivo))

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

        

        $directorioTmp = $URL.'CAMARACOMERCIO/'.$directorio;

        $ubicacionTmp = "{$directorioTmp}{$nombre_archivo}";  



        if(move_uploaded_file($sTemporal, '/'.$directorioTmp.$nombre_archivo))

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

        

        $directorioTmp = $URL.'RUT/'.$directorio;

        $ubicacionTmp = "{$directorioTmp}{$nombre_archivo}";  



        if(move_uploaded_file($sTemporal, '/'.$directorioTmp.$nombre_archivo))

        {   

            $sRut = 'RUT/'.$nombre_archivo;

        }

    

} 



$aDatos["nit"]=$datos["NIT"]; 

$aDatos["digitoVerificador"]=$datos["digitoVerificador"]==""?0:$datos["digitoVerificador"]; 

$aDatos["razonSocial"]=$datos["razonSocial"]; 

$aDatos["email"]=$datos["correo"]; 

$aDatos["telefono"]=$datos["telefono"]; 

$aDatos["idDepartamento"]=$datos["idDepartamento"]; 

$aDatos["idCiudad"]=$datos["idCiudad"]; 

$aDatos["direccion"]=$datos["direccion"]; 

// $aDatos["logo"]=$sFoto; 

$aDatos["camaraComercio"]=$sCamara; 

$aDatos["rut"]=$sRut; 



$oItem=new Data("empresa","idEmpresa",$idEmpresa); 

foreach($aDatos  as $key => $value){

    $oItem->$key=$value; 

}

$oItem->guardar(); 

unset($oItem);





$aRepresentante["tipoDocumento"]=$datosRepresentante["tipoDocumento"];

$aRepresentante["numeroDocumento"]=$datosRepresentante["numeroDocumento"];  

$aRepresentante["nombres"]=$datosRepresentante["nombres"]; 

$aRepresentante["apellidos"]=$datosRepresentante["apellidos"]; 

$aRepresentante["email"]=$datosRepresentante["correo"]; 

$aRepresentante["telefono"]=$datosRepresentante["telefono"]; 

$aRepresentante["cedula"]=$sRepresentante; 

$aRepresentante["idEmpresa"]=$idEmpresa; 



$oItem=new Data("representante_legal","idRepresentanteLegal",$idRepresentanteLegal); 

foreach($aRepresentante  as $key => $value){

    $oItem->$key=$value; 

}

$oItem->guardar(); 

unset($oItem);



$oItem=new Data("empresa","idEmpresa",$idEmpresa); 

$aEmpresa=$oItem->getDatos(); 

unset($oItem); 



$oItem=new Data("usuario","numeroDocumento",$aEmpresa["nit"]); 

$aUser=$oItem->getDatos(); 

unset($oItem); 

// print_r($aUser);

$aUsuario["nombreUsuario"]='Administrador';
// $aUsuario["nombreUsuario"]=$datos["razonSocial"];
$aUsuario["apellidoUsuario"]=$datos["razonSocial"];

$aUsuario["correo"]=$datos["correo"]; 

$aUsuario["telefono"]=$datos["telefono"]; 

$aUsuario["direccion"]=$datos["direccion"]; 

$aUsuario["idDepartamentoResidencia"]=$datos["idDepartamento"]; 

$aUsuario["idCiudadResidencia"]=$datos["idCiudad"]; 

if($sFoto!=""){

    $aUsuario["foto"]=$sFoto; 

}





$oItem=new Data("usuario","idUsuario",$aUser["idUsuario"]); 

foreach($aUsuario  as $key => $value){

    $oItem->$key=$value; 

}

$oItem->guardar(); 

unset($oItem);


// print_r($_SESSION["idUsuario"]);



 if ($datos["checkCliente"]==1 || $datos["checkProveedor"]==1) {


                    $oItem=new Data("tercero","nit",$datos["NIT"]);
                    $aCliente=$oItem->getDatos();
                    if (empty($aCliente)) {
                        if ($datos["digitoVerificador"]==0) {
                            $aDatosC["tipoPersona"]=1; 
                        }
                        if ($datos["digitoVerificador"]!=0) {
                            $aDatosC["tipoPersona"]=2; 
                        }
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
                        $aDatosC["responsableIva"]=1;
                        $aDatosC["periodoPago"]=30; 


                        if ($datos["checkCliente"]==1 && $datos["checkProveedor"]==1) {
                            $aDatosC["tipoTercero"]=4;  
                        }
                        if ($datos["checkCliente"]==1 && $datos["checkProveedor"]!=1) {
                            $aDatosC["tipoTercero"]=1;  
                        }
                        if ($datos["checkCliente"]!=1 && $datos["checkProveedor"]==1) {
                            $aDatosC["tipoTercero"]=2;  
                        }                    

                        $oItem=new Data("tercero","idTercero"); 
                        foreach($aDatosC  as $keyC => $valueC){
                            $oItem->$keyC=$valueC; 
                        }
                        $oItem->guardar(); 
                        $idTercero=$oItem->ultimoId(); 
                        unset($oItem);



                        $oItem=new Data("tercero_empresa","idTerceroEmpresa");
                        $oItem->idTercero=$idTercero;        
                        $oItem->idEmpresa=$idEmpresa;
                        $oItem->guardar(); 
                        unset($oItem); 
                    }

    }









$msg=true; 





echo json_encode(array("msg"=>$msg));

?>