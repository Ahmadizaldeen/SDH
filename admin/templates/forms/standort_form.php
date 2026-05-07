<?php
use Classes\Standort;

$id     = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$isEdit = $id > 0;
$data   = ['name' => '', 'adresse_id' => ''];
$adressData = ['strasse' => '', 'haus_nr' => '', 'plz' => '', 'stadt' => ''];

if ($isEdit) {
    $obj  = new Standort();
    $data = $obj->select($id) ?? $data;

    $adresseId = (int)($data['adresse_id'] ?? 0);
    if ($adresseId > 0) {
        $stmt = db()->prepare('SELECT strasse, haus_nr, plz, stadt FROM adresse WHERE id = :id');
        $stmt->execute([':id' => $adresseId]);
        $adressData = $stmt->fetch(\PDO::FETCH_ASSOC) ?: $adressData;
    }
}

$action = $isEdit
    ? BASE_URL . '/admin/aktionen/update.php'
    : BASE_URL . '/admin/aktionen/insert.php';
?>

<div class="admin-card">
    <div class="admin-card-header">
        <h2><?= $isEdit ? '✏️ Standort bearbeiten' : '➕ Neuer Standort' ?></h2>
        <a href="<?= BASE_URL ?>/admin/index.php?view=standorte" class="btn btn-ghost btn-sm">← Zurück</a>
    </div>
    <div class="admin-card-body">
        <form class="admin-form" action="<?= $action ?>" method="post">
            <?php if ($isEdit): ?>
                <input type="hidden" name="id" value="<?= $id ?>">
            <?php endif; ?>
            <input type="hidden" name="tabelle"  value="standorte">
            <input type="hidden" name="redirect" value="standorte">

            <div class="form-group">
                <label for="name">Standortname</label>
                <input type="text"
                       id="name"
                       name="name"
                       value="<?= htmlspecialchars($data['name'] ?? '') ?>"
                       placeholder="z. B. Berlin Mitte"
                       required
                       maxlength="255">
            </div>

            <div class="form-group">
                <label for="adresse_id">Adresse ID</label>
                <input type="number"
                       id="adresse_id"
                       name="adresse_id"
                       value="<?= htmlspecialchars($data['adresse_id'] ?? '') ?>"
                       placeholder="Adresse-ID aus der Adresstabelle"
                       min="1">
            </div>

            <?php if ($isEdit): ?>
                <div class="form-row">
                    <div class="form-group">
                        <label for="strasse">Straße</label>
                        <input type="text"
                               id="strasse"
                               name="strasse"
                               value="<?= htmlspecialchars($adressData['strasse'] ?? '') ?>"
                               maxlength="100">
                    </div>
                    <div class="form-group">
                        <label for="haus_nr">Hausnr</label>
                        <input type="text"
                               id="haus_nr"
                               name="haus_nr"
                               value="<?= htmlspecialchars($adressData['haus_nr'] ?? '') ?>"
                               maxlength="20">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="plz">PLZ</label>
                        <input type="text"
                               id="plz"
                               name="plz"
                               value="<?= htmlspecialchars($adressData['plz'] ?? '') ?>"
                               maxlength="20">
                    </div>
                    <div class="form-group">
                        <label for="stadt">Stadt</label>
                        <input type="text"
                               id="stadt"
                               name="stadt"
                               value="<?= htmlspecialchars($adressData['stadt'] ?? '') ?>"
                               maxlength="100">
                    </div>
                </div>
            <?php endif; ?>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <?= $isEdit ? '💾 Speichern' : '➕ Erstellen' ?>
                </button>
                <a href="<?= BASE_URL ?>/admin/index.php?view=standorte" class="btn btn-ghost">Abbrechen</a>
            </div>
        </form>
    </div>
</div>