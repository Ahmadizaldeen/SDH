<?php
use Classes\Fachbereiche;

$obj          = new Fachbereiche();
$fachbereiche = $obj->selectAll();
$base         = BASE_URL . '/admin/index.php';
?>

<div class="admin-card">
    <div class="admin-card-header">
        <h2>🏷️ Fachbereiche (<?= count($fachbereiche) ?>)</h2>
        <a href="<?= $base ?>?view=fachbereich_form" class="btn btn-primary btn-sm">+ Neuer Fachbereich</a>
    </div>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Aktionen</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($fachbereiche as $f): ?>
                <tr>
                    <td><?= $f['id'] ?></td>
                    <td><?= htmlspecialchars($f['name']) ?></td>
                    <td style="display:flex; gap:6px;">
                        <a href="<?= $base ?>?view=fachbereich_form&id=<?= $f['id'] ?>"
                           class="btn btn-ghost btn-sm">✏️ Edit</a>
                        <form class="delete-form"
                              action="<?= BASE_URL ?>/admin/aktionen/delete.php"
                              method="post"
                              onsubmit="return confirm('Fachbereich wirklich löschen?')">
                            <input type="hidden" name="tabelle"  value="fachbereiche">
                            <input type="hidden" name="id"       value="<?= $f['id'] ?>">
                            <input type="hidden" name="redirect" value="fachbereiche">
                            <button class="btn btn-danger btn-sm" type="submit">🗑️</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>