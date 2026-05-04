<?php
require_once __DIR__ . "/../../config/chk_session.php";
require_once __DIR__ . "/../../config/base_url.php";
?>
<form action="" method ="post">
	<label for="user_name">user name oder E-Mail</label>
	<input type= "text" name ="user_name" id ="email" value="<?=($_SESSION['person_data']['email']?? '') ?>" placeholder="user name oder Email">
	<label for="password">password</label>
	<input type= "password" name ="password" id ="password" >
    <button type = "submit" value ="login" name = "submit"> Login </button>
    
</form>
<span > Don't have an account? <a href ="<?= BASE_URL ?>/include/templates/register.php">>Sign up</a></span>
