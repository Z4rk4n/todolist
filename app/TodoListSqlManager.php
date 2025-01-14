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
    public function getTasks() {
        $return = [];
        $sql = "SELECT * FROM task_status WHERE task_status_id = 99;";
        
        try {
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            $return = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo "Error getTasks Method: " . $e->getMessage();
        }

        return $return;
    }
}

?>