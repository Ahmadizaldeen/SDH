<?php
require_once __DIR__."/../../config/base_url.php";
require_once __DIR__."/validation.php";
require_once __DIR__ ."/../../classes/Person.php";

function handleRegisterRequest(){

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return;
    }

        
    $vorname = valid_name($_POST["vorname"]);
    $nachname = valid_name($_POST["nachname"]);
    $password = valid_password($_POST["password"], $_POST["confirm_password"]);
    $email= valid_email($_POST["email"]);
    if (!$vorname || !$nachname || !$email || !$password) {
        msg();
        return;
    }
    if(isset($_POST["phone"])){
        $phone = clean_input($_POST["phone"]);
        $_SESSION['person_data']['phone'] =$phone;
    }
    if(isset($_POST["alias"])){
        $alias = clean_input($_POST["alias"]);
        $_SESSION['person_data']['alias'] =$alias;
    }
    $_SESSION['person_data']['vorname'] = $vorname;
    $_SESSION['person_data']['nachname'] = $nachname;
    $_SESSION['person_data']['email'] = $email;
    $password = password_hash($password, PASSWORD_DEFAULT);
    $_SESSION['person_data']['password'] = $password;

    #dd($db);
    $db = db();
    $person_data = $_SESSION['person_data'];
    #dd($person_data);
    $person = new Person($db,$person_data);
    $person->setUserName();
    #$_SESSION['person_data']['user_name']
    #$_SESSION['person_data']['user_name'] =$person->getUserName();

    $url = BASE_URL . "/pages/login.php";
    header("Location: $url");
    $_SESSION['msg']['done']['register_msg'] = "Registrierung erfolgreich! Willkommen ". ($alias ? $alias : $vorname) . "!,<br>" ;
    exit;
}
handleRegisterRequest();	
?>