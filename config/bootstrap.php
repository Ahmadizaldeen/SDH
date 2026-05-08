<?php
//Session starten
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//BASE_URL
$_scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http';

$_root = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '/');

$_dir = str_replace('\\', '/', dirname(__DIR__));

define('BASE_URL', $_scheme . '://' . $_SERVER['HTTP_HOST'] . str_replace($_root, '', $_dir));

unset($_scheme, $_root, $_dir);


spl_autoload_register('autoloader'); // regitriert die Funktion als Autoloader Funktion.


function autoloader(string $class) # $new wird von PHP übergeben (Klasse die instanziert wird)
{   
    $path = __DIR__ . "/../" . str_replace("\\", "/", $class) . ".php";
    if (file_exists($path)) {
        require_once $path;
        return;
    }
	
    else {
        echo "No class file found for ' $class '<br>";
    }
}

function dd($data) { //dump and die
    echo "dump und die: <pre>";
    
    if (empty($data)) {
        echo gettype($data) ." ist leer.";
        exit;
    }
    else{
        print_r($data);    
        #var_dump($data);
        exit;
    }
}

function db(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sdh";

    try {
        $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8mb4";
        $db = new PDO($dsn, $username, $password);

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $db;
    } 
    catch (PDOException $e) {
        die($e->getMessage());
    }
}

function msg()
{
    if (!empty($_SESSION['msg']['error'])) {
		foreach($_SESSION['msg']['error'] AS $e)
			echo "<p style='color: red;'>" . $e . "</p>";
        unset ($_SESSION['msg']['error']) ;
    }

    if (!empty($_SESSION['msg']['done'])) {
		foreach($_SESSION['msg']['done'] AS $done)
        echo "<p style='color: green;'>" . $done . "</p>";
        unset ($_SESSION['msg']['done']) ;
		
    }
}

function error_msg($msg){
    echo "<p style='color: red;'>" . $msg . "</p>";

}
function ok_msg($msg){
    echo "<p style='color: green;'>" . $msg . "</p>";

}



?>