<?php
session_start();
if(isset($_SESSION["session_username"]) && isset($_SESSION["session_id"])){
    // вывод "Session is set"; // в целях проверки
    header("Location: /");
}
