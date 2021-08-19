<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");



$oControl=new Control();



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );
$crearUsuario  = (isset($_REQUEST['crearUsuario'] ) ? $_REQUEST['crearUsuario'] : "" );

$usuario="";
$contrasena="";

    $aDatos["nombre"]=$datos["nombre"]; 

    $aDatos["apellido"]=$datos["apellido"]; 
    $aDatos["genero"]=$datos["genero"]; 

    $aDatos["tipoDocumento"]=$datos["tipoDocumento"]; 

    $aDatos["numeroDocumento"]=$datos["numeroDocumento"]; 

    $aDatos["email"]=$datos["email"]; 

    $aDatos["telefono"]=$datos["telefono"]; 

    $aDatos["direccion"]=$datos["direccion"]; 

    $aDatos["idDepartamentoResidencia"]=$datos["idDepartamento"]; 

    $aDatos["idCiudadResidencia"]=$datos["idCiudad"]; 

    // $aDatos["estado"]=1; 


    $oItem=new Data("empleado","idEmpleado",$datos["id"]); 

    foreach($aDatos  as $key => $value){

        $oItem->$key=$value; 

    }

    $oItem->guardar();  

    unset($oItem);


    $aContacto["nombre"]=$datos["contactoEmergenciaNombre"];

    $aContacto["telefono"]=$datos["contactoEmergenciaTelefono"];

    $aContacto["parentezco"]=$datos["contactoEmergenciaParentezco"]; 

    $oItem=new Data("empleado_contacto_emergencia","idEmpleado",$datos["id"]); 

    foreach($aContacto  as $key => $value){

        $oItem->$key=$value; 

    }

    $oItem->guardar();

    unset($oItem);





    if(!isset($_SESSION)){ session_start(); }


    $aLaboral["idUsuarioRegistra"]=$_SESSION["idUsuario"];



    $aLaboral["tipoContrato"]=$datos["tipoContrato"]; 
    $aLaboral["cargo"]=$datos["cargo"]; 
    $aLaboral["tipoSalario"]=$datos["tipoSalario"]; 
    $aLaboral["funciones"]=$datos["funciones"]; 

    $aLaboral["idFondoCesantias"]=$datos["idFondoCesantias"]; 

    $aLaboral["idFondoPensiones"]=$datos["idFondoPensiones"]; 

    $aLaboral["idEps"]=$datos["idEps"]; 
    $aLaboral["idArl"]=$datos["idArl"]; 
    $aLaboral["riesgoLaboral"]=$datos["riesgoLaboral"]; 
    $aLaboral["auxilioTransporte"]=str_replace("$", "", str_replace(".", "", $datos["auxilioTransporte"]));

    $aLaboral["valorSalario"]=str_replace("$", "", str_replace(".", "", $datos["salario"])); 

    // $aLaboral["estado"]=1;   

    $oItem=new Data("empleado_informacion_laboral","idEmpleado",$datos["id"]); 

    foreach($aLaboral  as $key => $value){

        $oItem->$key=$value; 

    }

    $oItem->guardar();

    unset($oItem);




    if($crearUsuario==1){



        $oItem=new Data("usuario","numeroDocumento",$datos["numeroDocumento"]); 

        $aValidate2=$oItem->getDatos(); 

        unset($oItem); 

        if(empty($aValidate2)){

            $clave=substr(uniqid(),0,8);



            $aUser["nombreUsuario"]=$datos["nombre"];

            $aUser["clave"]=md5($clave);  

            $aUser["apellidoUsuario"]=$datos["apellido"]; 

            $aUser["tipoDocumento"]=$datos["tipoDocumento"]; 

            $aUser["numeroDocumento"]=$datos["numeroDocumento"]; 

            $aUser["genero"]=$datos["genero"]; 

            $aUser["correo"]=$datos["email"]; 

            $aUser["telefono"]=$datos["telefono"]; 

            $aUser["direccion"]=$datos["direccion"]; 

            $aUser["idDepartamentoResidencia"]=$datos["idDepartamento"];

            $aUser["idCiudadResidencia"]=$datos["idCiudad"]; 

            $aUser["estado"]=1; 

            $aUser["estado"]=1; 
            if ($datos["tipoUsuario"]==1) {
                $aUser["idRol"]=4; 
            }
            if ($datos["tipoUsuario"]==2) {
                $aUser["idRol"]=3; 
            }

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



            // $oItem=new Data("empleado_usuario","idEmpleadoUsuario"); 

            // $oItem->idUsuario=$idUsuario; 

            // $oItem->idEmpleado=$datos["id"]; 

            // $oItem->guardar(); 

            // unset($oItem);

            if ($datos["tipoUsuario"]==1) {
                $oItem=new Data("empleado_usuario","idEmpleadoUsuario"); 

                $oItem->idUsuario=$idUsuario; 

                $oItem->idEmpleado=$idEmpleado; 

                $oItem->guardar(); 

                unset($oItem); 
            }
            if ($datos["tipoUsuario"]==2) {
                $oItem=new Data("empresa_acceso","idEmpresaAcceso"); 
                $oItem->idUsuario=$idUsuario; 
                $oItem->idEmpresa=$_SESSION["idEmpresa"];
                $usuario=$oItem->guardar(); 
                unset($oItem);
            }





            $oItem=new Data("empresa","idEmpresa",$_SESSION["idEmpresa"]); 

            $aEmpresa=$oItem->getDatos(); 

            unset($oItem);



            $mensaje="<p>Estimado ".$datos["nombre"]." ".$datos["apellido"]." <br>

            Ud ha sido registrado en la plataforma SmartBuss bajo la empresa ".$aEmpresa["razonSocial"].", sus credenciales de acceso son: <br><br>

            Usuario: ".$datos["numeroDocumento"]." <br>

            Clave: ".$clave." <br>

            Link de acceso: <a href='".$URL."login'>LINK</a></p>"; 



            $aEmail["correo"]=$datos["email"]; 

            $aEmail["asunto"]="Usuario creado"; 

            $aEmail["mensaje"]=$mensaje; 



            

            $oControl->enviarCorreo($aEmail); 

        }

        // $usuario=$datos["numeroDocumento"];
        // $contrasena=$clave;

    }





    $msg=true; 



// echo json_encode(array("msg"=>$msg,"usuario"=>$usuario,"contrasena"=>$contrasena));
echo json_encode(array("msg"=>$msg));

?>