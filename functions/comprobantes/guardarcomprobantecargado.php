<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 

$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );
$item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );
$comprobante  = (isset($_REQUEST['comprobante'] ) ? $_REQUEST['comprobante'] : "" );


// print_r($datos);

// print_r($comprobante);

if(!isset($_SESSION)){ session_start(); }

$existeC=0;
foreach ($item as $key => $value) {
    foreach ($value as $keyV => $valueV) {
        
        if ($keyV==="tipo") {
            $oItem=new Lista("tipos_documento_contable");
            $oItem->setFiltro("letra","like",$valueV);
            $aTipo=$oItem->getLista();
            unset($oItem);

            $aDatos["idTipo"]=$aTipo[0]["idTiposDocumento"];
        }
        elseif ($keyV==="comprobante") {
            $aDatos["comprobante"]=$valueV; 
        }
        elseif ($keyV==="fecha") {
            $fech=str_replace("/", "-", $valueV);
            $aDatos["fecha"]=$fech;
            $fecha= $fech;
            
        }
        elseif ($keyV==="numero") {
            $aDatos["numero"]=$valueV; 
            $aDatos["fechaRegistro"]=date('Y-m-d'); 
            $aDatos["usuarioRegistra"]=$_SESSION["idUsuario"]; 
            $aDatos["archivo"]=""; 
            $aDatos["observaciones"]=" "; 
            $aDatos["idEmpresa"]=$datos["idEmpresa"]; 

            $oItem=new Lista("comprobante");
            $oItem->setFiltro("numero","=",$valueV);
            $oItem->setFiltro("idTipo","=",$aDatos["idTipo"]);
            $oItem->setFiltro("comprobante","=",$aDatos["comprobante"]);
            $oItem->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
            $existeComp=$oItem->getLista();
            unset($oItem);
            // print_r($existeComp);

            if (empty($existeComp)) {
                $oItem=new Data("comprobante","idComprobante"); 
                foreach($aDatos  as $keyCG => $valueCG){
                    $oItem->$keyCG=$valueCG; 
                }
                $oItem->guardar(); 
                $idComprobante=$oItem->ultimoId(); 
                unset($oItem);
                $existeC=0;
            }
            if (!empty($existeComp)) {
                $idComprobante=$existeComp[0]["idComprobante"];
                $existeC=1;
            }

        }
        else {
            $control=0;
            if($existeC==0){
                $aItem["idComprobante"]=$idComprobante; 

                if(substr($valueV["cuentaContable"], 0,1)=='0'){
                    $control=1;
                }
                if ($control==0) {

                    $oLista=new Lista("cuenta_contable");
                    $oLista->setFiltro("codigoCuenta","like",substr($valueV["cuentaContable"], 0,8)."%");
                    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
                    $aCuenta=$oLista->getLista();
                    unset($oLista);
                    $nombreC=explode("-", $valueV["cuentaContable"]);

                    if (!empty($aCuenta)) {
                        $idCuenta=$aCuenta[0]["idCuentaContable"];
                    }
                    if (empty($aCuenta)) {
                        $aCuentaC["nombre"]=$nombreC[1];
                        $aCuentaC["codigoCuenta"]=$nombreC[0];
                        
                        switch (substr($valueV["cuentaContable"], 0,1)) {
                            case 1:
                                $aCuentaC["naturaleza"]='debito';
                                $aCuentaC["tipoCuenta"]=1;
                                break;
                            case 2:
                                $aCuentaC["naturaleza"]='credito';
                                $aCuentaC["tipoCuenta"]=2;
                                break;
                            case 3:
                                $aCuentaC["naturaleza"]='credito';
                                $aCuentaC["tipoCuenta"]=3;
                                break;
                            case 4:
                                $aCuentaC["naturaleza"]='credito';
                                $aCuentaC["tipoCuenta"]=4;
                                break;
                            case 5:
                                $aCuentaC["naturaleza"]='debito';
                                $aCuentaC["tipoCuenta"]=5;
                                break;
                            case 6:
                                $aCuentaC["naturaleza"]='debito';
                                $aCuentaC["tipoCuenta"]=6;
                                break;
                            case 7:
                                $aCuentaC["naturaleza"]='debito';
                                $aCuentaC["tipoCuenta"]=7;
                                break;
                            
                            default:
                                // code...
                                break;
                        }
                        $aCuentaC["centroCosto"]=1;
                        $aCuentaC["idEmpresa"]=$datos["idEmpresa"];
                        $aCuentaC["detalle"]=1;
                        $aCuentaC["tercero"]=1;
                        $aCuentaC["porcentajeRetencion"]="";


                        $oItem=new Data("cuenta_contable","idCuentaContable"); 
                        foreach($aCuentaC  as $keyC => $valueC){
                            $oItem->$keyC=$valueC; 
                        }
                        $oItem->guardar(); 
                        $idCuenta=$oItem->ultimoId(); 
                        unset($oItem);
                        
                    }
                    $aItem["idCuentaContable"]=$idCuenta;
                }

                if (!empty($valueV["centroCosto"])) {
                    
                    $oLista=new Lista("centro_costo");
                    $oLista->setFiltro("codigoCentroCosto","=",$valueV["centroCosto"]);
                    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
                    $lCentroCosto=$oLista->getLista();
                    unset($oLista);

                    if (!empty($lCentroCosto)) {
                        $aItem["idCentroCosto"]=$lCentroCosto[0]["idCentroCosto"];
                        
                        $oLista=new Lista("subcentro_costo");
                        $oLista->setFiltro("codigoSubcentroCosto","=",$valueV["subcentroCosto"]);
                        $oLista->setFiltro("idCentroCosto","=",$lCentroCosto[0]["idCentroCosto"]);
                        $lSubcentroCosto=$oLista->getLista();
                        unset($oLista);
                        if (!empty($lSubcentroCosto)) {
                            $aItem["idSubcentroCosto"]=$lSubcentroCosto[0]["idSubcentroCosto"];
                        }else{
                            $aItem["idSubcentroCosto"]="";
                        }
                    }else{
                        $aItem["idCentroCosto"]="";
                    }
                }
                if (empty($valueV["centroCosto"])) {
                    $aItem["idSubcentroCosto"]="";
                    $aItem["idCentroCosto"]="";
                }

                if ($control==0) {
                    
                    $oItem=new Data("tercero","nit",$valueV["tercero"]); 
                    $aValidate=$oItem->getDatos(); 
                    unset($oItem); 

                    if(!empty($aValidate)){
                        $oItem=new Lista("tercero_empresa");
                        $oItem->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
                        $oItem->setFiltro("idTercero","=",$aValidate["idTercero"]);
                        $aTerceroE=$oItem->getLista();
                        unset($oItem); 

                        if (empty($aTerceroE)) {
                            $oItem=new Data("tercero_empresa","idTerceroEmpresa");
                            $oItem->idTercero=$aValidate["idTercero"];        
                            $oItem->idEmpresa=$datos["idEmpresa"]; 
                            $oItem->guardar(); 
                            unset($oItem);
                        }
                        $aItem["idTercero"]=$aValidate["idTercero"];
                    }
                    if(empty($aValidate)){
                        $aItem["idTercero"]="";    
                    }
                }
                if($control==1){
                    $aItem["idTercero"]="";  
                    $aItem["saldoCredito"]=0;
                    $aItem["saldoDebito"]=0;
                }

                $aItem["descripcion"]=$valueV["descripcion"]; 
                $aItem["tipoTercero"]='p'; 
                $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"];
                $aItem["fecha"]=$fecha;
                $valor=0;
                 if($control==0){   
                    if (floatval($valueV["debito"]) > "0.0") {  
                        $valor=$valueV["debito"];
                    }
                    if (floatval($valueV["credito"]) >"0.0") {
                        $valor=$valueV["credito"]; 
                    }

                    if (floatval($valueV["debito"]) == "0.0" && floatval($valueV["credito"]) == "0.0") {
                        $valor=0;
                    }
                    // print_r("valorDB->");
                    // print_r($valor);
                    // print_r("valorN->");
                    $valorN=floatval(str_replace("$", "", str_replace(",", "",$valor)));
                    // print_r($valorN);
                    if (floatval($valueV["debito"]) > "0.0") {  
                        $aItem["naturaleza"]='debito';  
                        $aItem["saldoDebito"]=str_replace(",", ".",$valorN);
                        $aItem["saldoCredito"]=0;
                    }
                    if (floatval($valueV["credito"]) >"0.0") {
                        $aItem["naturaleza"]='credito';
                        $aItem["saldoCredito"]=str_replace(",", ".",$valorN);
                        $aItem["saldoDebito"]=0;
                    }
                    if (floatval($valueV["debito"]) == "0.0" && floatval($valueV["credito"]) == "0.0") {
                        $valor=0;
                        $aItem["naturaleza"]='credito';
                        $aItem["saldoCredito"]=0;
                        $aItem["saldoDebito"]=0;
                    }


                }

                    if ($valueV["base"]!='') {
                        $aItem["base"]=$valueV["base"];
                    }
                    if ($valueV["base"]=='') {
                        $aItem["base"]=0;
                    }
                        $oItem=new Data("comprobante_items","idComprobanteItem"); 
                        foreach($aItem  as $keycc => $valuecc){
                            $oItem->$keycc=$valuecc; 
                        }
                        $oItem->guardar(); 
                        unset($oItem);

                    
            }
        }

    }
}


    $msg=true; 

    echo json_encode(array("msg"=>$msg));

?>