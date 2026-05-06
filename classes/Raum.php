<?php
namespace Classes;
use Classes\Abstract\aDatabank;
use Session\SessionController;
require_once __DIR__ . "/../config/bootstrap.php";


class Raum extends aDatabank
{
	# Attribute
	private $id;//
	private $name;//
	private $standort_id;//

	private $db; //


	# Methoden
	public function __construct(\PDO $db, array $daten = [])
	{
		$this->set_daten($daten);
		$this->db = $this->db(); // Verbindung zu DB geerbt von aDatabank


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

	function insert()
	{
		$sql = "INSERT INTO raum (name, standort_id)
            VALUES (:name, :standort_id)";

		$stmt = $this->db->prepare($sql);

		$stmt->execute([
			':name' => $this->name,
			':standort_id' => $this->standort_id,
		]);

		$_SESSION['msg']['done'][] = "Raum gespeichert";
	}

	function select($id)
	{
		$sql = "SELECT * FROM raum WHERE id = :id";
		$stmt = $this->db->prepare($sql);
		$stmt->execute([':id' => $id]);

		$result = $stmt->fetch(\PDO::FETCH_ASSOC);

		if (!$result) {
			$_SESSION['msg']['error'][] = "Raum nicht gefunden";
			return null;
		}

		$this->set_daten($result);
		return $result;
	}
	function delete($id)
	{
		$sql = "DELETE FROM raum WHERE id = :id";
		$stmt = $this->db->prepare($sql);
		$stmt->execute([':id' => $id]);

		$_SESSION['msg']['done'][] = "Raum gelöscht";
	}
	function update($id)
	{
		$sql = "UPDATE raum
            SET name = :name,
                standort_id = :standort_id
            WHERE id = :id";

		$stmt = $this->db->prepare($sql);

		$stmt->execute([
			':name' => $this->name,
			':standort_id' => $this->standort_id,
			':id' => $id
		]);

		$_SESSION['msg']['done'][] = "Raum aktualisiert";
	}
	function selectAll()
	{
		$sql = "SELECT * FROM raum";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	# Setter / Getter
	function getID()
	{
		#return $this->strasse;
	}
	function setID($param)
	{

	}
	function getName()// 
	{
		#return $this->email;
	}
	function setName($param) // 
	{
		#$this->email = $param;
	}

	function getAdress()
	{
		#return $this->vorname;
	}

	function setAdress($param)
	{
		#$this->vorname = $param;
	}



}



?>