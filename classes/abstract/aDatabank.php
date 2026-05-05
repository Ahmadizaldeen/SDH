<?php
require_once "iDatabank.php";
abstract class aDatabank implements iDatenbank {
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
			$db = new PDO($dsn, $this->username, $this->password);

			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

			$this->db = $db;
			return $db;
		} 
		catch (PDOException $e) {
			die($e->getMessage());
		}
}
}