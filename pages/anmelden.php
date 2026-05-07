<?php
require_once __DIR__ . "/../config/bootstrap.php";

use Classes\Person;
use Classes\Termin;

if (!Person::isLoggedIn()) {
    $_SESSION['msg']['error'][] = "Bitte zuerst einloggen.";
    header("Location: " . BASE_URL . "/pages/login.php");
    exit;
}

$terminId = (int) ($_GET["termin_id"] ?? 0);
if ($terminId < 1) {
    $_SESSION["msg"]["error"][] = "Ungültiger Termin.";
    header("Location: " . BASE_URL . "/pages/seminare.php");
    exit;
}

$terminObj = new Termin();
$userId = (int) Person::getUser()["id"];

try {
    if ($terminObj->anmelden($userId, $terminId)) {
        $_SESSION["msg"]["done"][] = "Anmeldung für den Termin gespeichert.";
    } else {
        $_SESSION["msg"]["error"][] = "Anmeldung nicht möglich (Termin voll?).";
    }
} catch (\PDOException $e) {
    $sqlDup = isset($e->errorInfo[1]) && (int) $e->errorInfo[1] === 1062;
    if ($sqlDup || $e->getCode() === "23000") {
        $_SESSION["msg"]["error"][] = "Sie sind für diesen Termin bereits angemeldet.";
    } else {
        $_SESSION["msg"]["error"][] = "Anmeldung fehlgeschlagen.";
    }
}

$back = $_SERVER["HTTP_REFERER"] ?? (BASE_URL . "/pages/seminare.php");
header("Location: " . $back);
exit;
