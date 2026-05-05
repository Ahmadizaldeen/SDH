<?php
require_once __DIR__ ."/../funktionen/adresse.php";
?>
<form action="" method="post">
    
    <label for="strasse">Straße:</label>
    <input type="text" name="strasse" id="strasse"><br>

    <label for="haus_nr">Haus Nr.:</label>
    <input type="text" name="haus_nr" id="haus_nr"><br>

    <label for="plz">PLZ:</label>
    <input type="text" name="plz" id="plz"><br>

    <label for="stadt">Stadt:</label>
    <input type="text" name="stadt" id="stadt"><br>

    <button type="submit" name="save">Speichern</button>

    <!-- Skip -->
    <button type="submit" name="skip">Überspringen</button>

</form>
<?php
#var_dump( $_SESSION['login_data']['adresse']['id']);
?>