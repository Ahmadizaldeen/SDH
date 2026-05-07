<?php
require_once __DIR__ . "/../funktionen/adresse.php";
require_once __DIR__ . "/navigation.php";
?>
<form class="sdh-form" action="" method="post" autocomplete="street-address">
    <div class="sdh-field">
        <label class="sdh-label" for="strasse">Straße</label>
        <input class="sdh-input" type="text" name="strasse" id="strasse" required>
    </div>
    <div class="sdh-field">
        <label class="sdh-label" for="haus_nr">Hausnummer</label>
        <input class="sdh-input" type="text" name="haus_nr" id="haus_nr" required>
    </div>
    <div class="sdh-field">
        <label class="sdh-label" for="plz">PLZ</label>
        <input class="sdh-input" type="text" name="plz" id="plz" required inputmode="numeric">
    </div>
    <div class="sdh-field">
        <label class="sdh-label" for="stadt">Stadt</label>
        <input class="sdh-input" type="text" name="stadt" id="stadt" required>
    </div>
    <div class="sdh-actions sdh-actions--stack">
        <button class="sdh-btn sdh-btn--success" type="submit" name="save" value="1">Adresse speichern</button>
        <button class="sdh-btn sdh-btn--muted" type="submit" name="skip" value="1">Überspringen</button>
    </div>
</form>
