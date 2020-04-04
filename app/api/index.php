<?php
require_once($_SERVER['DOCUMENT_ROOT']."/app/class/API/Task.php");

$path = explode("/", $_SERVER['REQUEST_URI']);

if ($path[2] == 'api') {
    if ($path[3] == 'task' && in_array($path[4], array("all", "active", "completed"))) {
        $api = new Task();

        $res = $api->show($path[4]);
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
    }
}