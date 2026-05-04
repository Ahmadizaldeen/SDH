
<?php
require_once __DIR__ ."/../../config/chk_session.php";
require_once __DIR__ ."/../../config/base_url.php";


if (!isset($_SESSION['user_data'])){ // keine direktes zugriff auf user-pages ohne Login
    
    echo "You are not logged in.";
    #header("Location:" .BASE_URL ."/pages/home.php");
    #exit();
}
?>

<?php
session_unset();
session_destroy();
#$signout_msg = "Login erfolgreich abgemeldet";
header("Location:" .BASE_URL ."/pages/home.php");
?>