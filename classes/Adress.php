<?php
namespace Classes;
use Classes\Abstract\aDatabank;
use Classes\SessionController;
#require_once __DIR__ . "/../Session/SessionController.php";
require_once __DIR__ . "/../config/bootstrap.php";

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
		#dd($daten);
		$this->set_daten($daten);
		$this->db = $this->db(); // Verbindung zu DB geerbt von aDatabank

	}
	function set_daten($daten) //key muss gleich wie attribute_name sein, value kommt per $_POST 
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
			SessionController::addMessage("error", "Property $property existiert nicht.");
			return "Property $property existiert nicht.";
		}

		return $this->$property;
	}

	public function insert()
	{
		$sql = "INSERT INTO adresse (strasse, haus_nr, plz, stadt, user_id)
        VALUES (:strasse, :haus_nr, :plz, :stadt, :user_id)";

		$stmt = $this->db->prepare($sql);
		#dd($sql);
		$stmt->execute([
			':strasse' => $this->strasse,
			':haus_nr' => $this->haus_nr,
			':plz' => $this->plz,
			':stadt' => $this->stadt,
			':user_id' => $this->user_id
		]);

		SessionController::addMessage("done", "Adresse daten in DB gespeichert");
	}

		public function getUserAdress(int $user_id): ?array
{
    $stmt = $this->db->prepare("SELECT * FROM adresse WHERE user_id = :id");
    $stmt->execute(['id' => $user_id]);

    $result = $stmt->fetch();
    return $result ?: null;
}
	public function getByUserId(int $user_id): ?array
{
    $stmt = $this->db->prepare("SELECT * FROM adresse WHERE user_id = :id");
    $stmt->execute(['id' => $user_id]);

    $result = $stmt->fetch();
    return $result ?: null;
}

	function select($id)
	{
		$sql = "SELECT * FROM adresse WHERE id = :id";
		$stmt = $this->db->prepare($sql);
		$stmt->execute([':id' => $id]);

		$result = $stmt->fetch(\PDO::FETCH_ASSOC);

		if (!$result) {
			SessionController::addMessage("error", "Adresse nicht gefunden");
			return null;
		}

		$this->set_daten($result);
		return $result;
	}
	function delete($id)
	{
		$sql = "DELETE FROM adresse WHERE id = :id";
		$stmt = $this->db->prepare($sql);
		$stmt->execute([':id' => $id]);

	}
	function update($id)
	{
		$sql = "UPDATE adresse 
            SET strasse = :strasse,
                haus_nr = :haus_nr,
                plz = :plz,
                stadt = :stadt,
                user_id = :user_id
            WHERE id = :id";

		$stmt = $this->db->prepare($sql);

		$stmt->execute([
			':strasse' => $this->strasse,
			':haus_nr' => $this->haus_nr,
			':plz' => $this->plz,
			':stadt' => $this->stadt,
			':user_id' => $this->user_id,
			':id' => $id
		]);

		SessionController::addMessage("done", "Adresse aktualisiert");
	}
	function selectAll()
	{
		$sql = "SELECT * FROM adresse";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		$results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

		return $results ?: [];
	}

	public function getAdresseByUserID( int $user_id)
	{ // wird zum prüfen des Adresse bei login
		$stmt = $this->db->prepare("SELECT * FROM adresse WHERE user_id = :id");
		$stmt->execute(['id' => $user_id]);
		$adresse = $stmt->fetch();
		return $adresse;
	}

	# Setter / Getter

	function setStrasse($param)
	{
		$this->strasse = $param;
	}

	function setHaus_nr($param) // 
	{
		$this->haus_nr = $param;
	}

	function setPlz($param)
	{
		
		$this->plz = $param;
	}
	function setStadt($param) //
	{
		$this->stadt = $param;
	}
	function SetUser_id($user_id)
	{
		$this->user_id = $user_id;
	}

}
?>