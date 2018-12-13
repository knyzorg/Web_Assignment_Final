<?php 
require("Task.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $task = new Task((int) $_POST['id']);
   $task->setStatus((int) $_POST['status']);
   $task->setDescription($_POST['description']);
   $task->setTitle($_POST['title']);
   $task->save();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Manage Tasks</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                
    <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modal-new">Add New Task</button>
            </div>
        </div>
        <div class="row">
            <?php
            require("./statusBadge.php");
            $data = file_get_contents("./List/Tasks.json");
            $tasks = json_decode($data);
            foreach ($tasks as $task) {
                ?>
            <div class="col-md-6 col-sm-12">
                <div class="jumbotron">
                    <h2>
                        <?= status_to_badge($task->status) ?>
                        <?= $task->title ?>
                    </h2>
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>Created On</th>
                            <td>
                                <?= date('Y-m-d H:i:s', $task->dateCreated) ?>
                            </td>
                        </tr>
                        <?php
                        if ($task->dateCreated != $task->dateUpdated) {
                            ?>
                        <tr>
                            <th>Updated On</th>
                            <td>
                                <?= date('Y-m-d H:i:s', $task->dateUpdated) ?>
                            </td>
                        </tr>
                        <?php

                    }
                    ?>
                        <tr>
                            <th>Description</th>
                            <td>
                                <?= $task->description ?>
                            </td>
                        </tr>
                    </table>

                    <button class="btn btn-primary" data-toggle="modal" data-target="#modal-<?= $task->id ?>">Edit</button>
                </div>
            </div>

            <div class="modal fade" id="modal-<?= $task->id ?>" tabindex="-1" role="dialog" aria-labelledby="modal-<?= $task->id ?>Label"
                aria-hidden="true">

                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-<?= $task->id ?>Label">Update Task</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Title:</label>
                                    <input type="text" name="title" value="<?= $task->title ?>" placeholder="Title"
                                        class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Description:</label>
                                    <input type="text" name="description" value="<?= $task->description ?>" placeholder="Description"
                                        class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Status:</label>
                                    <select name="status" id="" class="form-control">
                                        <?php
                                            foreach ($statuses as $key => $value) {
                                                ?>
                                                    <option value="<?= $key + 1?>" <?= $key+1 == $task->status ? "selected" : "" ?>><?= $value ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>

                                <input type="hidden" name="id" value="<?= $task->id ?>">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php

        }
        ?>
        </div>
    </div>


    <div class="modal fade" id="modal-new" tabindex="-1" role="dialog" aria-labelledby="modal-newLabel"
                aria-hidden="true">

                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-newLabel">Create new Task</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Title:</label>
                                    <input type="text" name="title"  placeholder="Title"
                                        class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Description:</label>
                                    <input type="text" name="description" placeholder="Description"
                                        class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Status:</label>
                                    <select name="status" id="" class="form-control">
                                        <?php
                                            foreach ($statuses as $key => $value) {
                                                ?>
                                                    <option value="<?= $key + 1?>"><?= $value ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="-1">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>

</html>