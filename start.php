<?php
require_once __DIR__ . "/config/base_url.php";
require_once __DIR__ . "/config/chk_session.php";
require_once __DIR__ . "/include/templates/navigation.php";
#require_once __DIR__ . "/classes/Person.php";
require_once __DIR__ . "/config/db/db_conn.php";
require_once __DIR__ . "/include/debug.php";
require_once __DIR__ . "/include/funktionen/msg.php";


/*$url = BASE_URL . "/login.php";
        header("Location: $url");
        exit;*/
/*$person_data = $_SESSION['person_data'];

$person = new Person($db,$person_data);
#$person->setAlias("SuperUser");
#$_SESSION['person_data']['alias'] = $person->getAlias();
#$person->setPhone("123-456-789");
$_SESSION['person_data']['phone'] = $person->getPhone();
$person->insert();
$person->setUserName();
$_SESSION['person_data']['user_name'] = $person->getUserName();
#echo $person->getVorname();
#print_r( $person->getAttributes());

#echo ("<br> ID aus DB:". $person->getIDbyEmail($person->getEmail()));
#dd($person->getAttributes());
#dd($_SESSION);
#dd($person);
#dd(msg());



#unset($_SESSION['person_data']['plz']);
*/
echo "<h1>Start.php</h1><br><hr>";
#msg();
#dd($_SESSION);
?>