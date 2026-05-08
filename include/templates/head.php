<?php
function get_file_name(){
    return ucfirst(basename($_SERVER['SCRIPT_NAME'], '.php'));
}
$title = get_file_name();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?=$title?></title>
	<link rel = "stylesheet" href = "<?= BASE_URL ?>/css/style.css">
</head>