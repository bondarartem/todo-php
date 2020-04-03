<?php


class CDB
{
    private $db;
    private $db_name = 'todo';
    private $db_user = 'root';
    private $db_password = 'root';

    // Инициализируем подключение к бд
    function __construct(){
        $this->db = new mysqli('localhost', $this->db_user, $this->db_password, $this->db_name);
    }

    // simple select with fetch
    function select($sTable, $sFields, $sWhere) {
        $arResult = array();

        $sql = "SELECT $sFields
                FROM $sTable
                WHERE $sWhere";

        $dbResult = $this->db->query($sql) or die("error");

        while ($row = mysqli_fetch_row($dbResult)) {
            $arResult[] = $row;
        }

        return !empty($arResult) ? $arResult : false;
    }

    // delete by id
    function delete($id){
        $sql = "DELETE FROM $this->db_name WHERE id = $id";
        $result = $this->db->query($sql) or die("error");

        if ($result) {
            return true;
        }
    }

    // update by id
    function update($id, $field, $value) {
        $sql = "UPDATE $this->db_name
                SET $field = $value
                WHERE id = $id";

        $result = $this->db->query($sql) or die("error");

        if ($result) {
            return true;
        }
    }
}