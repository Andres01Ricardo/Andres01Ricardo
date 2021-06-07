<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");



$oControl=new Control();



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

$contacto  = (isset($_REQUEST['contacto'] ) ? $_REQUEST['contacto'] : "" );

$contrato  = (isset($_REQUEST['contrato'] ) ? $_REQUEST['contrato'] : "" );

$crearUsuario= (isset($_REQUEST['crearUsuario'] ) ? $_REQUEST['crearUsuario'] : "" );





if( isset($_FILES['file']) && $_FILES['file'] != 'undefined')

    {

               

        $sNombre = $_FILES['file']['name'];                

        $sExtension = substr(strrchr($sNombre, '.'), 1);

        $sTemporal = $_FILES['file']['tmp_name'];

        

        $nombreEncript = uniqid(); 

        

        $nombre_archivo = "{$nombreEncript}.{$sExtension}"; 

        

        $directorioTmp = 'EMPLEADO/'.$directorio;

        $ubicacionTmp = "{$directorioTmp}{$nombre_archivo}";  



        if(move_uploaded_file($sTemporal, "../../".$directorioTmp.$nombre_archivo))

        {	

//        var_dump("verdadero");                                                

            $sFoto = $nombre_archivo;

        }

        else

        {

//        	var_dump($sTemporal, $directorioTmp.$nombre_archivo, "falso", move_uploaded_file($sTemporal, '/'.$directorioTmp.$nombre_archivo)); 

            $sFoto = "";

        }

    

} 





$oItem=new Data("empleado","numeroDocumento",$datos["numeroDocumento"]); 

$aValidate=$oItem->getDatos(); 

unset($oItem); 



if(empty($aValidate)){

    $aDatos["nombre"]=$datos["nombres"]; 

    $aDatos["apellido"]=$datos["apellidos"]; 

    $aDatos["tipoDocumento"]=$datos["tipoDocumento"]; 

    $aDatos["numeroDocumento"]=$datos["numeroDocumento"]; 

    $aDatos["genero"]=$datos["genero"]; 

    $aDatos["email"]=$datos["correo"]; 

    $aDatos["telefono"]=$datos["telefono"]; 

    $aDatos["direccion"]=$datos["direccion"]; 

    $aDatos["idDepartamentoResidencia"]=$datos["idDepartamentoResidencia"]; 

    $aDatos["idCiudadResidencia"]=$datos["idCiudadResidencia"]; 

    $aDatos["estado"]=1; 

    $aDatos["fechaRegistro"]=date("Y-m-d H:i:s"); 



    $oItem=new Data("empleado","idEmpleado"); 

    foreach($aDatos  as $key => $value){

        $oItem->$key=$value; 

    }

    $oItem->guardar(); 

    $idEmpleado=$oItem->ultimoId(); 

    unset($oItem);



    $aContacto["idEmpleado"]=$idEmpleado; 

    $aContacto["nombre"]=$contacto["nombre"];

    $aContacto["telefono"]=$contacto["telefono"];

    $aContacto["parentezco"]=$contacto["parentezco"]; 

    $oItem=new Data("empleado_contacto_emergencia","idEmpleadoContactoEmergencia"); 

    foreach($aContacto  as $key => $value){

        $oItem->$key=$value; 

    }

    $oItem->guardar();

    unset($oItem);





    if(!isset($_SESSION)){ session_start(); }

    $aLaboral["idEmpleado"]=$idEmpleado; 

    $aLaboral["idEmpresa"]=$_SESSION["idEmpresa"];

    $aLaboral["idUsuarioRegistra"]=$_SESSION["idUsuario"];

    $aLaboral["fechaIngreso"]=$contrato["fechaIngreso"];

    $aLaboral["tipoContrato"]=$contrato["tipoContrato"]; 

    $aLaboral["cargo"]=$contrato["cargo"]; 

    $aLaboral["tipoSalario"]=$contrato["tipoSalario"]; 

    $aLaboral["funciones"]=$contrato["funciones"]; 

    $aLaboral["valorSalario"]=str_replace("$", "", str_replace(".", "", $contrato["valorSalario"])); 

    // $aLaboral["diasDescanso"]=$contrato["diasDescanso"];

    $aLaboral["auxilioTransporte"]=str_replace("$", "", str_replace(".", "", $contrato["auxilioTransporte"]));

    $aLaboral["anexoContrato"]=$sFoto; 

    $aLaboral["idFondoCesantias"]=$contrato["idFondoCesantias"]; 

    $aLaboral["idFondoPensiones"]=$contrato["idFondoPensiones"]; 

    $aLaboral["idEps"]=$contrato["idEps"]; 

    $aLaboral["idArl"]=$contrato["idArl"]; 

    $aLaboral["riesgoLaboral"]=$contrato["riesgoLaboral"]; 

    $aLaboral["estado"]=1; 

    $oItem=new Data("empleado_informacion_laboral","idEmpleadoInformacionLaboral"); 

    foreach($aLaboral  as $key => $value){

        $oItem->$key=$value; 

    }

    $oItem->guardar();

    unset($oItem);

        $aUserEmp["idEmpleado"]=$idEmpleado;
        $aUserEmp["idEmpresa"]=$_SESSION["idEmpresa"];

            $oItem=new Data("empleado_empresa","idEmpleadoEmpresa"); 

            foreach($aUserEmp  as $key => $value){

                $oItem->$key=$value; 

            }

            $oItem->guardar(); 

            // $idUsuario=$oItem->ultimoId(); 

            unset($oItem);




    if($crearUsuario==1){



        $oItem=new Data("usuario","numeroDocumento",$datos["numeroDocumento"]); 

        $aValidate2=$oItem->getDatos(); 

        unset($oItem); 

        if(empty($aValidate2)){

            $clave=substr(uniqid(),0,8);



            $aUser["nombreUsuario"]=$datos["nombres"];

            $aUser["clave"]=md5($clave);  

            $aUser["apellidoUsuario"]=$datos["apellidos"]; 

            $aUser["tipoDocumento"]=$datos["tipoDocumento"]; 

            $aUser["numeroDocumento"]=$datos["numeroDocumento"]; 

            $aUser["genero"]=$datos["genero"]; 

            $aUser["correo"]=$datos["correo"]; 

            $aUser["telefono"]=$datos["telefono"]; 

            $aUser["direccion"]=$datos["direccion"]; 

            $aUser["idDepartamentoResidencia"]=$datos["idDepartamentoResidencia"]; 

            $aUser["idCiudadResidencia"]=$datos["idCiudadResidencia"]; 

            $aUser["estado"]=1; 

            $aUser["idRol"]=4; 

            $aUser["cambiarClave"]=1; 

            $aUser["ingresoPlataforma"]=1; 

            $aUser["fechaRegistro"]=date("Y-m-d H:i:s"); 

            $aUser["ingresoPerfilEmpresa"]=0;
            $aUser["foto"]=" ";

            $oItem=new Data("usuario","idUsuario"); 

            foreach($aUser  as $key => $value){

                $oItem->$key=$value; 

            }

            $oItem->guardar(); 

            $idUsuario=$oItem->ultimoId(); 

            unset($oItem);



            $oItem=new Data("empleado_usuario","idEmpleadoUsuario"); 

            $oItem->idUsuario=$idUsuario; 

            $oItem->idEmpleado=$idEmpleado; 

            $oItem->guardar(); 

            unset($oItem);





            $oItem=new Data("empresa","idEmpresa",$_SESSION["idEmpresa"]); 

            $aEmpresa=$oItem->getDatos(); 

            unset($oItem);



            $mensaje="<p>Estimado ".$datos["nombres"]." ".$datos["apellidos"]." <br>

            Ud ha sido registrado en la plataforma SmartBuss bajo la empresa ".$aEmpresa["razonSocial"].", sus credenciales de acceso son: <br><br>

            Usuario: ".$datos["numeroDocumento"]." <br>

            Clave: ".$clave." <br>

            Link de acceso: <a href='".$URL."login'>LINK</a></p>"; 



            $aEmail["correo"]=$datos["correo"]; 

            $aEmail["asunto"]="Usuario creado"; 

            $aEmail["mensaje"]=$mensaje; 



            

            $oControl->enviarCorreo($aEmail); 

        }

        

    }

    $msg=true; 

}else{
    $oItem=new Lista("empleado_empresa");
    $oItem->setFiltro("idEmpleado","=",$aValidate["idEmpleado"]); 
    $oItem->setFiltro("idEmpresa","=",$_SESSION["idEmpresa"]); 

    $aValidateEmpresa=$oItem->getLista(); 

    unset($oItem);
    if (empty($aValidateEmpresa)) {
        $aDatos["nombre"]=$datos["nombres"]; 

    $aDatos["apellido"]=$datos["apellidos"]; 

    $aDatos["tipoDocumento"]=$datos["tipoDocumento"]; 

    $aDatos["numeroDocumento"]=$datos["numeroDocumento"]; 

    $aDatos["genero"]=$datos["genero"]; 

    $aDatos["email"]=$datos["correo"]; 

    $aDatos["telefono"]=$datos["telefono"]; 

    $aDatos["direccion"]=$datos["direccion"]; 

    $aDatos["idDepartamentoResidencia"]=$datos["idDepartamentoResidencia"]; 

    $aDatos["idCiudadResidencia"]=$datos["idCiudadResidencia"]; 

    $aDatos["estado"]=1; 

    $aDatos["fechaRegistro"]=date("Y-m-d H:i:s"); 



    $oItem=new Data("empleado","idEmpleado"); 

    foreach($aDatos  as $key => $value){

        $oItem->$key=$value; 

    }

    $oItem->guardar(); 

    $idEmpleado=$oItem->ultimoId(); 

    unset($oItem);



    $aContacto["idEmpleado"]=$idEmpleado; 

    $aContacto["nombre"]=$contacto["nombre"];

    $aContacto["telefono"]=$contacto["telefono"];

    $aContacto["parentezco"]=$contacto["parentezco"]; 

    $oItem=new Data("empleado_contacto_emergencia","idEmpleadoContactoEmergencia"); 

    foreach($aContacto  as $key => $value){

        $oItem->$key=$value; 

    }

    $oItem->guardar();

    unset($oItem);





    if(!isset($_SESSION)){ session_start(); }

    $aLaboral["idEmpleado"]=$idEmpleado; 

    $aLaboral["idEmpresa"]=$_SESSION["idEmpresa"];

    $aLaboral["idUsuarioRegistra"]=$_SESSION["idUsuario"];

    $aLaboral["fechaIngreso"]=$contrato["fechaIngreso"];

    $aLaboral["tipoContrato"]=$contrato["tipoContrato"]; 

    $aLaboral["cargo"]=$contrato["cargo"]; 

    $aLaboral["tipoSalario"]=$contrato["tipoSalario"]; 

    $aLaboral["funciones"]=$contrato["funciones"]; 

    $aLaboral["valorSalario"]=str_replace("$", "", str_replace(".", "", $contrato["valorSalario"]));

    // $aLaboral["diasDescanso"]=$contrato["diasDescanso"];

    $aLaboral["auxilioTransporte"]=str_replace("$", "", str_replace(".", "", $contrato["auxilioTransporte"] ));

    $aLaboral["anexoContrato"]=$sFoto; 

    $aLaboral["idFondoCesantias"]=$contrato["idFondoCesantias"]; 

    $aLaboral["idFondoPensiones"]=$contrato["idFondoPensiones"]; 

    $aLaboral["idEps"]=$contrato["idEps"]; 

    $aLaboral["idArl"]=$contrato["idArl"]; 

    $aLaboral["riesgoLaboral"]=$contrato["riesgoLaboral"]; 

    $aLaboral["estado"]=1; 

    $oItem=new Data("empleado_informacion_laboral","idEmpleadoInformacionLaboral"); 

    foreach($aLaboral  as $key => $value){

        $oItem->$key=$value; 

    }

    $oItem->guardar();

    unset($oItem);

        $aUserEmp["idEmpleado"]=$aValidate["idEmpleado"];
        $aUserEmp["idEmpresa"]=$_SESSION["idEmpresa"];

            $oItem=new Data("empleado_empresa","idEmpleadoEmpresa"); 

            foreach($aUserEmp  as $key => $value){

                $oItem->$key=$value; 

            }

            $oItem->guardar(); 

            // $idUsuario=$oItem->ultimoId(); 

            unset($oItem);

    $msg=true; 

    }else{
        $msg=false; 

    }


}



 



echo json_encode(array("msg"=>$msg,"idUsuario"=>$usuario));

?>