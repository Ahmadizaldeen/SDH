<?php
require_once __DIR__ . "/../config/bootstrap.php";
require_once __DIR__ . "/../include/funktionen/register.php";
require_once __DIR__ . "/../include/templates/head.php";
handleRegisterRequest();
?>


<body class="sdh-page">
<?php require_once __DIR__ . "/../include/templates/navigation.php"; ?>

<div class="sdh-form-shell">
    <div class="sdh-form-card">
        <h1 class="sdh-form-title">Registrierung</h1>
        <p class="sdh-form-lead">Legen Sie ein Konto an. Mit * markierte Felder sind Pflichtfelder.</p>
        <?php msg(); ?>
        <?php require_once __DIR__ . "/../include/templates/register.php"; ?>
    </div>
</div>
</body>
</html>
