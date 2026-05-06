<?php
namespace Classes\Abstract;
use Classes\Abstract\iDatabank;
abstract class aDatabank implements iDatabank {
	private $servername = "localhost";
	private $username = "root";
	private $password = "";
	private $dbname = "sdh";
	private $db = null;
    function insert(){}
	function select( $id){}
	function delete( $id){}
	function update( $id){}
	function selectAll( ){}
	
	function db(){
		try {
			$dsn = "mysql:host=$this->servername;dbname=$this->dbname;charset=utf8mb4";
			$db = new \PDO($dsn, $this->username, $this->password);
			# \ vor PDO damit es die global klasse ist ! nicht die von namespace
			$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

			$this->db = $db;
			return $db;
		} 
		catch (\PDOException $e) {
			die($e->getMessage());
		}
}
}