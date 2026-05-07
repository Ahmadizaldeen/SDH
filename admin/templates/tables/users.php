<?php
use Classes\Person;

$obj   = new Person();
$users = $obj->selectAll();
$base  = BASE_URL . '/admin/index.php';
?>

<div class="admin-card">
    <div class="admin-card-header">
        <h2>👤 Benutzer (<?= count($users) ?>)</h2>
    </div>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Vorname</th>
                    <th>Nachname</th>
                    <th>E-Mail</th>
                    <th>Benutzername</th>
                    <th>Aktionen</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= $u['id'] ?></td>
                    <td><?= htmlspecialchars($u['vorname'] ?? '–') ?></td>
                    <td><?= htmlspecialchars($u['nachname'] ?? '–') ?></td>
                    <td><?= htmlspecialchars($u['email'] ?? '–') ?></td>
                    <td><?= htmlspecialchars($u['user_name'] ?? '–') ?></td>
                    <td>
                        <form class="delete-form"
                              action="<?= BASE_URL ?>/admin/aktionen/delete.php"
                              method="post"
                              onsubmit="return confirm('Benutzer wirklich löschen?')">
                            <input type="hidden" name="tabelle"  value="users">
                            <input type="hidden" name="id"       value="<?= $u['id'] ?>">
                            <input type="hidden" name="redirect" value="users">
                            <button class="btn btn-danger btn-sm" type="submit">🗑️</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>