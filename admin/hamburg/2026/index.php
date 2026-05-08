 <?php
 /* BASE_URL/admin/hamburg/2026 */
 require_once __DIR__ ."/../../../config/bootstrap.php";
 header('Location: ' . BASE_URL . '/admin/login.php');
 $_SESSION["admin_url"] = true;// türöffner wird nur einmal freigeschaltet, wird gelöscht wenn die Admin-login erscheint
 ?>