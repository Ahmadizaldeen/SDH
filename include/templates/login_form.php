<?php
require_once __DIR__ . "/../../config/bootstrap.php";
?>
<form class="sdh-form" action="" method="post" autocomplete="on">
    <div class="sdh-field">
        <label class="sdh-label" for="user_name">Benutzername oder E-Mail</label>
        <input
            class="sdh-input"
            type="text"
            name="user_name"
            id="user_name"
            value="<?= htmlspecialchars($_SESSION['person_data']['email'] ?? '') ?>"
            placeholder="Benutzername oder E-Mail"
        >
    </div>
    <div class="sdh-field">
        <label class="sdh-label" for="password">Passwort</label>
        <input class="sdh-input" type="password" name="password" id="password" autocomplete="current-password">
    </div>
    <div class="sdh-actions">
        <button class="sdh-btn sdh-btn--primary" type="submit" name="submit" value="login">Login</button>
    </div>
</form>
<p class="sdh-form-footer">
    Noch kein Konto?
    <a href="<?= BASE_URL ?>/pages/registeren.php">Registrieren</a>
</p>
