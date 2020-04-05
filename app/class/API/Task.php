<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/app/class/CTask.php");

class Task
{

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

    public function update($id, $action, $text="")
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
        }

        return $result;
    }

    public function delete($action, $task_id = 0, $author_id = 1)
    {
        switch ($action) {
            case "delete":
                $result = $this->deleteById($task_id);
                break;
            case "delete_active":
                $result = $this->deleteActive($author_id);
                break;
        }

        return $result;
    }

    public function insert($text, $action, $author_id = 0)
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
        $task = new CTask();

        return $task->getTasks();

    }

    private function showActive()
    {
        $task = new CTask();

        return $task->getTasks(1);
    }

    private function showCompleted()
    {
        $task = new CTask();

        return $task->getTasks(2);
    }

    private function getCount()
    {
        $task = new CTask();

        return $task->getCountLeftTasks();
    }


    private function completeStatus($id)
    {
        $task = new CTask();

        return $task->completeTask($id);
    }

    private function uncompleteStatus($id)
    {
        $task = new CTask();

        return $task->completeTask($id, "0");
    }

    private function createTask($text, $author_id = 0)
    {
        $task = new CTask();

        return $task->createTask($text, $author_id);
    }


    private function deleteById($id)
    {
        $task = new CTask();

        return $task->deleteTask($id);
    }

    private function deleteActive($author_id = 1)
    {
        $task = new CTask();

        return $task->deleteActive($author_id);
    }

    private function editTask($task_id, $text, $author_id = 1) {
        $task = new CTask();

        return $task->editTask($task_id, $text, $author_id);
    }
}