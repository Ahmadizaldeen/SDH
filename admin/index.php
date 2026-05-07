<?php
require_once __DIR__ . '/../config/bootstrap.php';
require_once __DIR__ . '/funktionen/admin_login.php';
use Classes\Seminar;
use Classes\Standort;
use Classes\Raum;
use Classes\Termin;
use Classes\Person;

// ── Zugriffsschutz ─────────────────────────
admin_guard();

// ── Aktuelle View aus GET ──────────────────
$view = $_GET['view'] ?? 'dashboard';

// ── Seitentitel bestimmen ─────────────────
$titles = [
    'dashboard'       => 'Dashboard',
    'seminare'        => 'Seminare',
    'seminar_form'    => 'Seminar bearbeiten',
    'termine'         => 'Termine',
    'fachbereiche'    => 'Fachbereiche',
    'fachbereich_form'=> 'Fachbereich bearbeiten',
    'standorte'       => 'Standorte',
    'standort_form'   => 'Standort bearbeiten',
    'raeume'          => 'Räume',
    'raum_form'       => 'Raum bearbeiten',
    'users'           => 'Benutzer',
];
$admin_page_title = $titles[$view] ?? 'Admin';

// ── Templates laden ───────────────────────
require_once __DIR__ . '/templates/head.php';
?>
<body>
<div class="admin-layout">

    <?php require_once __DIR__ . '/templates/nav.php'; ?>

    <main class="admin-main">

        <!-- Topbar -->
        <div class="admin-topbar">
            <h1><?= htmlspecialchars($admin_page_title) ?></h1>
            <div class="topbar-right">
                SDH Seminarhaus
            </div>
        </div>

        <!-- Content -->
        <div class="admin-content">

            <?php
            // ── Flash Messages ─────────────────────
            if (!empty($_SESSION['admin_msg'])):
                $type = $_SESSION['admin_msg']['type'] ?? 'success';
                $text = $_SESSION['admin_msg']['text'] ?? '';
                unset($_SESSION['admin_msg']);
            ?>
                <div class="msg-<?= $type === 'error' ? 'error' : 'success' ?>">
                    <?= htmlspecialchars($text) ?>
                </div>
            <?php endif; ?>

            <?php
            // ── Haupt-Router (switch:case via GET ?view=) ──
            switch ($view):

                // ── Dashboard ──────────────────────
                case 'dashboard':
                    /*use Classes\Seminar;
                    use Classes\Standort;
                    use Classes\Raum;
                    use Classes\Termin;
                    use Classes\Person;*/

                    $anzSeminare  = count((new Seminar())->selectAll());
                    $anzStandorte = count((new Standort())->selectAll());
                    $anzRaeume    = count((new Raum())->selectAll());
                    $anzTermine   = count((new Termin())->selectAll());
                    $anzUsers     = count((new Person())->selectAll());
                    ?>

                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-label">📚 Seminare</div>
                            <div class="stat-value"><?= $anzSeminare ?></div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-label">📅 Termine</div>
                            <div class="stat-value"><?= $anzTermine ?></div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-label">📍 Standorte</div>
                            <div class="stat-value"><?= $anzStandorte ?></div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-label">🚪 Räume</div>
                            <div class="stat-value"><?= $anzRaeume ?></div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-label">👤 Benutzer</div>
                            <div class="stat-value"><?= $anzUsers ?></div>
                        </div>
                    </div>

                    <div class="admin-card">
                        <div class="admin-card-header">
                            <h2>🚀 Schnellzugriff</h2>
                        </div>
                        <div class="admin-card-body" style="display:flex; gap:12px; flex-wrap:wrap;">
                            <a href="?view=seminar_form"  class="btn btn-primary">+ Neues Seminar</a>
                            <a href="?view=standort_form" class="btn btn-primary">+ Neuer Standort</a>
                            <a href="?view=raum_form"     class="btn btn-primary">+ Neuer Raum</a>
                            <a href="?view=seminare"      class="btn btn-ghost">Alle Seminare</a>
                            <a href="?view=users"         class="btn btn-ghost">Alle Benutzer</a>
                        </div>
                    </div>

                    <?php
                    break;

                // ── Tabellen ────────────────────────
                case 'seminare':
                    require_once __DIR__ . '/templates/tables/seminare.php';
                    break;

                case 'termine':
                    require_once __DIR__ . '/templates/tables/termine.php';
                    break;

                case 'fachbereiche':
                    require_once __DIR__ . '/templates/tables/fachbereiche.php';
                    break;

                case 'standorte':
                    require_once __DIR__ . '/templates/tables/standorte.php';
                    break;

                case 'raeume':
                    require_once __DIR__ . '/templates/tables/raeume.php';
                    break;

                case 'users':
                    require_once __DIR__ . '/templates/tables/users.php';
                    break;

                // ── Formulare ────────────────────────
                case 'seminar_form':
                    require_once __DIR__ . '/templates/forms/seminar_form.php';
                    break;

                case 'standort_form':
                    require_once __DIR__ . '/templates/forms/standort_form.php';
                    break;

                case 'raum_form':
                    require_once __DIR__ . '/templates/forms/raum_form.php';
                    break;

                case 'fachbereich_form':
                    require_once __DIR__ . '/templates/forms/fachbereich_form.php';
                    break;

                // ── 404 Fallback ─────────────────────
                default:
                    echo '<div class="msg-error">❌ Seite "<strong>'
                        . htmlspecialchars($view)
                        . '</strong>" wurde nicht gefunden.</div>';
                    break;

            endswitch;
            ?>

        </div><!-- /.admin-content -->
    </main>

</div><!-- /.admin-layout -->
</body>
</html>