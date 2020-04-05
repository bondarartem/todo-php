<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/app/class/API/Task.php");

$path = explode("/", $_SERVER['REQUEST_URI']);

try {
    if ($path[2] == 'api') {
        if ($path[3] == 'task') {
            $api = new Task();
            if (in_array($path[4], array("all", "active", "completed", "get_count"))) {
                $res = $api->show($path[4]);
                echo json_encode($res, JSON_UNESCAPED_UNICODE);
            } elseif (in_array($path[4], array("complete", "uncomplete"))) {
                $task_id = $_POST['task_id'];

                if ($task_id && $task_id > 0)
                    $res = $api->update($task_id, $path[4]);
                else
                    throw new Exception("id incorrect", 500);

                echo $res;
            } elseif (in_array($path[4], array("complete_all", "uncomplete_all"))) {
                $res = $api->update(0, $path[4]);
                echo $res;
            }elseif (in_array($path[4], array("create", "edit"))) {
                $task_id = $_POST['task_id'];
                $text = $_POST['text'];

                if (!empty($text))
                    if (!empty($task_id) && $task_id > 0)
                        $res = $api->update($task_id, $path[4], "'$text'");
                    else
                        $res = $api->insert($text, $path[4]);
                else
                    throw new Exception("text empty", 500);
            } elseif (in_array($path[4], array("delete", "delete_active"))) {
                $task_id = $_POST['task_id'];

                if ($task_id && $task_id > 0 && $path[4] == "delete")
                    $res = $api->delete($path[4], $task_id);
                elseif ($path[4] == 'delete_active')
                    $res = $api->delete($path[4]);

                echo $res;
            }
        }
    }
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
