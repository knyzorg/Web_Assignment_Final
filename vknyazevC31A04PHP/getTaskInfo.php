<?php
    header("Content-type:application/json");
    $status = -1;
    $status = isset($_GET['status']) ?  $_GET['status'] : $status;
    $status = isset($_POST['status']) ?  $_POST['status'] : $status;
    $data = file_get_contents("./List/Tasks.json");
    $tasks = json_decode($data);
    echo json_encode(array_values(array_filter($tasks, function ($task) {
        global $status;
        unset($task->dateCreated);
        unset($task->description);
        return $task->status == $status || $status == 5;
    })));