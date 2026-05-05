<?php
//Session starten
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//BASE_URL
$_scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http';

$_root = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '/');

$_dir = str_replace('\\', '/', dirname(__DIR__));

define('BASE_URL', $_scheme . '://' . $_SERVER['HTTP_HOST'] . str_replace($_root, '', $_dir));

unset($_scheme, $_root, $_dir);

//db verbindung
require_once __DIR__ . "/db/db_conn.php"; //aufrufen mit db()

//Funktionen :
require_once __DIR__ . "/../include/debug.php";//?trait?
require_once __DIR__ . "/../include/funktionen/msg.php";//? trait ?

?>