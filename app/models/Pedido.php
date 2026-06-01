<?php
require_once __DIR__ . '/../../config/database.php';

class Pedido {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function crear($id_cliente, $total) {
        $stmt = $this->conn->prepare("
            INSERT INTO pedidos (id_cliente, total, estado)
            VALUES (?, ?, 'Recibido')
        ");
        $stmt->execute([$id_cliente, $total]);
        return $this->conn->lastInsertId();
    }

    public function agregarDetalle($id_pedido, $id_producto, $cantidad, $precio_unitario) {
        $stmt = $this->conn->prepare("
            INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad, precio_unitario)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$id_pedido, $id_producto, $cantidad, $precio_unitario]);
    }

    public function getByCliente($id_cliente) {
        $stmt = $this->conn->prepare("
            SELECT * FROM pedidos
            WHERE id_cliente = ?
            ORDER BY fecha DESC
        ");
        $stmt->execute([$id_cliente]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("
            SELECT p.*, u.nombre AS cliente_nombre, u.email AS cliente_email
            FROM pedidos p
            JOIN clientes u ON p.id_cliente = u.id
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
            JOIN clientes u ON p.id_cliente = u.id
            ORDER BY p.fecha DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateEstado($id, $estado) {
        $stmt = $this->conn->prepare("UPDATE pedidos SET estado=? WHERE id=?");
        return $stmt->execute([$estado, $id]);
    }

    // Alias para usar desde PedidoController::cancelar()
    public function cambiarEstado($id, $estado) {
        return $this->updateEstado($id, $estado);
    }
}