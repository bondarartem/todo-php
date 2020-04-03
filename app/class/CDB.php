<?php


class CDB
{
    private $db;
    private $db_name = 'todo';

    function __construct()
    {
        $this->db = new mysqli('localhost', 'root', 'root', 'db');
    }

    function delete_by_id($id){
        $sql = "DELETE FROM $this->db_name WHERE id = $id";
        $result = $this->db->query($sql) or die("error");

        if ($result) {
            return true;
        }
    }

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