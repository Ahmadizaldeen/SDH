<?php
require_once __DIR__ . "/../config/base_url.php";
require_once __DIR__ . "/../config/chk_session.php";
require_once __DIR__ . "/../config/db/db_conn.php";
#require_once "iDatenbank.php";

class Person
{
	# Attribute
	private $id;//Auto_increment, zuordung über email getIDbyEmail
	private $vorname;//pflicht
	private $nachname;//pflicht
	private $email;//pflicht, UNIQUE
	private $phone;// optional, wird mit laender Table ergänzt
	private $gbd;// optional, kann später in Einstellungen ergänzt 
	private $password;//pflicht muss mit confirm_password übereinstimmen, 
	private $adresse_id; // fremdschlüssel , wird gestetzt wenn adresse in DB gespeicher wird
	private $user_name;//aus vorname, nachname, id generiert
	private $alias;//Name in der Community optional, default: vorname
	private $erstellt_am;// beim speichern in DB automatisch gesetzt
	private $eingelogt;// über Session gesteuert
	private $db; //PDO Objekt


	# Methoden
	public function __construct(PDO $db,array $daten = [])
	{
		foreach ($daten as $key => $value) {
			$this->$key = $value;
			
		}
		$this->db = $db;
		$this->insert(); //speiecht in DB wenn Objekt erstellt wird
	}

	# Setter / Getter
	function getIDbyEmail($email) // get aus DB. relevant für setUserName(), kein setter.
	{
		$sql = "SELECT id FROM users WHERE email = :email";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':email', $email, PDO::PARAM_STR);
		$stmt->execute();
		$this->id = $stmt->fetchColumn();
		return ($stmt->fetchColumn());
	}
	function setUserName()
	{
		$this->user_name = strtolower($this->vorname . "_" . $this->nachname."".$this->getIDbyEmail($this->email));
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
	function getEmail()// ermöglicht später anmeldung mit user_name
	{
		return $this->email;
	}
	function setEmail($param) // Einstellungsoption. UNIQUE muss beachtet werden.
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
	function setAlias($param) //DB Update Funktion
	{
		$this->alias = $param;
	}

	function getAlias() // Session variable , 
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


	# Zugriff auf db insert, select, delete, update, login_Methoden ->(selectAll, vergleichen, )
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
	public function getAttributes()
	{
		return get_object_vars($this);
	}

	function select(PDO $db, $id)
	{
	}
	function delete(PDO $db, $id)
	{
		$sql = "DELETE FROM personen WHERE id = $id";
		$db->exec($sql);
	}
	function update(PDO $db, $id)
	{
	}
	function selectAll(PDO $db)
	{
	}

}

/*
$person->setPhone("123-456-789");
$_SESSION['person_data']['phone'] = $person->getPhone();
#$person->insert();
$person->setUserName();
$_SESSION['person_data']['user_name'] = $person->getUserName();
**/
?>