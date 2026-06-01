<?php
define('DB_HOST', 'db5020556251.hosting-data.io');
define('DB_NAME', 'dbs15723793');
define('DB_USER', 'dbu1118289');
define('DB_PASS', 'Rexittt@2004');
define('DB_PORT', '3306');

class Database {
    private $conn;

    public function getConnection() {
        try {
            $this->conn = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT . ";charset=utf8mb4",
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
            return $this->conn;
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}