<?php

class Kernel 
{

    /**
     * project config (bdd, title ...)
     * @var array $config
     */
    private $config = [];

    /**
     * Summary of pdo
     * @var PDO $pdo
     */
    private $pdo;

    public function __construct($config = []) {
        $this->config = $config;
    }

    /**
     * Summary of init
     * @return void
     */
    public function init() {
        $this->initPdo();
    }

    /**
     * init pdo 
     * @return void
     */
    private function initPdo() {
        
        $host = $this->config["bdd"]["hostname"];
        $dbname = $this->config["bdd"]["dbname"];
        $username = $this->config["bdd"]["username"];
        $password = $this->config["bdd"]["password"];

        try {
            $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * @return array
     */
    public function getConfig() {
        return $this->config;
    }

    /**
     * Summary of getPdo
     * @return PDO
     */
    public function getPdo() {
        return $this->pdo;
    }

}

?>