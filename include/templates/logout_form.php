<?php
require_once __DIR__ ."/../../config/bootstrap.php";
?>
<form method="POST" action="<?= BASE_URL ?>/include/funktionen/logout.php" onsubmit="return confirm('Wirklich abmelden?')">
    <button type="submit">Abmelden</button>
</form>