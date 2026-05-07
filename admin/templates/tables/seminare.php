<?php
use Classes\Seminar;
use Classes\Fachbereiche;

$obj       = new Seminar();
$seminare  = $obj->getAllWithFachbereich();
$base      = BASE_URL . '/admin/index.php';
?>

<div class="admin-card">
    <div class="admin-card-header">
        <h2>📚 Seminare (<?= count($seminare) ?>)</h2>
        <a href="<?= $base ?>?view=seminar_form" class="btn btn-primary btn-sm">+ Neues Seminar</a>
    </div>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Titel</th>
                    <th>Fachbereich</th>
                    <th>Preis</th>
                    <th>Status</th>
                    <th>Aktionen</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($seminare as $s): ?>
                <tr>
                    <td><?= $s['id'] ?></td>
                    <td><?= htmlspecialchars($s['title']) ?></td>
                    <td><?= htmlspecialchars($s['fachbereich_name'] ?? '–') ?></td>
                    <td><?= number_format((float)($s['preis'] ?? 0), 2, ',', '.') ?> €</td>
                    <td>
                        <span class="badge badge-<?= htmlspecialchars($s['status'] ?? 'neu') ?>">
                            <?= htmlspecialchars($s['status'] ?? 'neu') ?>
                        </span>
                    </td>
                    <td style="display:flex; gap:6px;">
                        <a href="<?= $base ?>?view=seminar_form&id=<?= $s['id'] ?>"
                           class="btn btn-ghost btn-sm">✏️ Edit</a>
                        <form class="delete-form"
                              action="<?= BASE_URL ?>/admin/aktionen/delete.php"
                              method="post"
                              onsubmit="return confirm('Seminar wirklich löschen?')">
                            <input type="hidden" name="tabelle" value="seminare">
                            <input type="hidden" name="id"      value="<?= $s['id'] ?>">
                            <input type="hidden" name="redirect" value="seminare">
                            <button class="btn btn-danger btn-sm" type="submit">🗑️</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>