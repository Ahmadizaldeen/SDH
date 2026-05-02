
<?php
require_once __DIR__ . "/../funktionen/msg.php";

function msg()
{
    if (!empty($_SESSION['msg']['error'])) {
		foreach($_SESSION['msg']['error'] AS $e)
			echo "<p style='color: red;'>" . $e . "</p>";
        unset ($_SESSION['msg']['error']) ;
    }

    if (!empty($_SESSION['msg']['done'])) {
		foreach($_SESSION['msg']['done'] AS $done)
        echo "<p style='color: green;'>" . $done . "</p>";
        unset ($_SESSION['msg']['done']) ;
		
    }
}

function error_msg($msg){
    echo "<p style='color: red;'>" . $msg . "</p>";

}
function ok_msg($msg){
    echo "<p style='color: green;'>" . $msg . "</p>";

}

 ?>
 