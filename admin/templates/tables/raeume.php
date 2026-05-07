<?php
use Classes\Raum;
use Classes\Standort;

$obj   = new Raum();
$rooms = $obj->selectAll();
$base  = BASE_URL . '/admin/index.php';
$zeigeIds = (($_GET['mode'] ?? 'namen') === 'ids');

$standortMap = [];
foreach ((new Standort())->selectAll() as $s) {
    $standortMap[(int)$s['id']] = $s['name'] ?? ('Standort #' . $s['id']);
}
?>

<div class="admin-card">
    <div class="admin-card-header">
        <h2>🚪 Räume (<?= count($rooms) ?>)</h2>
        <div style="display:flex; gap:8px;">
            <a href="<?= $base ?>?view=raeume&mode=namen" class="btn btn-ghost btn-sm">Standortname</a>
            <a href="<?= $base ?>?view=raeume&mode=ids" class="btn btn-ghost btn-sm">Standort-ID</a>
            <a href="<?= $base ?>?view=raum_form" class="btn btn-primary btn-sm">+ Neuer Raum</a>
        </div>
    </div>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th><?= $zeigeIds ? 'Standort ID' : 'Standort' ?></th>
                    <th>Aktionen</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($rooms as $r): ?>
                <?php $standortId = isset($r['standort_id']) ? (int)$r['standort_id'] : 0; ?>
                <tr>
                    <td><?= $r['id'] ?></td>
                    <td><?= htmlspecialchars($r['name'] ?? '–') ?></td>
                    <td>
                        <?= $zeigeIds
                            ? htmlspecialchars((string)($r['standort_id'] ?? '–'))
                            : htmlspecialchars($standortMap[$standortId] ?? ('ID: ' . ($r['standort_id'] ?? '–'))) ?>
                    </td>
                    <td style="display:flex; gap:6px;">
                        <a href="<?= $base ?>?view=raum_form&id=<?= $r['id'] ?>"
                           class="btn btn-ghost btn-sm">✏️ Edit</a>
                        <form class="delete-form"
                              action="<?= BASE_URL ?>/admin/aktionen/delete.php"
                              method="post"
                              onsubmit="return confirm('Raum wirklich löschen?')">
                            <input type="hidden" name="tabelle"  value="raeume">
                            <input type="hidden" name="id"       value="<?= $r['id'] ?>">
                            <input type="hidden" name="redirect" value="raeume">
                            <button class="btn btn-danger btn-sm" type="submit">🗑️</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>