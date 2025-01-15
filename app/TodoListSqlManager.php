<?php

class TodoListSqlManager
{

    /**
     * Summary of pdo
     * @var PDO $pdo
     */
    private $pdo;

    /**
     * Summary of __construct
     * This class need a full PDO with legacy Connection
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo) 
    {
        $this->pdo = $pdo;
    }

    /**
     * Summary of getTasks
     * @return array|bool
     */
    public function getTasks(): array|bool {
        $return = [];
        $sql = "SELECT * FROM tasks ORDER BY task_creation_date";
        
        try {

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            $return = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo "Error getTasks Method: " . $e->getMessage();
        }

        return $return;
    }

    /**
     * Summary of createTask
     * @param mixed $label
     * @return bool
     */
    public function createTask($label) {
        $return = false;
        
        $sql = "INSERT INTO tasks (task_label, task_status_id) VALUES (:task_label, 1)";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':task_label', $label, PDO::PARAM_STR);
            $return = $stmt->execute();
        } catch (PDOException $e) {
            echo "create Task Error: ". $e->getMessage();
        }

        return $return;
    }

    public function deleteTask($task_id) {
        $return = false;
        
        $sql = "DELETE FROM tasks WHERE task_id = :task_id";
        
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam("task_id", $task_id, PDO::PARAM_INT);
            $return = $stmt->execute();
        } catch(PDOException $e) {
            echo "Error from Delete task: ". $e->getMessage();
        }

        return $return;
    }

}

?>