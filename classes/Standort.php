<?php
namespace Classes;
use Classes\Abstract\aDatabank;
use Session\SessionController;
require_once __DIR__ . "/../config/bootstrap.php";


class Standort extends aDatabank
{
	# Attribute
	private $id;//
	private $name;//
	private $adresse_id;//

	private $db; //


	# Methoden
	public function __construct(\PDO $db, array $daten = [])
	{
		foreach ($daten as $key => $value) {
			$this->$key = $value;

		}
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
		$sql = "INSERT INTO standorte (name, adresse_id)
            VALUES (:name, :adresse_id)";

		$stmt = $this->db->prepare($sql);

		$stmt->execute([
			':name' => $this->name,
			':adresse_id' => $this->adresse_id
		]);

		$_SESSION['msg']['done'][] = "Standort gespeichert";
	}

	function select($id)
	{
		$sql = "SELECT * FROM standorte WHERE id = :id";
		$stmt = $this->db->prepare($sql);
		$stmt->execute([':id' => $id]);

		$result = $stmt->fetch(\PDO::FETCH_ASSOC);

		if (!$result) {
			$_SESSION['msg']['error'][] = "Standort nicht gefunden";
			return null;
		}

		$this->set_daten($result);
		return $result;
	}
	function delete($id)
	{
		$sql = "DELETE FROM standorte WHERE id = :id";
		$stmt = $this->db->prepare($sql);
		$stmt->execute([':id' => $id]);

		$_SESSION['msg']['done'][] = "Standort gelöscht";
	}
	function update($id)
	{
		$sql = "UPDATE standorte
            SET name = :name,
                adresse_id = :adresse_id
            WHERE id = :id";

		$stmt = $this->db->prepare($sql);

		$stmt->execute([
			':name' => $this->name,
			':adresse_id' => $this->adresse_id,
			':id' => $id
		]);

		$_SESSION['msg']['done'][] = "Standort aktualisiert";
	}
	function selectAll()
	{
		$sql = "SELECT * FROM standorte";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	# Setter / Getter
	function getID()
	{
		return $this->id;
	}

	function setID($param)
	{
		$this->id = (int) $param;
	}

	function getName()
	{
		return $this->name;
	}

	function setName($param)
	{
		$this->name = trim($param);
	}

	function getAdresseId()
	{
		return $this->adresse_id;
	}

	function setAdresseId($param)
	{
		$this->adresse_id = (int) $param;
	}



}



?>