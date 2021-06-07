<?php

class Lista {
	
	private $dbh;
	protected $pk_value = 0, 
	$table = '',
	$restrict 	= array(),
	$order 		= array(),
	$group		= array();

	public function __construct()	{	
		global $GLOBALS;
		include($GLOBALS . "config.php");
		$this->dbh = new PDO("mysql:host=".$db_host.";dbname=".$db_name,$db_user,$db_password);		
		$this->dbh->exec("set names utf8");
		$args = func_get_args();
		$num_args = func_num_args();
		$this->error = 0;
		if ($num_args == 1) {
			$this->table = $args[0];
		}
		
	}

	public function getLista(){	
		if ($this->query==""){
			$this->query = "select * from $this->table";
		
			if (!empty($this->restrict)) {
				foreach ($this->restrict as $indice=>$valor) {
					if ($indice==0) {
						$this->query .= " WHERE ";
					}
					else{
					$this->query .= " ".$valor["opera"]." ";
		   	
					}
					$row = $valor["row"];
					$operator = $valor["operator"];
					$value = $valor["value"];
					if ($operator=="LIKE" || $operator=="NOT LIKE"){
						$this->query = $this->query." $row $operator '%$value%'";
					}
					else if ($operator=="IN"){
						$this->query = $this->query." $row $operator ($value)";
					}
					else if ($operator=="NOT IN"){
						$this->query = $this->query." $row $operator ($value)";
					}
					else {
						$this->query = $this->query." $row $operator '$value'";
					}
				}
			}
			if (!empty($this->group)) {
				foreach ($this->group as $indice=>$valor) {
					if ($indice==0) {
						$this->query .= " GROUP BY ";
					}
					$row = $valor["row"];
					$this->query.="$row";	
					if ($indice<count($this->group)-1){
						$this->query .= " , ";
					}
				}
			}
			if (!empty($this->order)) {
				foreach ($this->order as $indice=>$valor) {
					if ($indice==0) {
						$this->query .= " ORDER BY ";
					}
					$row = $valor["row"];
					$type = $valor["type"];
					$this->query.="$row $type";	
					if ($indice<count($this->order)-1){
						$this->query .= " , ";
					}
				}
			}
							
		}	
		$sth = $this->dbh->prepare($this->query);
		$sth->execute();
		return $sth->fetchAll();
		//$this->ejecutarSentencia($this->query);
	}

	public function setFiltro($columna, $operador, $value, $conector="AND"){
		$restrict = Array();
		$restrict["row"] = $columna;
		$restrict["operator"] = $operador;
		$restrict["value"] = $value;
		$restrict["opera"] = $conector;
		$this->restrict[] = $restrict;				
		
	}

	public function setOrden($row,$type) {
		$order = Array();
		$order["row"] = $row;
		$order["type"] = $type;
		$this->order[] = $order;
	}
	public function setGrupo($row) {
		$group = Array();
		$group["row"] = $row;
		$this->group[] = $group;
	}

	public function ejecutarSql($sql){	
	
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchAll();
	}

}
?>