<?php
namespace Classes;
use Classes\Abstract\aDatabank;
use Session\SessionController;
require_once __DIR__ . "/../config/bootstrap.php";


class Fachbereiche extends aDatabank
{
	# Attribute
	private $id;//
	private $name;//
	private $description;//
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

	public function getProperty(string $property) // getter für alle Eigenschaften. 
	{
		if (!property_exists($this, $property)) {
			return "Property $property existiert nicht.";
		}

		return $this->$property;
	}

	function insert()
	{
		$sql = "INSERT INTO fachbereiche (name, description)
            VALUES (:name, :description)";

		$stmt = $this->db->prepare($sql);

		$stmt->execute([
			':name' => $this->name,
			':description' => $this->description
		]);

		$_SESSION['msg']['done'][] = "Fachbereich gespeichert";
	}
	function set_daten($daten)
	{
		foreach ($daten as $key => $value) {
			$setter = "set" . ucfirst($key);
			if (method_exists($this, $setter))
				$this->$setter($value);
		}
	}

	function select($id)
	{
		$sql = "SELECT * FROM fachbereiche WHERE id = :id";
		$stmt = $this->db->prepare($sql);
		$stmt->execute([':id' => $id]);

		$result = $stmt->fetch(\PDO::FETCH_ASSOC);

		if (!$result) {
			$_SESSION['msg']['error'][] = "Fachbereich nicht gefunden";
			return null;
		}

		$this->set_daten($result);
		return $result;
	}
	function delete($id)
	{
		$sql = "DELETE FROM fachbereiche WHERE id = :id";
		$stmt = $this->db->prepare($sql);
		$stmt->execute([':id' => $id]);

		$_SESSION['msg']['done'][] = "Fachbereich gelöscht";
	}
	function update($id)
	{
		$sql = "UPDATE fachbereiche
            SET name = :name,
                description = :description
            WHERE id = :id";

		$stmt = $this->db->prepare($sql);

		$stmt->execute([
			':name' => $this->name,
			':description' => $this->description,
			':id' => $id
		]);

		$_SESSION['msg']['done'][] = "Fachbereich aktualisiert";
	}
	function selectAll()
	{
		$sql = "SELECT * FROM fachbereiche";
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

	function getDescription()
	{
		#return $this->vorname;
	}

	function setDescription($param)
	{
		#$this->vorname = $param;
	}


}



?>