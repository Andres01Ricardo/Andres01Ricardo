<?php 

header('Content-type: application/json');

require_once("../../php/restrict.php");

require_once('../../libraries/PHPExcel/Classes/PHPExcel.php');



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



$aArray=array("ACTIVO","PASIVO","PATRIMONIO"); 

$archivo = "../../".$sBalance;



try {

    $inputFileType = PHPExcel_IOFactory::identify($archivo);

    $objReader = PHPExcel_IOFactory::createReader($inputFileType);

    $objPHPExcel = $objReader->load($archivo);

    $sheet = $objPHPExcel->getSheet(0); 

    $highestRow = $sheet->getHighestRow(); 

    $highestColumn = $sheet->getHighestColumn();



    $cabecera["titulo"]=$sheet->getCell("A1")->getValue();

    $cabecera["fecha"]=$sheet->getCell("A2")->getValue();

    for ($row = 4; $row <= $highestRow; $row++){

        $aItem=array(); 

        if($sheet->getCell("A".$row)->getValue()!=null){

            $titulo=trim($sheet->getCell("B".$row)->getValue()); 

            $aItem["titulo"]=$titulo; 

            $cuenta=trim($sheet->getCell("A".$row)->getValue());

            $aItem["cuenta"]=$cuenta; 

            if(strlen($cuenta)>2){

                $aItem["tipo"]=5;

                $aItem["total"]="$".number_format($sheet->getCell("D".$row)->getCalculatedValue(),0,".",",");

            }else{

                $aItem["tipo"]=4;

                $aItem["total"]="$".number_format($sheet->getCell("F".$row)->getCalculatedValue(),0,".",",");

                $aItem["porcentaje"]=$sheet->getCell("H".$row)->getCalculatedValue();

            }

        $aDatos[]=$aItem; 

       }else{

            if($sheet->getCell("B".$row)->getValue()!=null){

                $titulo=trim($sheet->getCell("B".$row)->getValue()); 

                $aItem["titulo"]=$titulo; 

                if(in_array($titulo, $aArray)){

                    $aItem["tipo"]=1; 

                }else{

                    if($sheet->getCell("F".$row)->getCalculatedValue()==null){

                        $aItem["tipo"]=2; 

                    }else{

                        $aItem["tipo"]=3; 

                        $aItem["total"]="$".number_format($sheet->getCell("F".$row)->getCalculatedValue(),0,".",","); 

                        $aItem["porcentaje"]=$sheet->getCell("H".$row)->getValue(); 

                    }

                }

            $aDatos[]=$aItem;     

           }

           

       }

    } 



    unlink($archivo); 

}catch(Exception $e) {

    die('Error loading file "'.pathinfo($temp_dir,PATHINFO_BASENAME).'": '.$e->getMessage());

}



echo json_encode(array("info"=>$aDatos,"cabecera"=>$cabecera)); 



?>