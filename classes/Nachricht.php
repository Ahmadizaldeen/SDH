<?php
namespace Classes;
use Classes\Abstract\aDatabank;
use Session\SessionController;
require_once __DIR__ . "/../config/bootstrap.php";


class Nachricht extends aDatabank
{
	use Traits\SessionController;
	# Attribute
	private $id;//
	private $user_id;//
	private $begriff;//
	private $inhalt;// 
	private $zeit_stmp;// 
	private $status;//

	private $db; //


	# Methoden
	public function __construct( array $daten = [])
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
		$sql = "INSERT INTO nachrichten (user_id, begriff, inhalt, zeit_stmp, status_id)
            VALUES (:user_id, :begriff, :inhalt, NOW(), :status_id)";

		$stmt = $this->db->prepare($sql);

		$stmt->execute([
			':user_id' => $this->user_id,
			':begriff' => $this->begriff,
			':inhalt' => $this->inhalt,
			':status_id' => $this->status
		]);

		$_SESSION['msg']['done'][] = "Nachricht gespeichert";
	}

	function select($id)
	{
		$sql = "SELECT * FROM nachrichten WHERE id = :id";
		$stmt = $this->db->prepare($sql);
		$stmt->execute([':id' => $id]);

		$result = $stmt->fetch(\PDO::FETCH_ASSOC);

		if (!$result) {
			$_SESSION['msg']['error'][] = "Nachricht nicht gefunden";
			return null;
		}

		$this->set_daten($result);
		return $result;
	}
	function delete($id)
	{
		$sql = "DELETE FROM nachrichten WHERE id = :id";
		$stmt = $this->db->prepare($sql);
		$stmt->execute([':id' => $id]);

		$_SESSION['msg']['done'][] = "Nachricht gelöscht";
	}
	function update($id)
	{
		$sql = "UPDATE nachrichten
            SET begriff = :begriff,
                inhalt = :inhalt,
                status_id = :status_id
            WHERE id = :id";

		$stmt = $this->db->prepare($sql);

		$stmt->execute([
			':begriff' => $this->begriff,
			':inhalt' => $this->inhalt,
			':status_id' => $this->status,
			':id' => $id
		]);

		$_SESSION['msg']['done'][] = "Nachricht aktualisiert";
	}
	function selectAll()
	{
		$sql = "SELECT * FROM nachrichten ORDER BY zeit_stmp DESC";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	# Setter / Getter

	function setStrasse($param)
	{

	}

	function setHausNr($param) // 
	{
		#$this->email = $param;
	}



	function setPlz($param)
	{
		#$this->vorname = $param;
	}
	function setStadt($param) //
	{
		#$this->alias = $param;
	}










}



?>