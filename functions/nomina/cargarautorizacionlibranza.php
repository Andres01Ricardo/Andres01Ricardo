<?php 

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");



$oControl=new Control();



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

// $item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );

// $cuenta  = (isset($_REQUEST['cuenta'] ) ? $_REQUEST['cuenta'] : "" );

$idLibranza=$datos['idLibranza'];

if( isset($_FILES['autorizacionLibranza']) && $_FILES['autorizacionLibranza'] != 'undefined')

    {

               

        $sNombre = $_FILES['autorizacionLibranza']['name'];                

        $sExtension = substr(strrchr($sNombre, '.'), 1);

        $sTemporal = $_FILES['autorizacionLibranza']['tmp_name'];

        

        $nombreEncript = uniqid(); 

        

        $nombre_archivo = "{$nombreEncript}.{$sExtension}"; 

        

        $directorioTmp = 'AUTORIZACIONLIBRANZA/';

        $ubicacionTmp = "{$directorioTmp}{$nombre_archivo}";  



        if(move_uploaded_file($sTemporal, "../../".$directorioTmp.$nombre_archivo))

        {	

            $sBalance = 'AUTORIZACIONLIBRANZA/'.$nombre_archivo;

        }else{

        	echo "vacio"; 

        }


    $Datos['autorizacionLibranza']=$sBalance;


    $oItem=new Data("libranza","idLibranza",$idLibranza); 
    foreach($Datos  as $key => $value){
    $oItem->$key=$value; 
    }
    $oItem->guardar(); 
    unset($oItem); 

} 

echo json_encode(array("msg"=>true,"idLibranza"=>$idLibranza));

?>