<?php
require_once __DIR__ . "/../../config/bootstrap.php";
?>
<form
    class="sdh-form"
    method="post"
    action="<?= BASE_URL ?>/include/funktionen/logout.php"
    onsubmit="return confirm('Wirklich abmelden?');"
>
    <p class="sdh-form-lead" style="margin-bottom: 0;">Sie sind angemeldet. Möchten Sie sich abmelden?</p>
    <div class="sdh-actions">
        <button class="sdh-btn sdh-btn--danger" type="submit">Abmelden</button>
        <a class="sdh-btn sdh-btn--muted" href="<?= BASE_URL ?>/pages/home.php">Abbrechen</a>
    </div>
</form>
