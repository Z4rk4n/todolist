<?php 

include("app/Kernel.php");
include("app/TodoListSqlManager.php");

$config = require "app/config/config.php";

$kernel = new Kernel($config);
$kernel->init();

$todoListSqlManager = new TodoListSqlManager(pdo: $kernel->getPdo());

if (isset($_GET["action"])) {
    $action = $_GET["action"];
    if ($action == "delete" && !empty($_GET["task_id"])) {
        echo json_encode(deleteTask($_GET["task_id"], $todoListSqlManager));
    }
}


// functions


function deleteTask($id, $todoListSqlManager){

    $status = $todoListSqlManager->deleteTask($id);
    return [$status];
}