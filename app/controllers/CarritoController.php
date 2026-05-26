<?php
class CarritoController {

    public function agregar() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /index.php?controller=auth&action=login');
            exit;
        }

        $id_producto    = (int)($_POST['id_producto'] ?? 0);
        $cantidad       = (float)($_POST['cantidad'] ?? 1);

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        if (isset($_SESSION['carrito'][$id_producto])) {
            $_SESSION['carrito'][$id_producto]['cantidad'] += $cantidad;
        } else {
            require_once __DIR__ . '/../models/Producto.php';
            $model = new Producto();
            $producto = $model->getById($id_producto);

            if ($producto) {
                $_SESSION['carrito'][$id_producto] = [
                    'id'       => $producto['id'],
                    'nombre'   => $producto['nombre'],
                    'precio'   => $producto['precio'],
                    'unidad'   => $producto['unidad_medida'],
                    'cantidad' => $cantidad
                ];
            }
        }

        header('Location: /index.php?controller=carrito&action=ver');
        exit;
    }

    public function ver() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /index.php?controller=auth&action=login');
            exit;
        }

        $carrito = $_SESSION['carrito'] ?? [];
        $total = array_reduce($carrito, function($suma, $item) {
            return $suma + ($item['precio'] * $item['cantidad']);
        }, 0);

        $titulo = "Mi carrito";
        $contenido = $this->render('tienda/carrito', compact('carrito', 'total'));
        require_once __DIR__ . '/../views/layout/main.php';
    }

    public function eliminar() {
        $id = (int)($_GET['id'] ?? 0);
        if (isset($_SESSION['carrito'][$id])) {
            unset($_SESSION['carrito'][$id]);
        }
        header('Location: /index.php?controller=carrito&action=ver');
        exit;
    }

    public function vaciar() {
        $_SESSION['carrito'] = [];
        header('Location: /index.php?controller=carrito&action=ver');
        exit;
    }

    private function render($vista, $datos = []) {
        extract($datos);
        ob_start();
        require_once __DIR__ . '/../views/' . $vista . '.php';
        return ob_get_clean();
    }
}