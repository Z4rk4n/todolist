<?php

include("app/Kernel.php");
include("app/TodoListSqlManager.php");

$config = require "app/config/config.php";

$kernel = new Kernel($config);
$kernel->init();

$todoListSqlManager = new TodoListSqlManager(pdo: $kernel->getPdo());
var_dump($todoListSqlManager->getTasks());

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>TodoList</title>
    </head>
    <body>
        <form method="post">
            <input type="text" name="new_task_label" />
            <input type="submit" name="new_task_submit" />
        </form>
    </body>
</html>

