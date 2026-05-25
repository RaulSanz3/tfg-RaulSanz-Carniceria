<?php
require_once __DIR__ . '/../../config/database.php';

class Pedido {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function crear($id_usuario, $total) {
        $stmt = $this->conn->prepare("
            INSERT INTO pedidos (id_usuario, total, estado)
            VALUES (?, ?, 'Recibido')
        ");
        $stmt->execute([$id_usuario, $total]);
        return $this->conn->lastInsertId();
    }

    public function agregarDetalle($id_pedido, $id_producto, $cantidad, $precio_unitario) {
        $stmt = $this->conn->prepare("
            INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad, precio_unitario)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$id_pedido, $id_producto, $cantidad, $precio_unitario]);
    }

    public function getByUsuario($id_usuario) {
        $stmt = $this->conn->prepare("
            SELECT * FROM pedidos
            WHERE id_usuario = ?
            ORDER BY fecha DESC
        ");
        $stmt->execute([$id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("
            SELECT p.*, u.nombre AS cliente_nombre, u.email AS cliente_email
            FROM pedidos p
            JOIN usuarios u ON p.id_usuario = u.id
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getDetalle($id_pedido) {
        $stmt = $this->conn->prepare("
            SELECT dp.*, pr.nombre AS producto_nombre
            FROM detalle_pedido dp
            JOIN productos pr ON dp.id_producto = pr.id
            WHERE dp.id_pedido = ?
        ");
        $stmt->execute([$id_pedido]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll() {
        $stmt = $this->conn->prepare("
            SELECT p.*, u.nombre AS cliente_nombre, u.email AS cliente_email
            FROM pedidos p
            JOIN usuarios u ON p.id_usuario = u.id
            ORDER BY p.fecha DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateEstado($id, $estado) {
        $stmt = $this->conn->prepare("UPDATE pedidos SET estado=? WHERE id=?");
        return $stmt->execute([$estado, $id]);
    }
}