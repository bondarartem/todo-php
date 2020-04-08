<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Бондарь Артём • Todo</title>
    <link rel="stylesheet" href="/node_modules/todomvc-common/base.css">
    <link rel="stylesheet" href="/node_modules/todomvc-app-css/index.css">
    <!-- CSS overrides - remove if you don't need it -->
    <link rel="stylesheet" href="/template/css/app.css">
</head>
<body>
<?php
if (isset($_SESSION['session_username'])):?>
<div class="logout"><a href="auth/logout.php">Logout (<?=$_SESSION['session_username']?>)</a></div>
<?php endif;?>

<section class="todoapp">