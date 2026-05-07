<?php
require_once __DIR__ . '/../../config/bootstrap.php';
require_once __DIR__ . '/../funktionen/admin_login.php';

admin_guard();// zugriffschutztabelle, redirect und id aus POST holen

$tabelle  = $_POST['tabelle']  ?? '';
$redirect = $_POST['redirect'] ?? 'dashboard';// weiterleitung nach Löschaktion
$id       = (int)($_POST['id'] ?? 0);//

// Erlaubte Tabellen (Whitelist)
$erlaubt = ['seminare', 'standorte', 'raeume', 'fachbereiche', 'termine', 'users', 'nachrichten'];//nachrichten wird aktull nicht genutzt

if (!in_array($tabelle, $erlaubt) || $id < 1) {
    $_SESSION['admin_msg'] = ['type' => 'error', 'text' => 'Ungültige Anfrage.'];
    header('Location: ' . BASE_URL . '/admin/index.php?view=' . $redirect);
    exit;
}

try {
    $db   = db();
    $stmt = $db->prepare("DELETE FROM {$tabelle} WHERE id = :id");
    $stmt->execute([':id' => $id]);

    $_SESSION['admin_msg'] = ['type' => 'success', 'text' => '🗑️ Eintrag erfolgreich gelöscht.'];

} catch (\PDOException $e) {
    $_SESSION['admin_msg'] = ['type' => 'error', 'text' => 'Fehler: ' . $e->getMessage()];
}

header('Location: ' . BASE_URL . '/admin/index.php?view=' . $redirect);
exit;