
<?php
require_once __DIR__ . "/../../config/bootstrap.php";

if (session_status() === PHP_SESSION_ACTIVE) {
    session_unset();
    session_destroy();
}

header("Location: " . BASE_URL . "/pages/home.php");
exit;
