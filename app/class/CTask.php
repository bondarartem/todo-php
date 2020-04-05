<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT']."/app/class/CDB.php");

class CTask
{

    private $author_id;

    public function __construct($sharelink = false)
    {
        $this->author_id = $_SESSION['session_id'];

        if ($sharelink) {
            $db = new CDB();

            $sFields = "id, username";
            $sWhere = "sharelink = $sharelink";

            $arResults = $db->select("user", $sFields, $sWhere);
        }
    }
    // метод возвращает задачи в зависимости от статуса
    // status (0 - все задачи, 1 - невыполненные, 2 - выполненные)
    public function getTasks($status = 0) {
        $db = new CDB();

        $sFields = "id, text, is_done, is_active";

        $sWhere = "author_id = $this->author_id";

        if ($status == 1)
            $sWhere .= " AND is_done = 0";
        elseif ($status == 2)
            $sWhere .= " AND is_done = 1";

        $arResults = $db->select("task", $sFields, $sWhere);

        if (!empty($arResults))
            return $arResults;
        else
            return "0";
    }

    // метод возвращает кол-во незавершенных задач
    public function getCountLeftTasks() {
        $db = new CDB();

        $sFields = "COUNT(*)";

        $sWhere = "author_id = $this->author_id AND is_done = 0";

        $arResults = $db->select("task", $sFields, $sWhere);

        if (!empty($arResults))
            return $arResults;
        else
            return "0";
    }

    public function deleteTask($id) {
        $db = new CDB();

        if (!empty($id) && $id > 0) {
            if ($db->update($id,"is_active", "0"))
                return true;
            else
                throw new Exception('error', 500);
        }else
            throw new Exception('id incorrect', 500);
    }

    public function deleteActive() {
        $db = new CDB();
        if (!empty($this->author_id) && $this->author_id > 0) {
            if ($res = $db->updateWithWhere("is_active", 0, "author_id = $this->author_id AND is_done = 1", "task"))
                return $res;
            else
                throw new Exception('error', 500);
        }else
            throw new Exception('id incorrect', 500);
    }

    public function completeTask($id, $status = "1") {
        $db = new CDB();

        if (!empty($id) && $id > 0) {
            if ($db->update($id,"is_done", $status, "task"))
                return true;
            else
                throw new Exception('error', 500);
        }else
            throw new Exception('id incorrect', 500);
    }

    public function createTask($text) {
        $db = new CDB();

        if (empty($text))
            $text = "";

        if ($db->insert("task","text, author_id","'$text', $this->author_id"))
            return true;
        else
            throw new Exception('error', 500);
    }

    public function editTask($id, $text) {
        $db = new CDB();

        if (!empty($id) && $id > 0) {
            if ($db->update($id,"text", $text,"task"))
                return true;
            else
                throw new Exception('error', 500);
        } else
            throw new Exception('id incorrect', 500);

    }
}