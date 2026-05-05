<?php
require_once __DIR__ . "/../../config/base_url.php";
require_once __DIR__ . "/../../include/funktionen/validation.php";
require_once __DIR__ . "/../../classes/Adress.php";

function login(PDO $db)
{
    // POST prüfen + validiern -> DB abfrage -> verifizieren -> Session setzen -> redirect
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return;
    }

    $email = clean_input($_POST['email'] ?? '');
    $user_name = clean_input($_POST['user_name'] ?? '');
    $password = clean_input($_POST['password'] ?? '');

    if ((!$email && !$user_name) || !$password) {// anmeldung erfolgt mit email oder username.
        $_SESSION['msg']['error'][] = "Alle Felder ausfüllen";
        return;
    }
   
    $stmt = $db->prepare("
        SELECT * FROM users 
        WHERE email = :id OR user_name = :id
    ");

    $identifier = $email ?: $user_name;//prüft auf "leer / false / 0 /null"
    $stmt->execute(['id' => $identifier]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);// Userdaten aus DB als assiziative Array

    if (!$user) {
        $_SESSION['msg']['error'][] = "User not found";
        return false;
    }
    if (!password_verify($password, $user['password'])) {
        $_SESSION['msg']['error'][] = "Password falsch";
        return false;
    }
    
    $_SESSION['login_data'] = [
    'id' => $user['id'],
    'vorname' => $user['vorname'],
    'nachname' => $user['nachname'],
    'email' => $user['email'],
    'user_name' => $user['user_name'],
    'alias' => $user['alias'],
    'eingelogt' => true
    ];

    $_SESSION['msg']['done']['eingelogt'] = "Login erfolgreich!";
    #header("Location: " . BASE_URL . "/pages/home.php");
    $_SESSION['login_data']['adresse'] = Adress::getAdresseByUserID($db,$_SESSION['login_data']['id']);
    #dd($adress);
    if (!$_SESSION['login_data']['adresse']['id']) {

        header("Location: " . BASE_URL . "/include/templates/adresse_form.php");
       
    }
    else {
        header("Location: " . BASE_URL . "/pages/home.php");
        
    }

    return $user;
    
}
$reg_msg= ($_SESSION['msg']['done']['register_msg']) ?? '';
if(isset($_SESSION['msg']['done']['register_msg']))
    ok_msg($reg_msg);
#$user = login( $db );

?>


