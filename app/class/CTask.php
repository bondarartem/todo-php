<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT']."/app/class/CDB.php");

class CTask
{

    private $db;
    private $author_id;

    public function __construct($sharelink = false)
    {
        $this->db = new CDB();
        $this->author_id = $_SESSION['session_id'];

        if ($sharelink) {
            $sFields = "id, username";
            $sWhere = "sharelink = $sharelink";

            $arResults = $this->db->select("user", $sFields, $sWhere);
        }
    }
    // метод возвращает задачи в зависимости от статуса
    // status (0 - все задачи, 1 - невыполненные, 2 - выполненные)
    public function getTasks($status = 0) {

        $sFields = "id, text, is_done, is_active";

        $sWhere = "author_id = $this->author_id";

        if ($status == 1)
            $sWhere .= " AND is_done = 0";
        elseif ($status == 2)
            $sWhere .= " AND is_done = 1";

        $arResults = $this->db->select("task", $sFields, $sWhere);

        if (!empty($arResults))
            return $arResults;
        else
            throw new Exception('query return empty value', 500);
    }

    // метод возвращает кол-во незавершенных задач
    public function getCountLeftTasks() {
        $sFields = "COUNT(*)";

        $sWhere = "author_id = $this->author_id AND is_done = 0 AND is_active = 1";

        $arResults = $this->db->select("task", $sFields, $sWhere);

        if (!empty($arResults))
            return $arResults;
        else
            throw new Exception('query return empty value', 500);
    }

    public function deleteTask($id) {
        if (!empty($id) && $id > 0) {
            if ($this->db->update($id,"is_active", "0", 'task'))
                return true;
            else
                throw new Exception('db error', 500);
        }else
            throw new Exception('id incorrect', 500);
    }

    public function deleteActive() {
        if (!empty($this->author_id) && $this->author_id > 0) {
            if ($res = $this->db->updateWithWhere("is_active", 0, "author_id = $this->author_id AND is_done = 1", "task"))
                return $res;
            else
                throw new Exception('error', 500);
        }else
            throw new Exception('id incorrect', 500);
    }

    public function completeAll($complete = false) {
        if ($complete)
            $res = 1;
        else
            $res = 0;
        if (!empty($this->author_id) && $this->author_id > 0) {
            if ($res = $this->db->updateWithWhere("is_done", $res, "author_id = $this->author_id", "task"))
                return $res;
            else
                throw new Exception('db error', 500);
        }else
            throw new Exception('author_id incorrect', 500);
    }

    public function completeTask($id, $status = "1") {
        if (!empty($id) && $id > 0) {
            if ($this->db->update($id,"is_done", $status, "task"))
                return true;
            else
                throw new Exception('db error', 500);
        }else
            throw new Exception('id incorrect', 500);
    }

    public function createTask($text) {
        if (empty($text))
            $text = "";

        if ($id = $this->db->insert("task","text, author_id","'$text', $this->author_id"))
            return $id;
        else
            throw new Exception('db error', 500);
    }

    public function editTask($id, $text) {
        if (!empty($id) && $id > 0) {
            if ($this->db->update($id,"text", $text,"task"))
                return true;
            else
                throw new Exception('db error', 500);
        } else
            throw new Exception('id incorrect', 500);

    }

    public function getDetail($id) {
        $sFields = "id, text, is_done, is_active";

        $sWhere = "author_id = $this->author_id AND id = $id";

        $arResults = $this->db->select("task", $sFields, $sWhere);

        if (!empty($arResults))
            return $arResults;
        else
            throw new Exception('query return empty value', 500);
    }
}