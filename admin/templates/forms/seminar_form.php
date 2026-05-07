<?php
use Classes\Seminar;
use Classes\Fachbereiche;

$id      = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$isEdit  = $id > 0;
$data    = ['title' => '', 'beschreibung' => '', 'preis' => '', 'status' => 'neu', 'fachbereich_id' => ''];

if ($isEdit) {
    $obj  = new Seminar();
    $data = $obj->select($id) ?? $data;
}

$fachObj      = new Fachbereiche();
$fachbereiche = $fachObj->selectAll();

$action = $isEdit
    ? BASE_URL . '/admin/aktionen/update.php'
    : BASE_URL . '/admin/aktionen/insert.php';
?>

<div class="admin-card">
    <div class="admin-card-header">
        <h2><?= $isEdit ? '✏️ Seminar bearbeiten' : '➕ Neues Seminar' ?></h2>
        <a href="<?= BASE_URL ?>/admin/index.php?view=seminare" class="btn btn-ghost btn-sm">← Zurück</a>
    </div>
    <div class="admin-card-body">
        <form class="admin-form" action="<?= $action ?>" method="post">
            <?php if ($isEdit): ?>
                <input type="hidden" name="id" value="<?= $id ?>">
            <?php endif; ?>
            <input type="hidden" name="tabelle"  value="seminare">
            <input type="hidden" name="redirect" value="seminare">

            <div class="form-group">
                <label for="title">Titel</label>
                <input type="text"
                       id="title"
                       name="title"
                       value="<?= htmlspecialchars($data['title'] ?? '') ?>"
                       placeholder="Seminar-Titel"
                       required
                       maxlength="255">
            </div>

            <div class="form-group">
                <label for="beschreibung">Beschreibung</label>
                <textarea id="beschreibung"
                          name="beschreibung"
                          placeholder="Kurzbeschreibung des Seminars"><?= htmlspecialchars($data['beschreibung'] ?? '') ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="preis">Preis (€)</label>
                    <input type="number"
                           id="preis"
                           name="preis"
                           value="<?= htmlspecialchars($data['preis'] ?? '') ?>"
                           placeholder="0.00"
                           step="0.01"
                           min="0">
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <?php foreach (['neu', 'aktiv', 'inaktiv'] as $s): ?>
                            <option value="<?= $s ?>"
                                <?= ($data['status'] ?? 'neu') === $s ? 'selected' : '' ?>>
                                <?= ucfirst($s) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="fachbereich_id">Fachbereich</label>
                <select id="fachbereich_id" name="fachbereich_id">
                    <option value="">– Bitte wählen –</option>
                    <?php foreach ($fachbereiche as $fb): ?>
                        <option value="<?= $fb['id'] ?>"
                            <?= ($data['fachbereich_id'] ?? '') == $fb['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($fb['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <?= $isEdit ? '💾 Speichern' : '➕ Erstellen' ?>
                </button>
                <a href="<?= BASE_URL ?>/admin/index.php?view=seminare" class="btn btn-ghost">Abbrechen</a>
            </div>
        </form>
    </div>
</div>