<?php
namespace Classes;
use Classes\Abstract\aDatabank;
use Session\SessionController;
require_once __DIR__ . "/../config/bootstrap.php";


class Termin extends aDatabank
{
	# Attribute
	private $id;//
	private $datum;//
	private $zeit;//
	private $standort_id;// 
	private $notizen;// 
	private $dauer;//

	private $fachbereich_id;//
	private $user_id;//

	private $db; //


	# Methoden
	public function __construct(array $daten = [])
	{
		foreach ($daten as $key => $value) {
			$this->$key = $value;

		}
		$this->db = $this->db();
		$this->set_daten($daten);
		
	}
	public function set_daten($daten) // $daten associative array kommt per $_POST.
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
		$sql = "INSERT INTO termine 
            (datum, zeit, standort_id, notizen, dauer, fachbereich_id, user_id)
            VALUES 
            (:datum, :zeit, :standort_id, :notizen, :dauer, :fachbereich_id, :user_id)";

		$stmt = $this->db->prepare($sql);

		$stmt->execute([
			':datum' => $this->datum,
			':zeit' => $this->zeit,
			':standort_id' => $this->standort_id,
			':notizen' => $this->notizen,
			':dauer' => $this->dauer,
			':fachbereich_id' => $this->fachbereich_id,
			':user_id' => $this->user_id
		]);

		$_SESSION['msg']['done'][] = "Termin gespeichert";
	}

	function select($id)
	{
		$sql = "SELECT * FROM termine WHERE id = :id";
		$stmt = $this->db->prepare($sql);
		$stmt->execute([':id' => $id]);

		$result = $stmt->fetch(\PDO::FETCH_ASSOC);

		if (!$result) {
			$_SESSION['msg']['error'][] = "Termin nicht gefunden";
			return null;
		}

		$this->set_daten($result);
		return $result;
	}
	function delete($id)
	{
		$sql = "DELETE FROM termine WHERE id = :id";
		$stmt = $this->db->prepare($sql);
		$stmt->execute([':id' => $id]);

		$_SESSION['msg']['done'][] = "Termin gelöscht";
	}
	function update($id)
	{
		$sql = "UPDATE termine SET
                datum = :datum,
                zeit = :zeit,
                standort_id = :standort_id,
                notizen = :notizen,
                dauer = :dauer,
                fachbereich_id = :fachbereich_id,
                user_id = :user_id
            WHERE id = :id";

		$stmt = $this->db->prepare($sql);

		$stmt->execute([
			':datum' => $this->datum,
			':zeit' => $this->zeit,
			':standort_id' => $this->standort_id,
			':notizen' => $this->notizen,
			':dauer' => $this->dauer,
			':fachbereich_id' => $this->fachbereich_id,
			':user_id' => $this->user_id,
			':id' => $id
		]);

		$_SESSION['msg']['done'][] = "Termin aktualisiert";
	}
	function selectAll()
	{
		$sql = "SELECT * FROM termine ORDER BY datum ASC";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	/********************************************************************************* */
	# Setter / Getter

	function setDatum($param)
	{
		$this->datum = $param;
	}

	function setZeit($param) // 
	{
		$this->zeit = $param;
	}



	function setStandort_id($param)
	{
		$this->standort_id = $param;
	}
	function setDauer($param) //
	{
		$this->dauer = $param;
	}
	function setNotizen($param)
	{
		$this->notizen = $param;
	}
	function setFachbereichId($param) //
	{
		$this->fachbereich_id = $param;
	}
	function setUser_id($param)
	{
		$this->user_id = $param;
	}

}



?>