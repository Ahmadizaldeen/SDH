<?php
interface iDatenbank{ # nur abstrakter Methoden
	function insert();# instanz die Klasse pdo
	function select( $id);
	function delete( $id);
	function update($id);
	function selectAll( );
	
}
?>