<?php
require_once __DIR__ . '/../../config/bootstrap.php';
require_once __DIR__ . '/../funktionen/admin_login.php';

admin_guard();

$tabelle  = $_POST['tabelle']  ?? '';
$redirect = $_POST['redirect'] ?? 'dashboard';
$id       = (int)($_POST['id'] ?? 0);

// Erlaubte Tabellen (Whitelist)
$erlaubt = ['seminare', 'standorte', 'raeume', 'fachbereiche'];

if (!in_array($tabelle, $erlaubt) || $id < 1) {
    $_SESSION['admin_msg'] = ['type' => 'error', 'text' => 'Ungültige Anfrage.'];
    header('Location: ' . BASE_URL . '/admin/index.php?view=' . $redirect);
    exit;
}

// POST-Daten ohne interne Felder
$felder = $_POST;
unset($felder['tabelle'], $felder['redirect'], $felder['id']);

// Standort-Edit inkl. Adressdaten (Lernprojekt):
// Wenn Adressfelder im Formular kommen, Adresse mitschreiben und mit Standort verknuepfen.
if (
    $tabelle === 'standorte'
    && (isset($_POST['strasse']) || isset($_POST['haus_nr']) || isset($_POST['plz']) || isset($_POST['stadt']))
) {
    $name      = trim((string)($_POST['name'] ?? ''));
    $strasse   = trim((string)($_POST['strasse'] ?? ''));
    $hausNr    = trim((string)($_POST['haus_nr'] ?? ''));
    $plz       = trim((string)($_POST['plz'] ?? ''));
    $stadt     = trim((string)($_POST['stadt'] ?? ''));
    $adresseId = (int)($_POST['adresse_id'] ?? 0);

    if ($name === '') {
        $_SESSION['admin_msg'] = ['type' => 'error', 'text' => 'Standortname darf nicht leer sein.'];
        header('Location: ' . BASE_URL . '/admin/index.php?view=' . $redirect);
        exit;
    }

    if ($strasse === '' || $hausNr === '' || $plz === '' || $stadt === '') {
        $_SESSION['admin_msg'] = ['type' => 'error', 'text' => 'Bitte alle Adressfelder ausfuellen.'];
        header('Location: ' . BASE_URL . '/admin/index.php?view=' . $redirect);
        exit;
    }

    try {
        $db = db();
        $db->beginTransaction();

        if ($adresseId > 0) {
            $existsStmt = $db->prepare('SELECT id FROM adresse WHERE id = :id');
            $existsStmt->execute([':id' => $adresseId]);
            $exists = (bool)$existsStmt->fetchColumn();

            if ($exists) {
                $addrUpdate = $db->prepare(
                    'UPDATE adresse
                     SET strasse = :strasse, haus_nr = :haus_nr, plz = :plz, stadt = :stadt
                     WHERE id = :id'
                );
                $addrUpdate->execute([
                    ':strasse' => $strasse,
                    ':haus_nr' => $hausNr,
                    ':plz' => $plz,
                    ':stadt' => $stadt,
                    ':id' => $adresseId
                ]);
            } else {
                $addrInsert = $db->prepare(
                    'INSERT INTO adresse (strasse, haus_nr, plz, stadt)
                     VALUES (:strasse, :haus_nr, :plz, :stadt)'
                );
                $addrInsert->execute([
                    ':strasse' => $strasse,
                    ':haus_nr' => $hausNr,
                    ':plz' => $plz,
                    ':stadt' => $stadt
                ]);
                $adresseId = (int)$db->lastInsertId();
            }
        } else {
            $addrInsert = $db->prepare(
                'INSERT INTO adresse (strasse, haus_nr, plz, stadt)
                 VALUES (:strasse, :haus_nr, :plz, :stadt)'
            );
            $addrInsert->execute([
                ':strasse' => $strasse,
                ':haus_nr' => $hausNr,
                ':plz' => $plz,
                ':stadt' => $stadt
            ]);
            $adresseId = (int)$db->lastInsertId();
        }

        $standortUpdate = $db->prepare(
            'UPDATE standorte
             SET name = :name, adresse_id = :adresse_id
             WHERE id = :id'
        );
        $standortUpdate->execute([
            ':name' => $name,
            ':adresse_id' => $adresseId,
            ':id' => $id
        ]);

        $db->commit();
        $_SESSION['admin_msg'] = ['type' => 'success', 'text' => '✅ Standort und Adresse erfolgreich aktualisiert.'];
    } catch (\PDOException $e) {
        if (isset($db) && $db->inTransaction()) {
            $db->rollBack();
        }
        $_SESSION['admin_msg'] = ['type' => 'error', 'text' => 'Fehler: ' . $e->getMessage()];
    }

    header('Location: ' . BASE_URL . '/admin/index.php?view=' . $redirect);
    exit;
}

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

    $set  = implode(', ', array_map(fn($k) => "{$k} = :{$k}", array_keys($felder)));
    $sql  = "UPDATE {$tabelle} SET {$set} WHERE id = :id";

    $stmt = $db->prepare($sql);

    foreach ($felder as $key => $val) {
        $stmt->bindValue(":$key", trim($val));
    }
    $stmt->bindValue(':id', $id, \PDO::PARAM_INT);

    $stmt->execute();

    $_SESSION['admin_msg'] = ['type' => 'success', 'text' => '✅ Eintrag erfolgreich aktualisiert.'];

} catch (\PDOException $e) {
    $_SESSION['admin_msg'] = ['type' => 'error', 'text' => 'Fehler: ' . $e->getMessage()];
}

header('Location: ' . BASE_URL . '/admin/index.php?view=' . $redirect);
exit;