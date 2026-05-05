<?php
require_once __DIR__ . "/../config/base_url.php";
require_once __DIR__ . "/abstract/aDatabank.php";

class Adress extends aDatabank
{
	# Attribute
	private $id;//Auto_increment
	private $strasse;
	private $haus_nr;
	private $plz;
	private $stadt;
	private $user_id;
	private $db;


	# Methoden
	public function __construct(array $daten = [])
	{
		foreach ($daten as $key => $value) {
			$this->$key = $value;
			
		}
		$this->db = $this->db(); // Verbindung zu DB geerbt von aDatabank
	
	}

	public function insert()
	{
		$sql = "INSERT INTO adresse (strasse, haus_nr, plz,stadt, user_id) 
				VALUES 
				(
					'$this->strasse',
					'$this->haus_nr',
					'$this->plz',
					'$this->stadt',
					'$this->user_id'
					
				)";
	
		$this->db->exec($sql);

		$_SESSION['msg']['done'][] = "Adresse daten in DB gespeichert";
	}

	public static function getAdresseByUserID($db,$user_id){ // wird zum prüfen des Adresse bei login
		$stmt = $db->prepare("SELECT * FROM adresse WHERE user_id = :id");
		$stmt->execute(['id' => $user_id]);
		$adresse = $stmt->fetch();
        return $adresse;
	}

	

	function select( $id)
	{
	}
	function delete( $id)
	{
		$sql = "DELETE FROM personen WHERE id = $id";
		
	}
	function update( $id)
	{
	}
	function selectAll()
	{
	}
	
	# Setter / Getter
	function getStrasse()
	{
		
	}
	function setStrasse($param){

	}
	function getHausNr()// 
	{
	}
	function setHausNr($param) // 
	{
	}

	function getPlz()
	{
	}

	function setPlz($param)
	{
	}
	function setStadt($param) //
	{
	}

	function getStadt() // 
	{
	}
	function getUserByID()
	{
	}

	function getLandByID($param)
	{
	}


	
	


	
	public function getAttributes()
	{
		return get_object_vars($this);
	}



}


?>