<?php require_once __DIR__ . "/../../config/bootstrap.php"; ?>
<form class="sdh-form" action="" method="post" autocomplete="on">
    <div class="sdh-field">
        <label class="sdh-label" for="vorname">Vorname</label>
        <input class="sdh-input" type="text" name="vorname" id="vorname" placeholder="Pflichtfeld *">
    </div>
    <div class="sdh-field">
        <label class="sdh-label" for="nachname">Nachname</label>
        <input class="sdh-input" type="text" name="nachname" id="nachname" placeholder="Pflichtfeld *">
    </div>
    <div class="sdh-field">
        <label class="sdh-label" for="email">E-Mail</label>
        <input class="sdh-input" type="email" name="email" id="email" placeholder="Pflichtfeld *" autocomplete="email">
    </div>
    <div class="sdh-field">
        <label class="sdh-label" for="phone">Telefon</label>
        <input class="sdh-input" type="text" name="phone" id="phone" placeholder="Optional">
    </div>
    <div class="sdh-field">
        <label class="sdh-label" for="alias">Alias</label>
        <input class="sdh-input" type="text" name="alias" id="alias" placeholder="Öffentlicher Name, optional">
    </div>
    <div class="sdh-field">
        <label class="sdh-label" for="password">Passwort</label>
        <input class="sdh-input" type="password" name="password" id="password" placeholder="Pflichtfeld *" autocomplete="new-password">
    </div>
    <div class="sdh-field">
        <label class="sdh-label" for="confirm_password">Passwort bestätigen</label>
        <input class="sdh-input" type="password" name="confirm_password" id="confirm_password" placeholder="Pflichtfeld *" autocomplete="new-password">
    </div>
    <p class="sdh-form-hint">Alle mit * gekennzeichneten Felder sind Pflichtfelder.</p>
    <div class="sdh-actions">
        <button class="sdh-btn sdh-btn--success" type="submit" name="submit" value="submit">Registrieren</button>
    </div>
</form>
<p class="sdh-form-footer">
    Bereits registriert?
    <a href="<?= BASE_URL ?>/pages/login.php">Zum Login</a>
</p>
<footer><?php require_once __DIR__."/footer_navi.php"?></footer>

