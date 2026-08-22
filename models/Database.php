<?php
class Database {
    private $host = "localhost";
    private $db_name = "betterhealth";
    private $username = "root";
    private $password = "";
    private static $instance = null;
    private $conn;

    private function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Database connection error: " . $e->getMessage());
        }
    }

    // create a database instance
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Get connection
    public function getConnection() {
        return $this->conn;
    }
}
