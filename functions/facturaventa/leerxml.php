<?php 

header('Content-type: application/json');

require_once("../../php/restrict.php");

require_once('../../libraries/PHPExcel/Classes/PHPExcel.php');



if( isset($_FILES['xml']) && $_FILES['xml'] != 'undefined')

    {

               

        $sNombre = $_FILES['xml']['name'];                

        $sExtension = substr(strrchr($sNombre, '.'), 1);

        $sTemporal = $_FILES['xml']['tmp_name'];

        

        $nombreEncript = uniqid(); 

        

        $nombre_archivo = "{$nombreEncript}.{$sExtension}"; 

        

        $directorioTmp = 'FACTURAELECTRONICA/';

        $ubicacionTmp = "{$directorioTmp}{$nombre_archivo}";  



        if(move_uploaded_file($sTemporal, "../../".$directorioTmp.$nombre_archivo))

        {	

            $sFinanciero = 'FACTURAELECTRONICA/'.$nombre_archivo;

        }else{

        	echo "vacio"; 

        }

    

} 

$archivo = "https://smartbuss.co/".$sFinanciero;

try {

     

}catch(Exception $e) {

    die('Error loading file "'.pathinfo($temp_dir,PATHINFO_BASENAME).'": '.$e->getMessage());

}


echo json_encode(array("archivo"=>$archivo)); 



?>