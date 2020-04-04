<?php
require_once($_SERVER['DOCUMENT_ROOT']."/app/class/CTask.php");

class Task {

    public function show($action) {
        switch ($action){
            case "all":
                $result = $this->showAll();
                break;
            case "active":
                $result =  $this->showActive();
                break;
            case "completed":
                $result =  $this->showCompleted();
                break;
        }

        return $result;
    }



    private function showAll() {
        $task = new CTask();

        return $task->getTasks();

    }

    private function showActive() {
        $task = new CTask();

        return $task->getTasks(1);
    }

    private function showCompleted() {
        $task = new CTask();

        return $task->getTasks(2);
    }
}