<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/app/class/CDB.php');

class CUser
{
    private $db;

    public function __construct()
    {
        $this->setConnection();
    }

    private function setConnection() {
        $this->db = new CDB();
    }

    public function login($username, $password_hash) {
        $query = $this->db->db->query("SELECT * FROM user WHERE username='".$username."' AND password_hash='".$password_hash."'");
        $numRows = mysqli_num_rows($query);
        try{
            if($numRows !== 0)
            {
                while($row=mysqli_fetch_assoc($query))
                {
                    $dbUsername=$row['username'];
                    $dbPassword=$row['password_hash'];
                    $dbId = $row['id'];
                }
                if($username == $dbUsername && $password_hash == $dbPassword)
                {
                    // старое место расположения
                    //  session_start();
                    $_SESSION['session_username']=$username;
                    $_SESSION['session_id']=$dbId;
                    /* Перенаправление браузера */
                    header("Location: /");
                }
            } else {
                throw new Exception("Неправильная пара логин/пароль");
            }
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

    public function register($email, $username, $password) {
        $query = $this->db->db->query("SELECT * FROM user WHERE username='" . $username . "'");
        $numrows = mysqli_num_rows($query);

        try {
            if ($numrows == 0) {
                $sql = "INSERT INTO todo.user
  (email, username, password_hash)
	VALUES('$email', '$username', '$password')";
                $result = $this->db->db->query($sql);
                if ($result) {
                    header('Location: /auth/login.php?register=ok');
                } else {
                    throw new Exception("Произошла ошибка при регистрации!");
                }
            } else {
                throw new Exception("Этот пользователь уже занят, введите другой логин!");
            }
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }

    }
}