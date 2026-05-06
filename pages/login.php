<?php
require_once __DIR__ . "/../config/bootstrap.php";
require_once __DIR__ . "/../include/templates/navigation.php";
require_once __DIR__ . "/../include/templates/login_form.php";
require_once __DIR__ ."/../include/funktionen/login.php";

$db=db();
$user = login( $db );
msg();
?>