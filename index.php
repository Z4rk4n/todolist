<?php

include("app/Kernel.php");
include("app/TodoListSqlManager.php");

$config = require "app/config/config.php";

$kernel = new Kernel($config);
$kernel->init();

$todoListSqlManager = new TodoListSqlManager(pdo: $kernel->getPdo());

if (
    isset($_POST["new_task_submit"]) 
    && isset($_POST["new_task_label"]) 
    && !empty($_POST["new_task_label"])
    ) {
        $newTaskLabel = $_POST["new_task_label"];
        $todoListSqlManager->createTask($newTaskLabel);
}

$tasks = $todoListSqlManager->getTasks();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>TodoList</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="web/css/style.css" />
    </head>
    <body>
        <div id="todolist-items-container">
        <?php foreach ($tasks as $task) { ?>
            <div id="<?php echo $task["task_id"] ?>" class="todolist-task-item">
                <div class="todolist-task-label-container">
                <div class="todolist-task-label">
                    <?php echo $task["task_label"] ?>
                </div>
                </div>
                <div class="todolist-task-delete-btn-container">
                    <button name="delete" class="todolist-task-delete-btn" data-id="<?php echo $task["task_id"] ?>" onclick="deleteTask(this)">remove</button>
                </div>
            </div>
        <?php } ?>         
        </div>
        <form method="post">
            <div id="todolist-create-task-containter">
                <div class="todolist-create-task-input-text-container">
                    <input type="text" name="new_task_label" class="todolist-create-task-input-text"/>
                </div>
                <div class="todolist-task-input-submit-container">
                    <input type="submit" name="new_task_submit" class="todolist-task-input-submit"/>
                </div>
            </div>
        </form>
        <script type="text/javascript">

            // get the scroll height of the window
            const scrollHeight = document.body.scrollHeight;

            // scroll to the bottom of webpage
            window.scrollTo(0, scrollHeight);

            // delete task action ( send Ajax request too ajax service hnh )
            function deleteTask(deleteButton) {

                var delete_task_id = deleteButton.getAttribute("data-id");
                const xhr = new XMLHttpRequest();

                // Prépare une requête GET
                xhr.open('GET', '/ajax_service.php?action=delete&task_id=' + delete_task_id, true);

                // Gère la réponse
                xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 300) {
                    console.log('Données reçues :', JSON.parse(xhr.responseText));
                } else {
                    console.error(`Erreur : ${xhr.status} - ${xhr.statusText}`);
                }
                };

                // Gère les erreurs
                xhr.onerror = function () {
                console.error('Erreur réseau.');
                };

                // Envoie la requête
                xhr.send();

                td = document.getElementById(delete_task_id);
                td.remove();
            
            }
            
            // Pour une requête POST
            //const postData = { key: 'value' };
            //xhr.open('POST', 'https://api.example.com/data', true);
            //xhr.setRequestHeader('Content-Type', 'application/json');
            //r.send(JSON.stringify(postData));
        
        </script>
    </body>
</html>

