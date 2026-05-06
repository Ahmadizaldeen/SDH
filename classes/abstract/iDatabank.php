<?php
namespace Classes\Abstract;
interface iDatabank
{ // nur abstrakte Methoden
	function insert(); // Instanz der Klasse pdo
	function select($id);
	function delete($id);
	function update($id);
	function selectAll();
}
?>