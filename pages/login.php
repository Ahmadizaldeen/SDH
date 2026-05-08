<?php
require_once __DIR__ . "/../config/bootstrap.php";
require_once __DIR__ . "/../include/funktionen/login.php";
require_once __DIR__ ."/../include/templates/head.php";
$db = db();
login($db);
?>

<body class="sdh-page">
<?php require_once __DIR__ . "/../include/templates/navigation.php"; ?>

<div class="sdh-form-shell">
    <div class="sdh-form-card">
        <h1 class="sdh-form-title">Login</h1>
        <p class="sdh-form-lead">Melden Sie sich mit Benutzername oder E-Mail und Passwort an.</p>
        <?php
        if (!empty($_SESSION['msg']['done']['register_msg'])) {
            ok_msg($_SESSION['msg']['done']['register_msg']);
            unset($_SESSION['msg']['done']['register_msg']);
        }
        msg();
        ?>
        <?php require_once __DIR__ . "/../include/templates/login_form.php"; ?>
    </div>
</div>
<?php require_once __DIR__ . "/../include/templates/footer.php"; ?>
</html>
