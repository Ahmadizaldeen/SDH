<?php
use Classes\Fachbereiche;

$id     = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$isEdit = $id > 0;
$data   = ['name' => ''];

if ($isEdit) {
    $obj  = new Fachbereiche();
    $data = $obj->select($id) ?? $data;
}

$action = $isEdit
    ? BASE_URL . '/admin/aktionen/update.php'
    : BASE_URL . '/admin/aktionen/insert.php';
?>

<div class="admin-card">
    <div class="admin-card-header">
        <h2><?= $isEdit ? '✏️ Fachbereich bearbeiten' : '➕ Neuer Fachbereich' ?></h2>
        <a href="<?= BASE_URL ?>/admin/index.php?view=fachbereiche" class="btn btn-ghost btn-sm">← Zurück</a>
    </div>
    <div class="admin-card-body">
        <form class="admin-form" action="<?= $action ?>" method="post">
            <?php if ($isEdit): ?>
                <input type="hidden" name="id" value="<?= $id ?>">
            <?php endif; ?>
            <input type="hidden" name="tabelle"  value="fachbereiche">
            <input type="hidden" name="redirect" value="fachbereiche">

            <div class="form-group">
                <label for="name">Bezeichnung</label>
                <input type="text"
                       id="name"
                       name="name"
                       value="<?= htmlspecialchars($data['name'] ?? '') ?>"
                       placeholder="z. B. Informatik"
                       required
                       maxlength="255">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <?= $isEdit ? '💾 Speichern' : '➕ Erstellen' ?>
                </button>
                <a href="<?= BASE_URL ?>/admin/index.php?view=fachbereiche" class="btn btn-ghost">Abbrechen</a>
            </div>
        </form>
    </div>
</div>