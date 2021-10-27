<?php 

header('Content-type: application/json');

require_once("../../php/restrict.php");

require_once('../../libraries/PHPExcel/Classes/PHPExcel.php');

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

if( isset($_FILES['excel']) && $_FILES['excel'] != 'undefined')

    {

        $sNombre = $_FILES['excel']['name'];                

        $sExtension = substr(strrchr($sNombre, '.'), 1);

        $sTemporal = $_FILES['excel']['tmp_name'];

        $nombreEncript = uniqid(); 

        $nombre_archivo = "{$nombreEncript}.{$sExtension}"; 

        $directorioTmp = 'COMPROBANTE/';

        $ubicacionTmp = "{$directorioTmp}{$nombre_archivo}";  

        if(move_uploaded_file($sTemporal, "../../".$directorioTmp.$nombre_archivo))

        {	

            $sFinanciero = 'COMPROBANTE/'.$nombre_archivo;

        }else{

        	echo "vacio"; 
        }    
} 

$archivo = "../../".$sFinanciero;

try {

    
    $inputFileType = PHPExcel_IOFactory::identify($archivo);

    $objReader = PHPExcel_IOFactory::createReader($inputFileType);

    $objPHPExcel = $objReader->load($archivo);

    $sheet = $objPHPExcel->getSheet(0); 

    $highestRow = $sheet->getHighestRow(); 

    $highestColumn = $sheet->getHighestColumn();

     // $aArray["fecha"]="2021-08-18";
     // $aArray["tipo"]=$archivo;
     // $aArray["tipoArchivo"]=$inputFileType;
    // $cabecera["titulo"]=$sheet->getCell("A1")->getValue();
    // $cabecera["fecha"]=$sheet->getCell("A2")->getValue();
    for ($row = 8; $row <= $highestRow; $row++){

        if($sheet->getCell("A".$row)->getValue()!=null){

            $cell = $sheet->getCell("A".$row);
            $InvDate= $cell->getValue();
            if(PHPExcel_Shared_Date::isDateTime($cell)) {
                 $InvDate = date($format = "Y/m/d", PHPExcel_Shared_Date::ExcelToPHP($InvDate)); 
            }
            
            // $aArray["fecha"]=$sheet->getCell("A".$row)->getValue();
            $aArray["fecha"]=$InvDate;
            $tipoComprobante=$sheet->getCell("B".$row)->getValue(); 
            $tipoC=explode("-", $tipoComprobante);
            $letra=$tipoC[0];
            $comprobante=intval($tipoC[1]);

            $oItem=new Data("tipos_documento_contable","letra",$letra);
            $idTipoD=$oItem->getDatos();
            unset($oItem);
            
            $oItem=new Data("tipos_documento_contable","letra",$letra);
            $idTipoD=$oItem->getDatos();
            unset($oItem);

            $aArray["tipo"]=$letra;
            $aArray["comprobante"]=$comprobante;
            $numeroComprobante=$sheet->getCell("C".$row)->getValue();
            $aArray["numero"]=intval($numeroComprobante);

            $aArray["nitTercero"]=$sheet->getCell("E".$row)->getValue();
            $aArray["codigoCuenta"]=$sheet->getCell("F".$row)->getValue();
            $aArray["descripcionCuenta"]=$sheet->getCell("G".$row)->getValue();
            
            if ($sheet->getCell("H".$row)->getValue()!=null) {
                $aArray["codigoCentroCosto"]=$sheet->getCell("H".$row)->getValue();
            }
            if ($sheet->getCell("I".$row)->getValue()!=null) {
                $aArray["codigoSubcentroCosto"]=$sheet->getCell("I".$row)->getValue();
            }
            if ($sheet->getCell("J".$row)->getValue()!=null) {
                $aArray["base"]=$sheet->getCell("J".$row)->getValue();
            }

            if ($sheet->getCell("H".$row)->getValue()==null) {
                $aArray["codigoCentroCosto"]=0;
            }
            if ($sheet->getCell("I".$row)->getValue()==null) {
                $aArray["codigoSubcentroCosto"]=0;
            }
            if ($sheet->getCell("J".$row)->getValue()==null) {
                $aArray["base"]=0;
            }
            
            $aArray["detalle"]=$sheet->getCell("M".$row)->getValue();
            $aArray["debito"]=$sheet->getCell("N".$row)->getValue();
            $aArray["credito"]=$sheet->getCell("O".$row)->getValue();





            // $aArray["valor"]="$".number_format($sheet->getCell("E".$row)->getCalculatedValue(),0,".",","); 

           

            $aDatos[]=$aArray;
       }

    } 


    unlink($archivo); 

}catch(Exception $e) {

    die('Error loading file "'.pathinfo($temp_dir,PATHINFO_BASENAME).'": '.$e->getMessage());
}

echo json_encode($aDatos); 

?>