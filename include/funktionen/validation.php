<?php
#require_once __DIR__."/../../config/chk_session.php";
require_once __DIR__."/../../config/base_url.php";
#require_once __DIR__."/../debug.php";
#require_once __DIR__."/msg.php";



function clean_input($data){
    return htmlspecialchars(strip_tags(trim($data)));
}
function valid_name ($name){
    $name = clean_input($name);
    $name_regEx = "/^[a-zA-ZäöüÄÖÜß]{2,50}$/";
    if (preg_match($name_regEx,$name)){
        return $name;
    }
    else
    {
       $error_msg= "Name ungültig: nur Buchstaben, 2–50 Zeichen, keine Zahlen oder Sonderzeichen.";
        $_SESSION['msg']['error'][] = $error_msg;
        return false;
    }
}

function valid_password($password, $confirm_password){
    $password_regEX =  "/^[a-zA-Z0-9_]{6,10}$/";
    $password = htmlspecialchars(strip_tags($password));
    $confirm_password = htmlspecialchars(strip_tags($confirm_password));

    if($password != $confirm_password){
        $error_msg_form = "Diese Passwörter stimmen nicht überein. Versuchen Sie es noch einmal.<br>";
        $_SESSION['msg']['error'][] = $error_msg_form;
        return false;
    }
    else if (!preg_match($password_regEX,$password)){
        $error_msg_form = "Password ungültig: nur Buchstaben, Zahlen und _ erlaubt, 6–10 Zeichen, keine Leerzeichen.<br>";
        $_SESSION['msg']['error'][] = $error_msg_form;
        return false;
    }
    else {
        $password_ok = " Password Verschlüsselung gespeichert<br>";
        $_SESSION['msg']['done'][] = $password_ok;
        return $password;
    
    }
    
}
function valid_email($email){
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) ){
            $msg = "Ungültige E-Mail";
            $_SESSION['msg']['error'][] = $msg;
            return false;
    }
    else{return $email;}
    
}


?>
