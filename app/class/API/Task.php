<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/app/class/CTask.php");

class Task
{
    private $task;

    public function __construct()
    {
        $this->task = new CTask();
    }

    public function show($action)
    {
        switch ($action) {
            case "all":
                $result = $this->showAll();
                break;
            case "active":
                $result = $this->showActive();
                break;
            case "completed":
                $result = $this->showCompleted();
                break;
            case "get_count":
                $result = $this->getCount();
                break;
        }

        return $result;
    }

    public function update($id, $action, $text = "")
    {
        switch ($action) {
            case "complete":
                $result = $this->completeStatus($id);
                break;
            case "uncomplete":
                $result = $this->uncompleteStatus($id);
                break;
            case "edit":
                $result = $this->editTask($id, $text);
                break;
            case "complete_all":
                $result = $this->completeAll();
                break;
            case "uncomplete_all":
                $result = $this->uncompleteAll();
        }

        return $result;
    }

    public function delete($action, $task_id = 0)
    {
        switch ($action) {
            case "delete":
                $result = $this->deleteById($task_id);
                break;
            case "delete_active":
                $result = $this->deleteActive();
                break;
        }

        return $result;
    }

    public function insert($text, $action)
    {
        switch ($action) {
            case "create":
                $result = $this->createTask($text, 1);
                break;
        }

        return $result;
    }

    private function showAll()
    {
        return $this->task->getTasks();
    }

    private function showActive()
    {
        return $this->task->getTasks(1);
    }

    private function showCompleted()
    {
        return $this->task->getTasks(2);
    }

    private function getCount()
    {
        return $this->task->getCountLeftTasks();
    }

    private function completeAll()
    {
        return $this->task->completeAll(true);
    }

    private function uncompleteAll()
    {
        return $this->task->completeAll(false);
    }

    private function completeStatus($id)
    {
        $this->task->completeTask($id);
        return $this->task->getDetail($id);
    }

    private function uncompleteStatus($id)
    {
        $this->task->completeTask($id, "0");
        return $this->task->getDetail($id);
    }

    private function createTask($text)
    {
        $id = $this->task->createTask($text);
        return $this->task->getDetail($id);
    }


    private function deleteById($id)
    {
        $this->task->deleteTask($id);
        return $this->task->getDetail($id);
    }

    private function deleteActive()
    {
        return $this->task->deleteActive();
    }

    private function editTask($task_id, $text)
    {
        $this->task->editTask($task_id, $text);
        return $this->task->getDetail($task_id);
    }
}