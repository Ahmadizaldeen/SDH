<?php
require_once __DIR__ . '/../../config/bootstrap.php';
require_once __DIR__ . '/../funktionen/admin_login.php';
$admin_page_title = $admin_page_title ?? 'Admin';
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDH Admin – <?= htmlspecialchars($admin_page_title) ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/admin/css/admin.css">
</head>