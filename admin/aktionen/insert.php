<?php
require_once __DIR__ . '/../../config/bootstrap.php';
require_once __DIR__ . '/../funktionen/admin_login.php';

admin_guard();

$tabelle  = $_POST['tabelle']  ?? '';
$redirect = $_POST['redirect'] ?? 'dashboard';

// Erlaubte Tabellen (Whitelist)
$erlaubt = ['seminare', 'standorte', 'raeume', 'fachbereiche'];

if (!in_array($tabelle, $erlaubt)) {
    $_SESSION['admin_msg'] = ['type' => 'error', 'text' => 'Ungültige Tabelle.'];
    header('Location: ' . BASE_URL . '/admin/index.php?view=' . $redirect);
    exit;
}

// POST-Daten ohne interne Felder
$felder = $_POST;
unset($felder['tabelle'], $felder['redirect']);

// Spezielle Validierung fuer Lernprojekt:
// Raeume muessen einen gueltigen Standort > 0 haben.
if ($tabelle === 'raeume') {
    $standortId = (int)($felder['standort_id'] ?? 0);
    if ($standortId < 1) {
        $_SESSION['admin_msg'] = ['type' => 'error', 'text' => 'Bitte einen gueltigen Standort auswaehlen.'];
        header('Location: ' . BASE_URL . '/admin/index.php?view=' . $redirect);
        exit;
    }
}

try {
    $db = db();

    $spalten      = implode(', ', array_keys($felder));
    $platzhalter  = implode(', ', array_map(fn($k) => ":$k", array_keys($felder)));
    $sql          = "INSERT INTO {$tabelle} ({$spalten}) VALUES ({$platzhalter})";

    $stmt = $db->prepare($sql);

    foreach ($felder as $key => $val) {
        $stmt->bindValue(":$key", trim($val));
    }

    $stmt->execute();

    $_SESSION['admin_msg'] = ['type' => 'success', 'text' => '✅ Eintrag erfolgreich erstellt.'];

} catch (\PDOException $e) {
    $_SESSION['admin_msg'] = ['type' => 'error', 'text' => 'Fehler: ' . $e->getMessage()];
}

header('Location: ' . BASE_URL . '/admin/index.php?view=' . $redirect);
exit;