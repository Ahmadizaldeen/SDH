<?php
require_once __DIR__ . "/../config/chk_session.php";
require_once __DIR__ . "/../include/funktionen/msg.php";
require_once __DIR__ . "/../include/templates/navigation.php";
require_once __DIR__ . "/../include/debug.php";
#dd($_SESSION);
echo "<h1>Student Development House</h1>";
$msg_eingelogt = $_SESSION['msg']['done']['eingelogt'] ?? '';
ok_msg($msg_eingelogt);
#dd($_SESSION['login_data']['eingelogt']);
if (isset($_SESSION['login_data']['eingelogt']))
    echo "<h2> Hallo " . ($_SESSION['login_data']['alias'] ?: $_SESSION['login_data']['vorname']) . "! </h2>";

dd($_SESSION);
?>
