<?php
require_once __DIR__ . "/../../config/bootstrap.php";
use Classes\Adress;

//Login-Status speichern nach erfolgreichem Login



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['skip'])) {
        header("Location: " . BASE_URL . "/pages/home.php");
        exit;
    }
    
   
    if (isset($_POST['save'])) {
        echo $_POST['strasse'];
        echo $_SESSION['login_data']["id"];
        $acc_adresse =[// wichtig für der construct.
            'strasse' => $_POST['strasse'],
            'haus_nr' => $_POST['haus_nr'],
            'plz' => $_POST['plz'],
            'stadt' => $_POST['stadt'],
            'user_id' => $_SESSION['login_data']["id"]
        ];
        $adress = new Adress($acc_adresse);
        $adress->insert();
        $_SESSION['login_data']['adresse'] = $adress->getAdresseByUserID($_SESSION['login_data']['id']);

        header("Location: " . BASE_URL . "/pages/home.php");
        exit;
    }
}


