<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/app/class/CDB.php');
$db = new CDB();


if(isset($_SESSION["session_username"]) && isset($_SESSION["session_id"])){
    // вывод "Session is set"; // в целях проверки
    header("Location: /");
}


if(isset($_POST["login"])){

    if(!empty($_POST['username']) && !empty($_POST['password'])) {
        $username=htmlspecialchars($_POST['username']);
        $password=md5(htmlspecialchars($_POST['password']));
        $query = $db->db->query("SELECT * FROM user WHERE username='".$username."' AND password_hash='".$password."'");
        $numrows=mysqli_num_rows($query);
        if($numrows!=0)
        {
            while($row=mysqli_fetch_assoc($query))
            {
                $dbUsername=$row['username'];
                $dbPassword=$row['password_hash'];
                $dbId = $row['id'];
            }
            if($username == $dbUsername && $password == $dbPassword)
            {
                // старое место расположения
                //  session_start();
                $_SESSION['session_username']=$username;
                $_SESSION['session_id']=$dbId;
                /* Перенаправление браузера */
                header("Location: /");
            }
        } else {
            $message =  "Неправильная пара логин/пароль";
        }
    } else {
        $message = "Все поля должны быть заполнены!";
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
<div class="container mlogin">
    <div id="login">
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
</div>
</body>
</html>