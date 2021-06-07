<?php

require_once("../../php/restrict.php");
include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 

$id  = (isset($_REQUEST['idUser'] ) ? $_REQUEST['idUser'] : "" );

$oItem=new Data("usuario","idUsuario", $id); 
$aUser=$oItem->getDatos(); 
unset($oItem); 

$oItem=new Data("departamento","idDepartamento", $aUser["idDepartamentoResidencia"]); 
$aDepartamento=$oItem->getDatos(); 
unset($oItem); 

$oItem=new Data("ciudad","idCiudad", $aUser["idCiudadResidencia"]); 
$aCiudad=$oItem->getDatos(); 
unset($oItem); 

$oItem=new Data("rol","idRol", $aUser["idRol"]); 
$aRol=$oItem->getDatos(); 
unset($oItem); 

$oItem=new Data("tipo_documento","idTipoDocumento", $aUser["tipoDocumento"]); 
$aTipoDoc=$oItem->getDatos(); 
unset($oItem);

$tipoDoc=$aTipoDoc["nombre"]; 

$foto="https://via.placeholder.com/250x250/CCC?text=SIN%20FOTO"; 
if($aUser["foto"]!=""){
    $foto=$URL."USUARIOS/".$aUser["foto"]; 
}


$genero=$aUser["genero"]==1?'Masculino':'Femenino'; 
$estado=$aUser["estado"]==1?'Activo':'Inactivo'; 
$sHtml='<div class="setting-panel-header">Ver Información</div>
    <div class="p-15 border-bottom">
      <div class="centrar">
        <div class="foto-perfil" style="background-image:url('.$foto.')"></div>
      </div>
    </div>
    <div class="p-15 border-bottom centrar">
      <h6 class="font-medium m-b-10">'.$aUser["nombreUsuario"]." ".$aUser["apellidoUsuario"].'</h6>
    </div>
    <div class="p-15 border-bottom">
      <div class="theme-setting-options">
        <label class="m-b-0">
          <span class="negrita">Tipo Documento:</span> <span class="control-label p-l-10">'.$tipoDoc.'</span>
        </label>
      </div>
    </div>
    <div class="p-15 border-bottom">
      <div class="theme-setting-options">
        <label class="m-b-0">
          <span class="negrita">N° Documento:</span> <span class="control-label p-l-10">'.$aUser["numeroDocumento"].'</span>
        </label>
      </div>
    </div>
    <div class="p-15 border-bottom">
      <div class="theme-setting-options">
        <label class="m-b-0">
          <span class="negrita">Correo:</span> <span class="control-label p-l-10">'.$aUser["correo"].'</span>
        </label>
      </div>
    </div>
    <div class="p-15 border-bottom">
      <div class="theme-setting-options">
        <label class="m-b-0">
          <span class="negrita">Telefono:</span> <span class="control-label p-l-10">'.$aUser["telefono"].'</span>
        </label>
      </div>
    </div>
    <div class="p-15 border-bottom">
      <div class="theme-setting-options">
        <label class="m-b-0">
          <span class="negrita">Genero:</span> <span class="control-label p-l-10">'.$genero.'</span>
        </label>
      </div>
    </div>
    <div class="p-15 border-bottom">
      <div class="theme-setting-options">
        <label class="m-b-0">
          <span class="negrita">Ciudad Residencia:</span> <span class="control-label p-l-10">'.$aCiudad["nombre"]." - ".$aDepartamento["nombre"].'</span>
        </label>
      </div>
    </div>
    <div class="p-15 border-bottom">
      <div class="theme-setting-options">
        <label class="m-b-0">
          <span class="negrita">Dirección:</span> <span class="control-label p-l-10">'.$aUser["direccion"].'</span>
        </label>
      </div>
    </div>
    <div class="p-15 border-bottom">
      <div class="theme-setting-options">
        <label class="m-b-0">
          <span class="negrita">Estado:</span> <span class="control-label p-l-10">'.$estado.'</span>
        </label>
      </div>
    </div>'; 

echo $sHtml; 
?>