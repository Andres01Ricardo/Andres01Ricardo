<?php

require_once($CLASS."sql.php"); 



class ProductoServicio extends Sql{

	

	public function getProductosServicios($aDatos=array()){


		if(!isset($_SESSION)){ session_start(); }
		$condicion=""; 

		if($aDatos["idEmpresa"]!=""){

			$condicion.=" AND p.idEmpresa=".$aDatos["idEmpresa"]; 

		}

		if(!empty($_SESSION["idEmpresa"])){

			$condicion.=" AND p.idEmpresa=".$_SESSION["idEmpresa"]; 

		}

		if($aDatos["tipo"]!=""){
			if($aDatos["tipo"]!=3){

			$condicion.=" AND p.tipo=".$aDatos["tipo"]; 

			}
		}



		$sql="SELECT p.idProductoServicio, p.nombre, p.codigo, e.razonSocial

		    FROM producto_servicio as p 


		    INNER JOIN empresa as e ON(e.idEmpresa=p.idEmpresa)

		    WHERE 0=0 ".$condicion." ORDER BY p.codigo ASC";

	    $aProductos=$this->ejecutarSql($sql); 



	    return $aProductos; 

	}



}

?>