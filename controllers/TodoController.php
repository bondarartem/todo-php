<?
require_once("../app/class/CTask.php");

$task = new CTask();
$res = $task->getTasks();

echo "<pre>";
print_r($res);
echo "<pre>";
die();
?>