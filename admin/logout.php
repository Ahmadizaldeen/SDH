<?php
require_once __DIR__ . '/../config/bootstrap.php';
require_once __DIR__ . '/funktionen/admin_login.php';

admin_logout();
 unset($_SESSION["admin_url"]) ;// nur einmalige zugang zum login, index ohne admin_guard() nicht erreichbar
header('Location: ' . BASE_URL . '/admin/login.php');
exit;