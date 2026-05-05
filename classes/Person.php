<?php
require_once __DIR__ . "/../config/base_url.php";
#require_once __DIR__ . "/../config/db/db_conn.php";
require_once __DIR__ ."/abstract/aDatabank.php";

class Person extends aDatabank
{
	# Attribute
	private $id;//Auto_increment, zuordung über email getIDbyEmail
	private $vorname;//pflicht
	private $nachname;//pflicht
	private $email;//pflicht, UNIQUE
	private $phone;// optional, wird mit laender Table ergänzt
	private $gbd;// optional, kann später in Einstellungen ergänzt 
	private $password;//pflicht muss mit confirm_password übereinstimmen, 
	private $user_name;//aus vorname, nachname, id generiert
	private $alias = '';//Name in der Community optional, default: vorname
	private $erstellt_am;// beim speichern in DB automatisch gesetzt
	private $eingelogt;// über Session gesteuert
	private $db; //PDO Objekt


	# Methoden
	public function __construct(PDO $db,array $daten = [])
	{
		foreach ($daten as $key => $value) {
			$this->$key = $value;
			
		}
		$this->db = $this->db(); // Verbindung zu DB geerbt von aDatabank
		$this->insert(); //speiecht in DB wenn Objekt erstellt wird
	}

		function insert()
	{
		$sql = "INSERT INTO users(vorname, nachname, email,phone, password,alias) 
				VALUES 
				(
					'$this->vorname',
					'$this->nachname',
					'$this->email',
					'$this->phone',
					'$this->password',
					'$this->alias'			
					
				)";
		
		$this->db->exec($sql);
		
	
	
		$_SESSION['msg']['done'][] = "daten in DB gespeichert";
	}
	# Setter / Getter
	
	function setUserName()
	{
		$this->user_name = strtolower($this->vorname . "_" . $this->nachname."".$this->db->lastInsertID());
		$sql = "UPDATE users SET user_name = :user_name WHERE email = :email";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':user_name', $this->user_name, PDO::PARAM_STR);
		$stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
		$stmt->execute();
	}


	function getUserName()
	{
		return $this->user_name;
	}
	function getEmail()// 
	{
		return $this->email;
	}
	function setEmail($param) // 
	{
		$this->email = $param;
	}

	function getVorname()
	{
		return $this->vorname;
	}

	function setVorname($param)
	{
		$this->vorname = $param;
	}
	function setAlias($param) //
	{
		$this->alias = $param;
	}

	function getAlias() // 
	{
		return $this->alias;
	}
	function getPhone()
	{
		return $this->phone;
	}

	function setPhone($param)
	{
		$this->phone = $param;
	}
	function getAdresse($daten)
	{
		//aus DB
	}
	function setAdresse($daten)
	{
		//adresse Formular
	}

	public function getAttributes()
	{
		return get_object_vars($this);
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
	

}


?>