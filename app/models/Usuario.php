<?php
require_once __DIR__ . '/../../config/database.php';

class Usuario {
    private $conn;
    private $table = 'usuarios';

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($datos) {
        $stmt = $this->conn->prepare("
            INSERT INTO {$this->table}
            (nombre, apellidos, email, password, telefono, rol, verificado, codigo_verificacion)
            VALUES (?, ?, ?, ?, ?, 'cliente', 0, ?)
        ");
        return $stmt->execute([
            $datos['nombre'],
            $datos['apellidos'],
            $datos['email'],
            password_hash($datos['password'], PASSWORD_DEFAULT),
            $datos['telefono'],
            $datos['codigo']
        ]);
    }

    public function verificar($email, $codigo) {
        // Comprobar que el código es correcto
        $stmt = $this->conn->prepare("
            SELECT * FROM {$this->table}
            WHERE email = ? AND codigo_verificacion = ?
        ");
        $stmt->execute([$email, $codigo]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Marcar como verificado
            $stmt2 = $this->conn->prepare("
                UPDATE {$this->table}
                SET verificado = 1, codigo_verificacion = NULL
                WHERE email = ?
            ");
            $stmt2->execute([$email]);
            return true;
        }
        return false;
    }

    public function update($id, $datos) {
        $stmt = $this->conn->prepare("
            UPDATE {$this->table}
            SET nombre=?, apellidos=?, telefono=?
            WHERE id=?
        ");
        return $stmt->execute([
            $datos['nombre'],
            $datos['apellidos'],
            $datos['telefono'],
            $id
        ]);
    }
}