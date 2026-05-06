<?php
require_once __DIR__ . "/../config/bootstrap.php";
require_once __DIR__ . "/../include/templates/navigation.php";
require_once __DIR__ ."/../include/funktionen/adresse.php";

#dd($_SESSION);
#dd(BASE_URL);
//adresse Form anzeigen falls noch kein Adrese gespeichert.


echo "<h1>Student Development House</h1>";
$msg_eingelogt = $_SESSION['msg']['done']['eingelogt'] ?? '';
ok_msg($msg_eingelogt);
#dd($_SESSION['login_data']['eingelogt']);
if (isset($_SESSION['login_data']['eingelogt']))
    echo "<h2> Hallo " . ($_SESSION['login_data']['alias'] ?: $_SESSION['login_data']['vorname']) . "! </h2>";

dd($_SESSION);
?>
