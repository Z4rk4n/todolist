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
    </head>
    <body>
        <table>
            <tr>
                <th>Label</th>
                <th></th>
            </tr>
        <?php foreach ($tasks as $task) { ?>
            <tr id="<?php echo $task["task_id"] ?>">
                <td><?php echo $task["task_label"] ?></td>
                <td><button name="delete" class="task-delete-btn" data-id="<?php echo $task["task_id"] ?>" onclick="deleteTask(this)">X</button></td>
            </tr>
        <?php } ?>         
        </table>
        <form method="post">
            <input type="text" name="new_task_label" />
            <input type="submit" name="new_task_submit" />
        </form>
        <script type="text/javascript">
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

