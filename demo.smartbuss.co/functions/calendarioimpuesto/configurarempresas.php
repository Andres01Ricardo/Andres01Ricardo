<?php
header('Content-type: application/json');
require_once("../../php/restrict.php");
require_once("../../class/impuestos.php"); 

$oImpuestos=new Impuestos();  
include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 

$id  = (isset($_REQUEST['id'] ) ? $_REQUEST['id'] : "" );
$tipo  = (isset($_REQUEST['tipo'] ) ? $_REQUEST['tipo'] : "" );
$item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );

$oItem=new Data("fecha_retencion_iva","idFechaRetencionIva",$id); 
$aDatos=$oItem->getDatos(); 
unset($oItem);


$oLista = new Lista('fecha_retencion_iva_empresa');
$oLista->setFiltro("idFechaRetencionIva","=",$id);
$aLista=$oLista->getLista()[0];

foreach($aLista as $aItem){
    $oItem=new Data("fecha_retencion_iva_empresa","idFechaRetencionIvaEmpresa",$aItem["idFechaRetencionIvaEmpresa"]); 
    $oItem->eliminar(); 
    unset($oItem);
}


foreach ($item as $key => $value) {
    if($value["estado"]==1){

        $aFiltro["idEmpresa"]=$value["idEmpresa"]; 
        $aFiltro["tipo"]=$aDatos["tipoImpuesto"]; 
        $aFiltro["anio"]=$aDatos["anio"]; 
        $aFiltro["periodoDiferente"]=$aDatos["idPeriocidad"]; 
        $aValidate=$oImpuestos->getEmpresaCalendario($aFiltro)[0];

        if(!empty($aValidate)){
            $oItem=new Data("fecha_retencion_iva_empresa","idFechaRetencionIvaEmpresa",$aValidate["idFechaRetencionIvaEmpresa"]); 
            $oItem->eliminar(); 
            unset($oItem);
        }

        $oItem=new Data("fecha_retencion_iva_empresa","idFechaRetencionIvaEmpresa"); 
        $oItem->idFechaRetencionIva=$id; 
        $oItem->idEmpresa=$value["idEmpresa"]; 
        $oItem->guardar(); 
        unset($oItem); 
    }
}


$msg=true; 

 

echo json_encode(array("msg"=>$msg));
?>