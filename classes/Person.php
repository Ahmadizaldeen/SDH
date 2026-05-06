<?php
namespace Classes;
use Classes\Abstract\aDatabank;
use Session\SessionController;
require_once __DIR__ . "/../config/bootstrap.php";


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
	public function __construct(array $daten = [])
	{
		$this->set_daten($daten);
		$this->db = $this->db(); // Verbindung zu DB geerbt von aDatabank

	}

	function insert()
	{
		$sql = "INSERT INTO users (vorname, nachname, email, phone, password, alias)
        VALUES (:vorname, :nachname, :email, :phone, :password, :alias)";

		$stmt = $this->db->prepare($sql);
#dd($this->password);
#':password' => password_hash($this->password, PASSWORD_DEFAULT),
		$stmt->execute([
			':vorname' => $this->vorname,
			':nachname' => $this->nachname,
			':email' => $this->email,
			':phone' => $this->phone,
			':password' => ($this->password),
			':alias' => $this->alias
		]);



		$_SESSION['msg']['done'][] = "daten in DB gespeichert";
	}
	# Setter / Getter

	function setUserName()
	{
		$this->user_name = strtolower($this->vorname . "_" . $this->nachname . "" . $this->db->lastInsertID());
		$sql = "UPDATE users SET user_name = :user_name WHERE email = :email";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':user_name', $this->user_name, \PDO::PARAM_STR);
		$stmt->bindValue(':email', $this->email, \PDO::PARAM_STR);
		$stmt->execute();
	}
	function set_daten($daten)
	{
		foreach ($daten as $key => $value) {
			$setter = "set" . ucfirst($key);
			if (method_exists($this, $setter))
				$this->$setter($value);
		}
	}

	public function getProperty(string $property) // getter für alle Eigenschaften. 
	{
		if (!property_exists($this, $property)) {
			return "Property $property existiert nicht.";
		}

		return $this->$property;
	}




	function select($id)
	{
		$sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':id', $id, \PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch(\PDO::FETCH_ASSOC);

		if ($result) {
			$this->set_daten($result);
			return $result;
		}

		return null;
	}

	function delete($id)
	{
		$sql = "DELETE FROM users WHERE id = :id";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':id', $id, \PDO::PARAM_INT);

		return $stmt->execute();
	}
	function update($id)
	{
		$sql = "UPDATE users 
            SET vorname = :vorname,
                nachname = :nachname,
                email = :email,
                phone = :phone,
                alias = :alias
            WHERE id = :id";

		$stmt = $this->db->prepare($sql);

		return $stmt->execute([
			':vorname' => $this->vorname,
			':nachname' => $this->nachname,
			':email' => $this->email,
			':phone' => $this->phone,
			':alias' => $this->alias,
			':id' => $id
		]);
	}
	function selectAll()
	{
		$sql = "SELECT * FROM users";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}


	function setEmail($param) // 
	{
		$this->email = $param;
	}



	function setVorname($param)
	{
		$this->vorname = $param;
	}
	function setNachname($param)
	{
		$this->nachname = $param;
	}
	function setAlias($param) //
	{
		$this->alias = $param;
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
	public function setPassword($param){
		$this->password =$param;
	}
}

?>