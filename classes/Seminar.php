<?php
namespace Classes;
use Classes\Abstract\aDatabank;
use Session\SessionController;
require_once __DIR__ . "/../config/bootstrap.php";


class Seminar extends aDatabank
{
	# Attribute
	private $id;//
	private $title;//
	private $raum_id;//
	private $status_id;// 
	private $lfacbereich_id;// 
	private $beschreibung;//

	private $min_teilnehmer;//
	private $max_teilnehmer;//
	private $bild;//
	private $preis;//
	private $start_datum;//
	private $end_datum;//
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
		$sql = "INSERT INTO seminare 
            (title, raum_id, status_id, lfacbereich_id, beschreibung, min_teilnehmer, max_teilnehmer, bild, preis, start_datum, end_datum)
            VALUES 
            (:title, :raum_id, :status_id, :lfacbereich_id, :beschreibung, :min_teilnehmer, :max_teilnehmer, :bild, :preis, :start_datum, :end_datum)";

		$stmt = $this->db->prepare($sql);

		$stmt->execute([
			':title' => $this->title,
			':raum_id' => $this->raum_id,
			':status_id' => $this->status_id,
			':lfacbereich_id' => $this->lfacbereich_id,
			':beschreibung' => $this->beschreibung,
			':min_teilnehmer' => $this->min_teilnehmer,
			':max_teilnehmer' => $this->max_teilnehmer,
			':bild' => $this->bild,
			':preis' => $this->preis,
			':start_datum' => $this->start_datum,
			':end_datum' => $this->end_datum
		]);

		$_SESSION['msg']['done'][] = "Seminar gespeichert";
	}

	function select($id)
	{
		$sql = "SELECT * FROM seminare WHERE id = :id";
		$stmt = $this->db->prepare($sql);
		$stmt->execute([':id' => $id]);

		$result = $stmt->fetch(\PDO::FETCH_ASSOC);

		if (!$result) {
			$_SESSION['msg']['error'][] = "Seminar nicht gefunden";
			return null;
		}

		$this->set_daten($result);
		return $result;
	}
	function delete($id)
	{
		$sql = "DELETE FROM seminare WHERE id = :id";
		$stmt = $this->db->prepare($sql);
		$stmt->execute([':id' => $id]);

		$_SESSION['msg']['done'][] = "Seminar gelöscht";
	}
	function update($id)
	{
		$sql = "UPDATE seminare SET
                title = :title,
                raum_id = :raum_id,
                status_id = :status_id,
                lfacbereich_id = :lfacbereich_id,
                beschreibung = :beschreibung,
                min_teilnehmer = :min_teilnehmer,
                max_teilnehmer = :max_teilnehmer,
                bild = :bild,
                preis = :preis,
                start_datum = :start_datum,
                end_datum = :end_datum
            WHERE id = :id";

		$stmt = $this->db->prepare($sql);

		$stmt->execute([
			':title' => $this->title,
			':raum_id' => $this->raum_id,
			':status_id' => $this->status_id,
			':lfacbereich_id' => $this->lfacbereich_id,
			':beschreibung' => $this->beschreibung,
			':min_teilnehmer' => $this->min_teilnehmer,
			':max_teilnehmer' => $this->max_teilnehmer,
			':bild' => $this->bild,
			':preis' => $this->preis,
			':start_datum' => $this->start_datum,
			':end_datum' => $this->end_datum,
			':id' => $id
		]);

		$_SESSION['msg']['done'][] = "Seminar aktualisiert";
	}
	function selectAll()
	{
		$sql = "SELECT * FROM seminare ORDER BY start_datum ASC";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	# Setter / Getter
	function getStrasse()
	{
		#return $this->strasse;
	}
	function setStrasse($param)
	{

	}
	function getHausNr()// 
	{
		#return $this->email;
	}
	function setHausNr($param) // 
	{
		#$this->email = $param;
	}

	function getPlz()
	{
		#return $this->vorname;
	}

	function setPlz($param)
	{
		#$this->vorname = $param;
	}
	function setStadt($param) //
	{
		#$this->alias = $param;
	}

	function getStadt() // 
	{
		#return $this->alias;
	}
	function getUserByID()
	{
		#return $this->phone;
	}

	function getLandByID($param)
	{
		#$this->phone = $param;
	}









}



?>