<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/template/header.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/app/class/CUser.php');

if(isset($_SESSION["session_username"]) && isset($_SESSION["session_id"])){
    // вывод "Session is set"; // в целях проверки
    header("Location: /");
}


if(isset($_POST["login"])){
    try {

        $user = new CUser();

        $username = $_POST['username'];
        $password = $_POST['password'];

        if(!empty($username) && !empty($password)) {
            $user->login($username,md5($password));
        } else {
            throw new Exception("Все поля должны быть заполнены!");
        }
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title> Авторизация</title>
    <link href= 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
</head>
<body>
    <div id="login">
        <?php
        if ($_GET['register']=='ok'){?>
            <p style="color: green">Вы успешно зарегистрированы</p>
        <?php }?>
        <h1>Вход</h1>
        <form action="" id="loginform" method="post"name="loginform">
            <p><label for="user_login">Имя пользователя<br>
                    <input class="input" id="username" name="username"size="20"
                           type="text" value=""></label></p>
            <p><label for="user_pass">Пароль<br>
                    <input class="input" id="password" name="password"size="20"
                           type="password" value=""></label></p>
            <p class="submit"><input class="button" name="login"type= "submit" value="Log In"></p>
            <p class="regtext">Еще не зарегистрированы? <a href= "register.php">Регистрация</a></p>
        </form>
    </div>
</body>
</html>