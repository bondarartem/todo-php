<?php

session_start();
if(isset($_SESSION["session_username"]) && isset($_SESSION["session_id"])){
    // вывод "Session is set"; // в целях проверки
    header("Location: /");
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/app/class/CDB.php');

$db = new CDB();


if (isset($_POST["register"])) {

    if (!empty($_POST['email']) && !empty($_POST['username']) && !empty($_POST['password'])) {
        $email = htmlspecialchars($_POST['email']);
        $username = htmlspecialchars($_POST['username']);
        $password = md5(htmlspecialchars($_POST['password']));
        $query = $db->db->query("SELECT * FROM user WHERE username='" . $username . "'");
        $numrows = mysqli_num_rows($query);
        if ($numrows == 0) {
            $sql = "INSERT INTO user
  (email, username, password_hash)
	VALUES('$email', '$username', '$password')";
            $result = $db->db->query($sql);
            if ($result) {
                $message = "Вы успешно зарегестрированы";
            } else {
                $message = "Произошла ошибка при регистрации!";
            }
        } else {
            $message = "Этот пользователь уже занят, введите другой логин!";
        }
    } else {
        $message = "Все поля обязательны к заполнению";
    }
}
?>

<?php if (!empty($message)) {
    echo "<p class='error'>" . $message . "</p>";} ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title> Регистрация</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'
          rel='stylesheet' type='text/css'>
</head>
<body>
<div class="container mregister">
    <div id="login">
        <h1>Регистрация</h1>
        <form action="register.php" id="registerform" method="post" name="registerform">
            <p><label for="user_pass">E-mail<br>
                    <input class="input" id="email" name="email" size="32" type="email" value=""></label></p>
            <p><label for="user_pass">Логин<br>
                    <input class="input" id="username" name="username" size="20" type="text" value=""></label></p>
            <p><label for="user_pass">Пароль<br>
                    <input class="input" id="password" name="password" size="32" type="password" value=""></label></p>
            <p class="submit"><input class="button" id="register" name="register" type="submit"
                                     value="Зарегистрироваться"></p>
            <p class="regtext">Уже зарегистрированы? <a href="login.php">Введите имя пользователя</a></p>
        </form>
    </div>
</div>
</body>
</html>