<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sdh";

try {
    $dsn = "mysql:host=$servername;dbname=$dbname";
    $db = new PDO($dsn, $username, $password);
    // set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	$db->query("SET NAMES utf8mb4");
    #var_dump($db);
} 
catch (PDOException $e) {
    echo  $e->getMessage();
}

?>