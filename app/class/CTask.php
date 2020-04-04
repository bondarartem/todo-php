<?php

require_once($_SERVER['DOCUMENT_ROOT']."/app/class/CDB.php");

class CTask
{

    public function getTasks($author_id = 1) {
        $db = new CDB();

        $sFields = "id, text, is_done, is_active";

        $sWhere = "author_id = $author_id";

        $arResults = $db->select("task", $sFields, $sWhere);

        return !empty($arResults) ? $arResults : false;
    }
}