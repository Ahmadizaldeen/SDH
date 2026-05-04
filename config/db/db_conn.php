<?php
require_once __DIR__ ."/../../include/debug.php";

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

$db = db();
/*
try {
    $stmt = $db->query("SELECT NOW()");
    $result = $stmt->fetch();
    dd($result);
} catch (Exception $e) {
    dd($e->getMessage());
}

var_dump($result);
$db = db();
var_dump($db);
*/
?>