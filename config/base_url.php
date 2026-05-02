<?php
$_scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http';

$_root = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '/');

$_dir = str_replace('\\', '/', dirname(__DIR__));

define('BASE_URL', $_scheme . '://' . $_SERVER['HTTP_HOST'] . str_replace($_root, '', $_dir));

unset($_scheme, $_root, $_dir);
?>