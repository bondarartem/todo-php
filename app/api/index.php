<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/app/class/API/Task.php");

$path = explode("/", $_SERVER['REQUEST_URI']);

try {
    if ($path[2] == 'api') {
        if ($path[3] == 'task') {
            $api = new Task();
            $action = $path[4];

            switch ($action) {
                case "all":
                case "active":
                case "completed":
                case "get_count":
                    $res = $api->show($action);
                    echo json_encode($res, JSON_UNESCAPED_UNICODE);
                    break;
                case "complete":
                case "uncomplete":
                    $task_id = $_POST['task_id'];
                    if ($task_id && $task_id > 0)
                        $res = $api->update($task_id, $action);
                    else
                        throw new Exception("id incorrect", 500);
                    echo json_encode($res, JSON_UNESCAPED_UNICODE);;
                break;
                case "complete_all":
                case "uncomplete_all":
                    $res = $api->update(0, $action);
                    echo $res;
                break;
                case "create":
                case "edit":
                    $task_id = $_POST['task_id'];
                    $text = $_POST['text'];
                    if (!empty($text)) {
                        if (preg_match("/'\"\\/{}<>,*&#~@/", $text))
                            throw new Exception("Text contains forbidden symbols");

                        if (!empty($task_id) && $task_id > 0)
                            $res = $api->update($task_id, $action, "'$text'");
                        else
                            $res = $api->insert($text, $action);
                    }
                    else
                        throw new Exception("text empty", 500);

                    echo json_encode($res, JSON_UNESCAPED_UNICODE);
                break;
                case "delete":
                case "delete_active":
                    $task_id = $_POST['task_id'];

                    if ($task_id && $task_id > 0 && $action == "delete")
                        $res = $api->delete($action, $task_id);
                    elseif ($action == 'delete_active')
                        $res = $api->delete($action);

                    echo json_encode($res, JSON_UNESCAPED_UNICODE);
                break;
                default:
                    throw new Exception("Invalid API method (Task)", 500);
            }
        }
    }
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
