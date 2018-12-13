<?php
    header("Content-type:application/json");
    
    require("Task.php");
    $id = -1;
    $id = isset($_GET['id']) ?  $_GET['id'] : $id;
    $id = isset($_POST['id']) ?  $_POST['id'] : $id;

    if ($id < 0) {
        die('{"status": 0}');
    }
    $task = new Task((int) $id);
    if ($task->getId() == null) {
        // 404
        die('{"status": 0}');
    }

    echo json_encode($task->getAll());