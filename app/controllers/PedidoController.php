<?php
require_once __DIR__ . '/../models/Pedido.php';

class PedidoController {

    public function confirmar() {
        if (!isset($_SESSION['usuario_id'])) {
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
        $id_pedido = $model->crear($_SESSION['usuario_id'], $total);

        foreach ($carrito as $item) {
            $model->agregarDetalle($id_pedido, $item['id'], $item['cantidad'], $item['precio']);
        }

        $_SESSION['carrito'] = [];

        $titulo = "Pedido confirmado";
        $contenido = $this->render('tienda/confirmacion', compact('id_pedido', 'total'));
        require_once __DIR__ . '/../views/layout/main.php';
    }

    public function historial() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /index.php?controller=auth&action=login');
            exit;
        }

        $model = new Pedido();
        $pedidos = $model->getByUsuario($_SESSION['usuario_id']);

        $titulo = "Mis pedidos";
        $contenido = $this->render('tienda/historial', compact('pedidos'));
        require_once __DIR__ . '/../views/layout/main.php';
    }

    public function detalle() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /index.php?controller=auth&action=login');
            exit;
        }

        $id = (int)($_GET['id'] ?? 0);
        $model = new Pedido();
        $pedido  = $model->getById($id);
        $detalle = $model->getDetalle($id);

        // Seguridad: el cliente solo puede ver sus propios pedidos
        if (!$pedido || ($pedido['id_usuario'] != $_SESSION['usuario_id'] && $_SESSION['usuario_rol'] !== 'admin')) {
            header('Location: /index.php');
            exit;
        }

        $titulo = "Detalle del pedido #" . $id;
        $contenido = $this->render('tienda/detalle_pedido', compact('pedido', 'detalle'));
        require_once __DIR__ . '/../views/layout/main.php';
    }

    private function render($vista, $datos = []) {
        extract($datos);
        ob_start();
        require_once __DIR__ . '/../views/' . $vista . '.php';
        return ob_get_clean();
    }
}