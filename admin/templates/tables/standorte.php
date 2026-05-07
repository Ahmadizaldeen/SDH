<?php
use Classes\Standort;

$obj       = new Standort();
$standorte = $obj->selectAll();
$base      = BASE_URL . '/admin/index.php';
?>

<div class="admin-card">
    <div class="admin-card-header">
        <h2>📍 Standorte (<?= count($standorte) ?>)</h2>
        <a href="<?= $base ?>?view=standort_form" class="btn btn-primary btn-sm">+ Neuer Standort</a>
    </div>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Adresse ID</th>
                    <th>Aktionen</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($standorte as $s): ?>
                <tr>
                    <td><?= $s['id'] ?></td>
                    <td><?= htmlspecialchars($s['name']) ?></td>
                    <td><?= $s['adresse_id'] ?? '–' ?></td>
                    <td style="display:flex; gap:6px;">
                        <a href="<?= $base ?>?view=standort_form&id=<?= $s['id'] ?>"
                           class="btn btn-ghost btn-sm">✏️ Edit</a>
                        <form class="delete-form"
                              action="<?= BASE_URL ?>/admin/aktionen/delete.php"
                              method="post"
                              onsubmit="return confirm('Standort wirklich löschen?')">
                            <input type="hidden" name="tabelle"  value="standorte">
                            <input type="hidden" name="id"       value="<?= $s['id'] ?>">
                            <input type="hidden" name="redirect" value="standorte">
                            <button class="btn btn-danger btn-sm" type="submit">🗑️</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>