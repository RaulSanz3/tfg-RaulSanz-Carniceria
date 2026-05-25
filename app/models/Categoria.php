<?php
require_once __DIR__ . '/../../config/database.php';

class Categoria {
    private $conn;
    private $table = 'categorias';

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} ORDER BY nombre ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($nombre) {
        $stmt = $this->conn->prepare("INSERT INTO {$this->table} (nombre) VALUES (?)");
        return $stmt->execute([$nombre]);
    }

    public function update($id, $nombre) {
        $stmt = $this->conn->prepare("UPDATE {$this->table} SET nombre=? WHERE id=?");
        return $stmt->execute([$nombre, $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id=?");
        return $stmt->execute([$id]);
    }
}