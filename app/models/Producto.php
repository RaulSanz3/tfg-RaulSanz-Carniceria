<?php
require_once __DIR__ . '/../../config/database.php';

class Producto {
    private $conn;
    private $table = 'productos';

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getAll() {
        $stmt = $this->conn->prepare("
            SELECT p.*, c.nombre AS categoria_nombre
            FROM {$this->table} p
            LEFT JOIN categorias c ON p.id_categoria = c.id
            ORDER BY p.id DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("
            SELECT p.*, c.nombre AS categoria_nombre
            FROM {$this->table} p
            LEFT JOIN categorias c ON p.id_categoria = c.id
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByCategoria($id_categoria) {
        $stmt = $this->conn->prepare("
            SELECT * FROM {$this->table}
            WHERE id_categoria = ?
            ORDER BY nombre ASC
        ");
        $stmt->execute([$id_categoria]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($datos) {
        $stmt = $this->conn->prepare("
            INSERT INTO {$this->table}
            (nombre, descripcion, precio, unidad_medida, stock, imagen, id_categoria)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $datos['nombre'],
            $datos['descripcion'],
            $datos['precio'],
            $datos['unidad_medida'],
            $datos['stock'],
            $datos['imagen'],
            $datos['id_categoria']
        ]);
    }

    public function update($id, $datos) {
        $stmt = $this->conn->prepare("
            UPDATE {$this->table}
            SET nombre=?, descripcion=?, precio=?, unidad_medida=?, stock=?, imagen=?, id_categoria=?
            WHERE id=?
        ");
        return $stmt->execute([
            $datos['nombre'],
            $datos['descripcion'],
            $datos['precio'],
            $datos['unidad_medida'],
            $datos['stock'],
            $datos['imagen'],
            $datos['id_categoria'],
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }
}