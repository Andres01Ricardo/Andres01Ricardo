<?php 


header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

$centroCosto  = (isset($_REQUEST['centroCosto'] ) ? $_REQUEST['centroCosto'] : "" );
$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );
$subcentroCosto  = (isset($_REQUEST['subcentroCosto'] ) ? $_REQUEST['subcentroCosto'] : "" );


// print_r($centroCosto);
// print_r($subcentroCosto);
// print_r($idEmpresa);


$oLista=new Lista("centro_costo");
$oLista->setFiltro("codigoCentroCosto","=",$centroCosto);
$oLista->setFiltro("idEmpresa","=",$idEmpresa);
$lCentroCosto=$oLista->getLista();
unset($oLista);

if (!empty($lCentroCosto)) {
    $idCentroCosto=$lCentroCosto[0]["idCentroCosto"];
    $msg=2;
    // code...
    if (!empty($subcentroCosto)) {
        $oLista=new Lista("subcentro_costo");
        $oLista->setFiltro("codigoSubcentroCosto","=",$subcentroCosto);
        $oLista->setFiltro("idCentroCosto","=",$idCentroCosto);
        $lSubcentroCosto=$oLista->getLista();
        unset($oLista);
        if (!empty($lSubcentroCosto)) {
            $idSubcentroCosto=$lSubcentroCosto[0]["idSubcentroCosto"];
            $msg=3;
        }else{
            $idSubcentroCosto=0;
            $msg=1;
        }
    }else{
        $idSubcentroCosto=0;
        $msg=4;
    }
}else{
    $msg=0;
    $idCentroCosto=0;
    $idSubcentroCosto=0;
}





echo json_encode(array("msg"=>$msg,"idCentroCosto"=>$idCentroCosto,"idSubcentroCosto"=>$idSubcentroCosto));

?>