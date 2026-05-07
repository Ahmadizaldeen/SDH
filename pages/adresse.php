<?php
require_once __DIR__ . "/../config/bootstrap.php";
require_once __DIR__ . "/../include/funktionen/adresse.php";
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adresse erfassen – Student Development House</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/forms.css">
</head>
<body class="sdh-page">
<?php require_once __DIR__ . "/../include/templates/navigation.php"; ?>

<div class="sdh-form-shell">
    <div class="sdh-form-card">
        <h1 class="sdh-form-title">Adresse</h1>
        <p class="sdh-form-lead">Bitte ergänzen Sie Ihre Adresse oder überspringen Sie diesen Schritt.</p>
        <?php msg(); ?>
        <?php require_once __DIR__ . "/../include/templates/adresse_form.php"; ?>
    </div>
</div>
</body>
</html>
