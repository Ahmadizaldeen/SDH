<?php
require_once __DIR__ . "/../config/bootstrap.php";
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abmelden – Student Development House</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/forms.css">
</head>
<body class="sdh-page">
<?php require_once __DIR__ . "/../include/templates/navigation.php"; ?>

<div class="sdh-form-shell sdh-form-shell--narrow">
    <div class="sdh-form-card">
        <h1 class="sdh-form-title">Abmelden</h1>
        <?php msg(); ?>
        <?php require_once __DIR__ . "/../include/templates/logout_form.php"; ?>
    </div>
</div>
</body>
</html>
