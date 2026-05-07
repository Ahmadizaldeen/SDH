<?php
use Classes\Termin;
use Classes\Seminar;
use Classes\Standort;
use Classes\Raum;

$obj     = new Termin();
$termine = $obj->selectAll();
$base    = BASE_URL . '/admin/index.php';
$zeigeIds = (($_GET['mode'] ?? 'namen') === 'ids');

// Neue Lern-Variante:
// IDs aus "termine" -> Namen aus den verknuepften Tabellen aufloesen.
$seminarMap = [];
$standortMap = [];
$raumMap = [];

foreach ((new Seminar())->selectAll() as $s) {
    $seminarMap[(int)$s['id']] = $s['title'] ?? ('Seminar #' . $s['id']);
}

foreach ((new Standort())->selectAll() as $s) {
    $standortMap[(int)$s['id']] = $s['name'] ?? ('Standort #' . $s['id']);
}

foreach ((new Raum())->selectAll() as $r) {
    $raumMap[(int)$r['id']] = $r['name'] ?? ('Raum #' . $r['id']);
}

/*
 * Alte View (Lernprojekt) - nur im Source Code:
 * - Seminar ID aus: $t['seminare_id'] ?? '–'
 * - Standort ID aus: $t['standort_id'] ?? '–'
 * - Raum ID aus: $t['raeume_id'] ?? '–'
 */
?>

<div class="admin-card">
    <div class="admin-card-header">
        <h2>📅 Termine (<?= count($termine) ?>)</h2>
        <div style="display:flex; gap:8px;">
            <a href="<?= $base ?>?view=termine&mode=namen" class="btn btn-ghost btn-sm">Namen</a>
            <a href="<?= $base ?>?view=termine&mode=ids" class="btn btn-ghost btn-sm">IDs</a>
        </div>
    </div>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Beginn</th>
                    <th>Ende</th>
                    <th><?= $zeigeIds ? 'Seminar ID' : 'Seminar' ?></th>
                    <th><?= $zeigeIds ? 'Standort ID' : 'Standort' ?></th>
                    <th><?= $zeigeIds ? 'Raum ID' : 'Raum' ?></th>
                    <th>Aktionen</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($termine as $t): ?>
                <?php
                    $seminarId  = isset($t['seminare_id']) ? (int)$t['seminare_id'] : 0;
                    $standortId = isset($t['standort_id']) ? (int)$t['standort_id'] : 0;
                    $raumId     = isset($t['raeume_id']) ? (int)$t['raeume_id'] : 0;
                ?>
                <tr>
                    <td><?= $t['id'] ?></td>
                    <td><?= htmlspecialchars($t['beginn'] ?? '–') ?></td>
                    <td><?= htmlspecialchars($t['ende'] ?? '–') ?></td>
                    <td>
                        <?= $zeigeIds
                            ? htmlspecialchars((string)($t['seminare_id'] ?? '–'))
                            : htmlspecialchars($seminarMap[$seminarId] ?? ('ID: ' . ($t['seminare_id'] ?? '–'))) ?>
                    </td>
                    <td>
                        <?= $zeigeIds
                            ? htmlspecialchars((string)($t['standort_id'] ?? '–'))
                            : htmlspecialchars($standortMap[$standortId] ?? ('ID: ' . ($t['standort_id'] ?? '–'))) ?>
                    </td>
                    <td>
                        <?= $zeigeIds
                            ? htmlspecialchars((string)($t['raeume_id'] ?? '–'))
                            : htmlspecialchars($raumMap[$raumId] ?? ('ID: ' . ($t['raeume_id'] ?? '–'))) ?>
                    </td>

                    <td>
                        <form class="delete-form"
                              action="<?= BASE_URL ?>/admin/aktionen/delete.php"
                              method="post"
                              onsubmit="return confirm('Termin wirklich löschen?')">
                            <input type="hidden" name="tabelle"  value="termine">
                            <input type="hidden" name="id"       value="<?= $t['id'] ?>">
                            <input type="hidden" name="redirect" value="termine">
                            <button class="btn btn-danger btn-sm" type="submit">🗑️</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>