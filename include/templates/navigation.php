<?php
require_once __DIR__ . "/../../config/bootstrap.php";
?>
<nav class="sdh-nav-bar" aria-label="Hauptnavigation">
<!--<a href = "<?= BASE_URL ?>/start.php">Start</a>-->

<?php if (!isset($_SESSION['login_data']['eingelogt'])): ?>
<a href = "<?= BASE_URL ?>/pages/registeren.php">Register</a>
<?php endif; ?>

<?php if (!isset($_SESSION['login_data']['eingelogt'])): ?>
<a href = "<?= BASE_URL ?>/pages/login.php">Login</a>
<?php endif; ?>

<a href = "<?= BASE_URL ?>/pages/home.php">Home</a>
<a href = "<?= BASE_URL ?>/pages/seminare.php">Seminare</a>

<?php if (isset($_SESSION['login_data']['eingelogt'])): ?>
<a href = "<?= BASE_URL ?>/pages/logout.php" >Sign out</a>
<?php endif; ?>

</nav>
