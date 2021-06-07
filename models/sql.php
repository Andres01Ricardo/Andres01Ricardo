<?php
class Sql {
	public function __construct()	{	
		global $GLOBALS;
		include($GLOBALS . "config.php");
		$this->dbh = new PDO("mysql:host=".$db_host.";dbname=".$db_name,$db_user,$db_password);
		$this->dbh->exec("set names utf8");
	}

	public function begin(){				
		$this->dbh->beginTransaction();
	}

	public function autocommit(){				
		$this->dbh->commit();
	}

	public function rollback(){				
		$this->dbh->rollBack();
	}

	public function ejecutarSql($sql){	
	
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchAll();
	}
}