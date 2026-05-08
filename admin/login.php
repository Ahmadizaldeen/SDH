<?php
require_once __DIR__ . '/../config/bootstrap.php';
require_once __DIR__ . '/funktionen/admin_login.php';
if ($_SESSION['admin_url']){
     #dd($_SESSION['admin_url']);
   
    #dd($_SESSION['admin_url']);
// Bereits eingeloggt → direkt zum Dashboard
if (admin_is_logged_in()) {
    header('Location: ' . BASE_URL . '/admin/index.php');
    exit;
}


$fehler = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username'] ?? '');
    $pass = trim($_POST['password'] ?? '');

    if (admin_login($user, $pass)) {
        header('Location: ' . BASE_URL . '/admin/index.php');
        exit;
    } else {
        $fehler = 'Benutzername oder Passwort falsch.';
    }
}
}
else{
    header('Location: ' . BASE_URL . '/pages/home.php');// zu home seite ohne das geheimnis URL
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDH Admin – Login</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/admin/css/admin.css">
</head>
<body>

<div class="admin-login-wrap">
    <div class="admin-login-box">

        <h1>SDH Admin</h1>
        <p>Bitte melde dich mit deinen Admin-Zugangsdaten an.</p>

        <?php if ($fehler): ?>
            <div class="msg-error"><?= htmlspecialchars($fehler) ?></div>
        <?php endif; ?>

        <form class="admin-form" action="" method="post">

            <div class="form-group">
                <label for="username">Benutzername</label>
                <input type="text"
                       id="username"
                       name="username"
                       placeholder="admin"
                       autocomplete="username"
                       required
                       autofocus>
            </div>

            <div class="form-group">
                <label for="password">Passwort</label>
                <input type="password"
                       id="password"
                       name="password"
                       placeholder="••••••••"
                       autocomplete="current-password"
                       required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary" style="width:100%;">
                    🔐 Anmelden
                </button>
            </div>

        </form>
    </div>
</div>

</body>
</html>