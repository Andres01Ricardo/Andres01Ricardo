<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");


date_default_timezone_set("America/Bogota"); 



$item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );
$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );



if(!isset($_SESSION)){ session_start(); }

$fallos=[];
$control=true;

foreach ($item as $key => $value) {
        
        $oLista=new Lista("linea_inventario");
        $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
        $oLista->setFiltro("codigo","=",$value["codigoLinea"]);
        $lineaI=$oLista->getLista();
        unset($oLista);

        if (empty($lineaI)) {
            
            $aItem["codigo"]=$value["codigo"];
            $aItem["nombre"]=$value["linea"];
            $aItem["idEmpresa"]=$datos['idEmpresa'];
            $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"];
            $aItem["fechaRegistro"]= date("Y-m-d H:i:s");

            
            $oItem=new Data("linea_inventario","idLineaInventario"); 
            foreach($aItem  as $keyLinea => $valueLinea){
                // print_r($valueLinea);
                $oItem->$keyLinea=$valueLinea; 
                
            }
                $oItem->guardar();
                $idLinea=$oItem->ultimoId();
                unset($oItem);

        }

        if (!empty($lineaI)) {
            $idLinea=$lineaI[0]["idLineaInventario"];
        }



        $oLista=new Lista("cuenta_contable");
        $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
        $oLista->setFiltro("codigoCuenta","=",$value["inventario"]);
        $cuentaInventario=$oLista->getLista();
        unset($oLista);

        if (empty($cuentaInventario)) {
            $control=false;
        }

        $oLista=new Lista("cuenta_contable");
        $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
        $oLista->setFiltro("codigoCuenta","=",$value["costo"]);
        $cuentaInventarioCosto=$oLista->getLista();
        unset($oLista);

        if (empty($cuentaInventarioCosto)) {
            $control=false;
        }

        $oLista=new Lista("cuenta_contable");
        $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
        $oLista->setFiltro("codigoCuenta","=",$value["venta"]);
        $cuentaInventarioVenta=$oLista->getLista();
        unset($oLista);

        if (empty($cuentaInventarioVenta)) {
            $control=false;
        }

        $oLista=new Lista("cuenta_contable");
        $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
        $oLista->setFiltro("codigoCuenta","=",$value["devolucion"]);
        $cuentaInventarioDevolucion=$oLista->getLista();
        unset($oLista);


        if (empty($cuentaInventarioDevolucion)) {
            $control=false;
        }


        if ($control===true) {
            

            $oLista=new Lista("grupo_inventario");
            $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
            $oLista->setFiltro("codigo","=",$value["codigoGrupo"]);
            $grupoI=$oLista->getLista();
            unset($oLista);


            if (empty($grupoI)) {

                $aItem["codigo"]=$value["codigoGrupo"];
                $aItem["nombre"]=$value["grupo"];
                $aItem["inventario"]=$cuentaInventario[0]["idCuentaContable"];
                $aItem["costo"]=$cuentaInventarioCosto[0]["idCuentaContable"];;
                $aItem["venta"]=$cuentaInventarioVenta[0]["idCuentaContable"];;
                $aItem["devolucion"]=$cuentaInventarioDevolucion[0]["idCuentaContable"];;
                

                $aItem["idEmpresa"]=$datos['idEmpresa'];
                $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"];
                $aItem["fechaRegistro"]= date("Y-m-d H:i:s");
                $aItem["idLineaInventario"]=$idLinea;

                $oItem=new Data("grupo_inventario","idGrupoInventario"); 
                foreach($aItem  as $key => $value){
                    // print_r($value);
                    $oItem->$key=$value; 
                }
                    $oItem->guardar(); 
                   unset($oItem);
            }

        }
        if ($control===false) {
            // $fallos
            array_push($fallos,$value["codigoGrupo"]);
        }
}

$msg=true; 

echo json_encode(array("msg"=>$msg,"fallos"=>$fallos));

?>



