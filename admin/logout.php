<?php
require_once __DIR__ . '/../config/bootstrap.php';
require_once __DIR__ . '/funktionen/admin_login.php';

admin_logout();

header('Location: ' . BASE_URL . '/admin/login.php');
exit;