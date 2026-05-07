<?php
use Classes\Raum;
use Classes\Standort;

$id     = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$isEdit = $id > 0;
$data   = ['name' => '', 'standort_id' => ''];

if ($isEdit) {
    $obj  = new Raum();
    $data = $obj->select($id) ?? $data;
}

$standortObj = new Standort();
$standorte   = $standortObj->selectAll();

$action = $isEdit
    ? BASE_URL . '/admin/aktionen/update.php'
    : BASE_URL . '/admin/aktionen/insert.php';
?>

<div class="admin-card">
    <div class="admin-card-header">
        <h2><?= $isEdit ? '✏️ Raum bearbeiten' : '➕ Neuer Raum' ?></h2>
        <a href="<?= BASE_URL ?>/admin/index.php?view=raeume" class="btn btn-ghost btn-sm">← Zurück</a>
    </div>
    <div class="admin-card-body">
        <form class="admin-form" action="<?= $action ?>" method="post">
            <?php if ($isEdit): ?>
                <input type="hidden" name="id" value="<?= $id ?>">
            <?php endif; ?>
            <input type="hidden" name="tabelle"  value="raeume">
            <input type="hidden" name="redirect" value="raeume">

            <div class="form-group">
                <label for="name">Raumname</label>
                <input type="text"
                       id="name"
                       name="name"
                       value="<?= htmlspecialchars($data['name'] ?? '') ?>"
                       placeholder="z. B. Raum A1"
                       required
                       maxlength="255">
            </div>

            <div class="form-group">
                <label for="standort_id">Standort</label>
                <select id="standort_id" name="standort_id" required>
                    <option value="">– Bitte wählen –</option>
                    <?php foreach ($standorte as $s): ?>
                        <option value="<?= $s['id'] ?>"
                            <?= ($data['standort_id'] ?? '') == $s['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($s['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <?= $isEdit ? '💾 Speichern' : '➕ Erstellen' ?>
                </button>
                <a href="<?= BASE_URL ?>/admin/index.php?view=raeume" class="btn btn-ghost">Abbrechen</a>
            </div>
        </form>
    </div>
</div>