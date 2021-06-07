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

// $xml=simplexml_load_file($archivo);

// print_r($xml);

// $xml2=simplexml_load_string($archivo);
// var_dump($xml2);



// $namespaces = $xml->getNamespaces(true);
// var_dump($namespaces);
// var_dump($namespaces["cac"]);


// foreach ($namespaces as $value) {
//     print_r($value);
//     # code...
// }






// $matrizDeObras = array();
 
//     /* Creamos un objeto de la clase SimpleXMLElement para 
//     almacenar en el el contenido del archivo XML en una 
//     estructura de objeto procesable. */
//     $contenidoXML = new SimpleXMLElement($archivo, 0, true);
 
//     /* Determinamos los espacios de nombres empleados. */
//     $espaciosDeNombres = $contenidoXML->getNamespaces(true);
    
//     $nodos_NS_Obra = $contenidoXML->children($espaciosDeNombres['cac']);
 
//     /* con el nombre de los nodos creamos unas variables 
//     (una por nodo) que podemos reorrer para trabajar sobre ellas. */
//     foreach ($nodos_NS_Obra as $obra) {
//         $elementoObra = array(); // Elemento que contendrá datos de cada nodo.
//         $elementoObra["ExternalReference"] = trim((string)$obra); // Se agrega el contenido del nodo como cadena.
 
//         /* Obtenemos los atributos del nodo con el método attributes().*/
//         $atributosDeNodoObra = $obra->attributes();
//         /* Recorremos todos los atributos asignándolos a la matriz
//         del nodo actual. */
//         $elementoObra["fecha_de_inicio"] = (string)$atributosDeNodoObra->inicio;
//         $elementoObra["fecha_de_finalizacion"] = (string)$atributosDeNodoObra->final;
//         $elementoObra["contratista"] = (string)$atributosDeNodoObra->contratista;
//         $elementoObra["presupuesto"] = (string)$atributosDeNodoObra->presupuesto;
 
//         /* Recuperamos los nodos que están dentro del 
//         NS 'ns_personal_origen_1', dentro de cada nodo 'obra' */
//         $nodos_NS_personal = $obra->children($espaciosDeNombres['ns_personal_origen_1']);
//         /*Obtenemos el atributo 'miembros' del nodo primario del 
//         NS 'ns_personal_origen_1', lo que nos da el número de miembros. */
//         $elementoObra["miembros_tecnicos"] = (string)$nodos_NS_personal->attributes()->miembros;
 
//         /* Creamos una submatriz auxiliar para guardar los cargos y nombres
//         de los miembros técnicos. 
//         Debemos tener en cuenta que el nodo 'personal_tecnico' y los 
//         sub-nodos 'miembro' comparten el mismo espacio de nombres, por 
//         lo que debemos referirnos al primer elemmento de dicho NS 
//         (el que tiene el índice [0]) y, a partir de ahí, 
//         recorrer cada uno de los miembros que encontremos dentro.*/
//         $elementoObra["personal_tecnico"] = array();
//         foreach ($nodos_NS_personal[0] as $directivo){
//             $elementoObra["personal_tecnico"][(string)$directivo->attributes()["cargo"]] = trim((string)$directivo);
//         }
 
//         $matrizDeObras[] = $elementoObra; // El elemento de cada nod es agregado a la matriz general.
//         unset($elementoObra); // El contenido de un elemento nodo se recreará en cada iteración.
//     }
//     var_dump ($matrizDeObras);







// var_dump((string) $xml->Attachment->ExternalReference->Description);

// echo $xml->getName() . "<br>";

// foreach($xml->children() as $child)
//   {
//   print_r( $child->getName() . ": " . $child);
//   }


// echo $xml->'cbc:Description';
// print_r($xml);
// foreach ($xml->nodos->item as $elemento) 
//     {
//     print_r("El título es" .$elemento->title. "<br>");
//     print_r("El link es" .$elemento->description. "<br>");
//     print_r("El description es" .$elemento->description. "<br>");
    
//     //saco los namespaces
//     $namespaces = $elemento->getNameSpaces(true);
//     $media = $elemento->children($namespaces['media']);
//     print_r("El thumbnail es:" .$media->thumbnail."<br>");
//     }

echo json_encode(array("archivo"=>$archivo)); 



?>