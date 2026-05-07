<?php
require_once __DIR__ . "/../config/bootstrap.php";
require_once __DIR__ . "/../include/funktionen/adresse.php";
require_once __DIR__ ."/../include/templates/head.php";
?>


<body class="sdh-page">
    <?php require_once __DIR__ . "/../include/templates/navigation.php"; ?>

    <div class="sdh-content">
        <?php
        echo "<h1>Student Development House</h1>";
        $msg_eingelogt = $_SESSION['msg']['done']['eingelogt'] ?? '';
        ok_msg($msg_eingelogt);
        if (isset($_SESSION['login_data']['eingelogt'])) {
            echo "<h2>Hallo " . htmlspecialchars($_SESSION['login_data']['alias'] ?: $_SESSION['login_data']['vorname']) . "!</h2>";
        }
        ?>
    </div>
    <img src="<?= BASE_URL ?>/bilder/bild.png" alt="sdh">
<?php require_once __DIR__ ."/../include/templates/footer.php";?>
</body>

</html>