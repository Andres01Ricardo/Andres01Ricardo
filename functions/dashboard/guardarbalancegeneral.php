<?php 

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");



$oControl=new Control();



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

$item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );

$cuenta  = (isset($_REQUEST['cuenta'] ) ? $_REQUEST['cuenta'] : "" );



if( isset($_FILES['excel']) && $_FILES['excel'] != 'undefined')

    {

               

        $sNombre = $_FILES['excel']['name'];                

        $sExtension = substr(strrchr($sNombre, '.'), 1);

        $sTemporal = $_FILES['excel']['tmp_name'];

        

        $nombreEncript = uniqid(); 

        

        $nombre_archivo = "{$nombreEncript}.{$sExtension}"; 

        

        $directorioTmp = 'BALANCEGENERAL/';

        $ubicacionTmp = "{$directorioTmp}{$nombre_archivo}";  



        if(move_uploaded_file($sTemporal, "../../".$directorioTmp.$nombre_archivo))

        {	

            $sBalance = 'BALANCEGENERAL/'.$nombre_archivo;

        }else{

        	echo "vacio"; 

        }

    

} 

if(!isset($_SESSION)){ session_start(); }


$periodo=explode("-",$datos["periodo"]); 

$oLista=new Lista("balance_general");
$oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
$oLista->setFiltro("periodoMes","=",$periodo[0]);
$oLista->setFiltro("periodoAnio","=",$periodo[1]);
$balanceGeneral=$oLista->getLista();
unset($oLista);

        if (!empty($balanceGeneral)) {

            $msg=false;
        }
        if (empty($balanceGeneral)) {
            
        


            $aDatos["idEmpresa"]=$datos["idEmpresa"]; 

            $aDatos["periodoMes"]=$periodo[0]; 

            $aDatos["periodoAnio"]=$periodo[1]; 

            $aDatos["anexo"]=$sBalance; 

            $aDatos["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 

            $aDatos["titulo"]=$datos["titulo"]; 

            $aDatos["subtitulo"]=$datos["subtitulo"]; 

            $aDatos["fechaRegistro"]=date("Y-m-d H:i:s"); 



            $oItem=new Data("balance_general","idBalanceGeneral"); 

            foreach($aDatos  as $key => $value){

                $oItem->$key=$value; 

            }

            $oItem->guardar(); 

            $idBalance=$oItem->ultimoId(); 

            unset($oItem);



            $padre=0;

            foreach($item  as $pos => $valor){

                if($valor["tipo"]==1){

                    $padre=0;

                }

               $aItem["total"]=$valor["total"]==""?0:$oControl->eliminarMoneda($valor["total"]); 

               $aItem["idBalanceGeneral"]=$idBalance; 

               $aItem["titulo"]=$valor["nombre"]; 

               $aItem["porcentaje"]=$valor["porcentaje"]==""?0:substr($valor["porcentaje"],0,8); 

               $aItem["tipo"]=$valor["tipo"]; 

               $aItem["idItemPadre"]=$padre;

               

                $oItem=new Data("balance_general_item","idBalanceGeneralItem"); 

                foreach($aItem  as $key => $value){

                    $oItem->$key=$value; 

                }

                $oItem->guardar(); 

                if($valor["tipo"]==1){

                    $padre=$oItem->ultimoId();

                }else{

                    $iAgrupador=$oItem->ultimoId(); 

                }

                unset($oItem);



                foreach($cuenta[$pos]  as $iCuenta){

                    

                       $aCuenta["valor"]=$oControl->eliminarMoneda($iCuenta["total"]); 

                       $aCuenta["idBalanceGeneralItem"]=$iAgrupador; 

                       $aCuenta["numeroCuenta"]=$iCuenta["nroCuenta"]; 

                       $aCuenta["nombreCuenta"]=$iCuenta["cuenta"]; 

                       $aCuenta["porcentaje"]=$iCuenta["porcentaje"]==""?0:substr($iCuenta["porcentaje"],0,8); 

                       $aCuenta["tipo"]=$iCuenta["tipo"];

                       

                       //var_dump($aCuenta);   

                        $oItem=new Data("balance_general_cuenta","idBalanceGeneralCuenta"); 

                        foreach($aCuenta  as $key2 => $value2){

                            $oItem->$key2=$value2; 

                        }

                        $oItem->guardar(); 

                        unset($oItem);

                    

                }

            }

              $oItem=new Data("empresa_acceso","idEmpresa",$datos["idEmpresa"]); 

                $aUser=$oItem->getDatos();

                unset($oItem); 


                $sDatos["fechaNotificacion"]=date("Y-m-d H:m:s");
                $sDatos["idUsuarioRegistra"] = $_SESSION["idUsuario"];
                $sDatos["idUsuarioNotificado"] =$aUser["idUsuario"];
                $sDatos["notificacion"] =  "El usuario ".$_SESSION["nombreUsuario"]." ".$_SESSION["apellidoUsuario"]." ha cargado el balance general";
                

                $oItem=new Data("notificacion","idNotificacion"); 
                foreach($sDatos  as $key => $svalue){
                $oItem->$key=$svalue; 
                }
                $oItem->guardar(); 
                unset($oItem);

                $msg=true;
    }

echo json_encode(array("msg"=>$msg)); 



?>