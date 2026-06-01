<?php
require_once __DIR__ . '/../models/Pedido.php';

class PedidoController {

    public function confirmar() {
        if (!isset($_SESSION['Cliente_id'])) {
            header('Location: /index.php?controller=auth&action=login');
            exit;
        }

        $carrito = $_SESSION['carrito'] ?? [];
        if (empty($carrito)) {
            header('Location: /index.php?controller=carrito&action=ver');
            exit;
        }

        $total = array_reduce($carrito, function($suma, $item) {
            return $suma + ($item['precio'] * $item['cantidad']);
        }, 0);

        $model = new Pedido();
        $id_pedido = $model->crear($_SESSION['Cliente_id'], $total);

        foreach ($carrito as $item) {
            $model->agregarDetalle($id_pedido, $item['id'], $item['cantidad'], $item['precio']);
        }

        $_SESSION['carrito'] = [];

        $titulo = "Pedido confirmado";
        $contenido = $this->render('tienda/confirmacion', compact('id_pedido', 'total'));
        require_once __DIR__ . '/../views/layout/main.php';
    }

    public function historial() {
        if (!isset($_SESSION['Cliente_id'])) {
            header('Location: /index.php?controller=auth&action=login');
            exit;
        }

        $model = new Pedido();
        $pedidos = $model->getByCliente($_SESSION['Cliente_id']);

        $titulo = "Mis pedidos";
        $contenido = $this->render('tienda/historial', compact('pedidos'));
        require_once __DIR__ . '/../views/layout/main.php';
    }

    public function detalle() {
        if (!isset($_SESSION['Cliente_id'])) {
            header('Location: /index.php?controller=auth&action=login');
            exit;
        }

        $id = (int)($_GET['id'] ?? 0);
        $model = new Pedido();
        $pedido  = $model->getById($id);
        $detalle = $model->getDetalle($id);

        if (!$pedido || ($pedido['id_cliente'] != $_SESSION['Cliente_id'] && $_SESSION['Cliente_rol'] !== 'admin')) {
            header('Location: /index.php');
            exit;
        }

        $titulo = "Detalle del pedido #" . $id;
        $contenido = $this->render('tienda/detalle_pedido', compact('pedido', 'detalle'));
        require_once __DIR__ . '/../views/layout/main.php';
    }

    public function cancelar() {
        if (!isset($_SESSION['Cliente_id'])) {
            header('Location: /index.php?controller=auth&action=login');
            exit;
        }

        $id = (int)($_GET['id'] ?? 0);
        $model = new Pedido();
        $pedido = $model->getById($id);

        // Seguridad: solo puede cancelar sus propios pedidos
        if (!$pedido || $pedido['id_cliente'] != $_SESSION['Cliente_id']) {
            header('Location: /index.php?controller=pedido&action=historial');
            exit;
        }

        // Solo se puede cancelar si está en estado "Recibido"
        if ($pedido['estado'] !== 'Recibido') {
            header('Location: /index.php?controller=pedido&action=historial');
            exit;
        }

        $model->cambiarEstado($id, 'Cancelado');
        header('Location: /index.php?controller=pedido&action=historial');
        exit;
    }

    private function render($vista, $datos = []) {
        extract($datos);
        ob_start();
        require_once __DIR__ . '/../views/' . $vista . '.php';
        return ob_get_clean();
    }
}