<?php

require_once($_SERVER['DOCUMENT_ROOT']."/app/class/CDB.php");

class CTask
{

    // метод возвращает задачи в зависимости от статуса
    // status (0 - все задачи, 1 - невыполненные, 2 - выполненные)
    public function getTasks($status = 0, $author_id = 1) {
        $db = new CDB();

        $sFields = "id, text, is_done, is_active";

        $sWhere = "author_id = $author_id";

        if ($status == 1)
            $sWhere .= " AND is_done = 0";
        elseif ($status == 2)
            $sWhere .= " AND is_done = 1";

        $arResults = $db->select("task", $sFields, $sWhere);

        return !empty($arResults) ? $arResults : false;
    }

    public function deleteTask($id) {
        $db = new CDB();

        if (!empty($id) && $id > 0) {
            if ($db->update($id,"is_active", "0"))
                return true;
            else
                return false;
        }
    }

    public function completeTask($id) {
        $db = new CDB();

        if (!empty($id) && $id > 0) {
            if ($db->update($id,"is_done", "1"))
                return true;
            else
                return false;
        }
    }

    public function editTask($id, $text) {
        $db = new CDB();

        if (!empty($id) && $id > 0) {
            if ($db->update($id,"text", $text))
                return true;
            else
                return false;
        }
    }
}