<?php
require_once __DIR__ . "/../config/chk_session.php";
require_once __DIR__ . "/../include/templates/navigation.php";
require_once __DIR__ . "/../include/templates/login_form.php";
require_once __DIR__ ."/../include/funktionen/login.php";
require_once __DIR__ ."/../config/db/db_conn.php";
$db=db();
$user = login( $db );
#msg()
?>