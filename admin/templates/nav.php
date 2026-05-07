<?php
$current_view = $_GET['view'] ?? 'dashboard';
$base = BASE_URL . '/admin/index.php';

function nav_link(string $view, string $label, string $icon, string $current, string $base): string
{
    $active = ($current === $view) ? ' active' : '';
    return "<a href=\"{$base}?view={$view}\" class=\"{$active}\">{$icon} {$label}</a>";
}
?>
<aside class="admin-sidebar">
    <div class="admin-logo">
        SDH Admin
        <span>Verwaltungsbereich</span>
    </div>

    <nav class="admin-nav">
        <div class="nav-section">Übersicht</div>
        <?= nav_link('dashboard', 'Dashboard', '📊', $current_view, $base) ?>

        <div class="nav-section">Inhalte</div>
        <?= nav_link('seminare',    'Seminare',    '📚', $current_view, $base) ?>
        <?= nav_link('termine',     'Termine',     '📅', $current_view, $base) ?>
        <?= nav_link('fachbereiche','Fachbereiche','🏷️',  $current_view, $base) ?>

        <div class="nav-section">Orte</div>
        <?= nav_link('standorte', 'Standorte', '📍', $current_view, $base) ?>
        <?= nav_link('raeume',    'Räume',     '🚪', $current_view, $base) ?>

        <div class="nav-section">Nutzer</div>
        <?= nav_link('users',      'Benutzer',    '👤', $current_view, $base) ?>
    </nav>

    <div class="admin-sidebar-footer">
        Eingeloggt als <strong><?= htmlspecialchars($_SESSION['admin']['name'] ?? 'Admin') ?></strong><br>
        <a href="<?= BASE_URL ?>/admin/logout.php">Abmelden</a>
    </div>
</aside>