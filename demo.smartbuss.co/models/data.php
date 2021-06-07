<?php

class Data {
	
	private $dbh;
	protected $pk_value = 0,
	$pk = '',
	$table = '',
	$attribs	= array(),
	$fields		= array(), 
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
		
		if ($num_args == 2) {
			$this->table = $args[0];
			$this->pk = $args[1];
			$this->pk_value=0;	/*	added by mate	*/
		}
		
		if ($num_args == 3) {
			$this->table = $args[0];
			$this->pk = $args[1];
			$this->pk_value = $args[2];

		}
		if ( $num_args >= 1 ) {
			$this->validateColumn(); 
		}
			
	}

	public function __set($key,$value)	{
		
		if ( array_key_exists($key,$this->fields) ) {	/*	added by mate	*/
			$this->attribs[$key] = $value;
		}
	}	

	public function validateColumn(){
		$sqlSelect="SHOW COLUMNS FROM $this->table";
		$sth=$this->dbh->prepare($sqlSelect); 
		$sth->execute();
		$result=$sth->fetchAll();
		
		if (!$result){
			$this->error = 2;
		} else {
			foreach ($result as $key=>$value) {
				$this->fields[$value["Field"]] = "";
			}
		}
	}

	public function ejecutarSentencia($sql){				
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchAll();
	}

	public function getDatos(){	
		$sql="SELECT * FROM ".$this->table." where ".$this->pk."=".$this->pk_value; 
		
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		$result=$sth->fetchAll();
		return $result[0];
	}

	public function guardar(){
		if ($this->pk_value == 0) {
			$this->setDatos();
		} else {
			$this->updateDatos();
		}
	}
	public function setDatos(){		
		try{
			$actual = 0;
			$keys="";
			$values="";
			$total=count($this->attribs);

			foreach ($this->attribs as $key=>$value)
			{
			   $keys.="$key";
			   $values.="'".str_replace("'", "\'", $value)."'";
			   $actual++;
			   if ($actual<$total){
			   		$keys.=",";
					$values.=",";
			   }
			}
			$sql="INSERT INTO $this->table ($keys) VALUES ($values)";
			
			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
			$this->dbh->exec($sql);		
			$this->pk_value=$this->dbh->lastInsertId();
			return true; 
		}catch(PDOException $e){
	    	echo $e->getMessage();
	    }
	}
	
	public function updateDatos(){		
		try{
			$actual=0;
			$action="UPDATE $this->table set";
			$condition=" where ".$this->pk."=".$this->pk_value;
			$allocation="";
			$total=count($this->attribs);
			foreach ($this->attribs as $key=>$value)
			{
			   $allocation.=" $key = '".$value."'";
			   $actual++;
			   if ($actual<$total){
			   		$allocation.=",";
			   }
			}


			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql=$action.$allocation.$condition;
			$this->dbh->exec($sql);		
			$this->$pk_value=$this->dbh->lastInsertId();
			return true; 
		}catch(PDOException $e){
	    	echo $e->getMessage();
	    }
	}

	public function eliminar(){				
		$sql="DELETE FROM $this->table WHERE $this->pk=$this->pk_value";
		$sth = $this->dbh->prepare($sql);
		return $sth->execute();
	}
	
	
	public function ultimoId() {
		return($this->pk_value);
	}
}
?>