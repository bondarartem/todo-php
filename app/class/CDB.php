<?php


class CDB
{
    private $db;
    private $db_host = '127.0.0.1';
    private $db_name = 'todo';
    private $db_user = 'todo';
    private $db_password = 'todo';

    // Инициализируем подключение к бд
    function __construct(){
        $this->db = new mysqli($this->db_host, $this->db_user, $this->db_password, $this->db_name);

        mysqli_query($this->db,'SET NAMES utf8');
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

    function insert($sTable,$sFields, $sValues) {
        $sql = "INSERT INTO $sTable ($sFields)
                VALUES ($sValues)";

        $result = $this->db->query($sql) or die("error");

        if ($result)
            return true;
        else
            return false;
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
    function update($id, $field, $value, $table_name) {
        $sql = "UPDATE $table_name
                SET $field = $value
                WHERE id = $id";

        $result = $this->db->query($sql) or die("error");

        if ($result)
            return true;
        else
            return false;
    }

    // update with where
    function updateWithWhere($field, $value, $where, $table_name) {
        $sql = "UPDATE $table_name
                SET $field = $value
                WHERE $where";

        $result = $this->db->query($sql) or die("error");

        if ($result)
            return true;
        else
            return false;
    }

    // create
}