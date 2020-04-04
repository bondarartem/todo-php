<?php
require_once($_SERVER['DOCUMENT_ROOT']."/app/class/CTask.php");

$task = new CTask();
$arResults = $task->getTasks();

?>