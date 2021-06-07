<?php

require_once($CLASS."sql.php"); 



class Funciones extends Sql{

	

	public function getMenu(){



		$condicion=""; 

		if(!isset($_SESSION)){ session_start(); }

				

		$sql="SELECT mo.idModulo, mo.nombre as modulo, mo.icono, m.nombre as menu, m.url, ms.idMenuSoftware,ms.nombre as moduloPrincipal, ms.icono as iconoPrincipal

			FROM menu_rol as mr

			INNER JOIN menu as m ON(m.idMenu=mr.idMenu)

			INNER JOIN modulo as mo ON(mo.idModulo=m.idModulo)

			INNER JOIN menu_software as ms on(ms.idMenuSoftware = mo.idMenuSoftware)

			WHERE 0=0 AND mo.estado=1 AND m.estado=1 AND mr.idRol=".$_SESSION["idRol"]." ORDER BY mo.orden, m.orden ";

		

	    $aMenus=$this->ejecutarSql($sql); 

	    return $aMenus; 

	}

}

?>