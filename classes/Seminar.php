<?php
namespace Classes;
use Classes\Abstract\aDatabank;

require_once __DIR__ . "/../config/bootstrap.php";


class Seminar extends aDatabank
{
	use Traits\SessionController;
	# Attribute
	private $id;//
	private $title;//
	private $facbereich_id;// 
	private $beschreibung;//
	private $min_teilnehmer;//
	private $max_teilnehmer;//
	private $raum_id;//
	private $bild;//
	private $preis;//
	private $status;// 
	private $db; //


	# Methoden
	public function __construct( array $daten = [])
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
            (title, status, fachbereich_id, beschreibung, preis)
            VALUES 
            (:title, :status, :facbereich_id, :beschreibung, :preis)";

		$stmt = $this->db->prepare($sql);

		$stmt->execute([
			':title' => $this->title,
			':status' => $this->status,
			':facbereich_id' => $this->facbereich_id,
			':beschreibung' => $this->beschreibung,
			':preis' => $this->preis
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
                status = :status,
                fachbereich_id = :facbereich_id,
                beschreibung = :beschreibung,
                preis = :preis
            WHERE id = :id";

		$stmt = $this->db->prepare($sql);

		$stmt->execute([
			':title' => $this->title,
			':status' => $this->status,
			':facbereich_id' => $this->facbereich_id,
			':beschreibung' => $this->beschreibung,
			':preis' => $this->preis,
			':id' => $id
		]);

		$_SESSION['msg']['done'][] = "Seminar aktualisiert";
	}
	function selectAll()
	{
		$sql = "SELECT * FROM seminare";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function getAllWithFachbereich(): array
{
    $sql = "
        SELECT 
            seminare.*,
            fachbereiche.name AS fachbereich_name

        FROM seminare

        LEFT JOIN fachbereiche
        ON seminare.fachbereich_id = fachbereiche.id
    ";

    $stmt = $this->db->prepare($sql);

    $stmt->execute();

    return $stmt->fetchAll();
}

public function selectWithTermine(int $id): array
{
    $sql = "
        SELECT 
            seminare.*,
            termine.id AS termin_id,
            termine.beginn,
            termine.ende,
            termine.dauer,
            standorte.name AS standort_name,
            raeume.name AS raum_name,
			fachbereiche.name AS fachbereich_name

        FROM seminare

        LEFT JOIN termine
            ON termine.seminare_id = seminare.id

        LEFT JOIN standorte
            ON termine.standort_id = standorte.id

        LEFT JOIN raeume
            ON termine.raeume_id = raeume.id
		
		 JOIN fachbereiche
        	ON seminare.fachbereich_id = fachbereiche.id

        WHERE seminare.id = :id
    ";

    $stmt = $this->db->prepare($sql);
#dd($sql);
    $stmt->execute([
        'id' => $id
    ]);

    return $stmt->fetchAll();
}

	# Setter / Getter
	function getTitle()
	{
		return $this->title;
	}
	function setTitle($param)
	{
		$this->title =$param;
	}
	function getFacbereich_id()// 
	{
		return $this->facbereich_id;
	}
	function setFacbereich_id($param) // 
	{
		$this->facbereich_id = $param;
	}

	function getBeschreibung()
	{
		return $this->beschreibung;
	}

	function setBeschreibung($param)
	{
		$this->beschreibung = $param;
	}
	function setPreis($param) //
	{
		$this->preis = $param;
	}

	function getPreis() // 
	{
		return $this->preis;
	}
	function getStatus()
	{
		return $this->status;
	}

	function setStatus($param)
	{
		$this->status = $param;
	}









}



?>