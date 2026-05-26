<?php
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../models/Categoria.php';
require_once __DIR__ . '/../models/Pedido.php';

class AdminController {

    public function __construct() {
        $this->requireAdmin();
    }

    private function requireAdmin() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
            header('Location: /index.php?controller=auth&action=login');
            exit;
        }
    }

    public function index() {
        $pedidoModel = new Pedido();
        $pedidos = $pedidoModel->getAll();

        $titulo = "Panel de administración";
        $contenido = $this->render('admin/index', compact('pedidos'));
        require_once __DIR__ . '/../views/layout/main.php';
    }

    // ---- PRODUCTOS ----

    public function productos() {
        $model = new Producto();
        $productos = $model->getAll();

        $titulo = "Gestión de productos";
        $contenido = $this->render('admin/productos', compact('productos'));
        require_once __DIR__ . '/../views/layout/main.php';
    }

    public function crearProducto() {
        $categoriaModel = new Categoria();
        $categorias = $categoriaModel->getAll();
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imagen = $this->subirImagen();
            $model = new Producto();
            $model->create([
                'nombre'        => trim($_POST['nombre']),
                'descripcion'   => trim($_POST['descripcion']),
                'precio'        => $_POST['precio'],
                'unidad_medida' => $_POST['unidad_medida'],
                'stock'         => $_POST['stock'],
                'imagen'        => $imagen,
                'id_categoria'  => $_POST['id_categoria']
            ]);
            header('Location: /index.php?controller=admin&action=productos');
            exit;
        }

        $titulo = "Nuevo producto";
        $contenido = $this->render('admin/form_producto', compact('categorias', 'error'));
        require_once __DIR__ . '/../views/layout/main.php';
    }

    public function editarProducto() {
        $id = (int)($_GET['id'] ?? 0);
        $model = new Producto();
        $producto = $model->getById($id);
        $categoriaModel = new Categoria();
        $categorias = $categoriaModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imagen = $this->subirImagen() ?: $producto['imagen'];
            $model->update($id, [
                'nombre'        => trim($_POST['nombre']),
                'descripcion'   => trim($_POST['descripcion']),
                'precio'        => $_POST['precio'],
                'unidad_medida' => $_POST['unidad_medida'],
                'stock'         => $_POST['stock'],
                'imagen'        => $imagen,
                'id_categoria'  => $_POST['id_categoria']
            ]);
            header('Location: /index.php?controller=admin&action=productos');
            exit;
        }

        $titulo = "Editar producto";
        $contenido = $this->render('admin/form_producto', compact('producto', 'categorias'));
        require_once __DIR__ . '/../views/layout/main.php';
    }

    public function eliminarProducto() {
        $id = (int)($_GET['id'] ?? 0);
        $model = new Producto();
        $model->delete($id);
        header('Location: /index.php?controller=admin&action=productos');
        exit;
    }

    // ---- CATEGORÍAS ----

    public function categorias() {
        $model = new Categoria();
        $categorias = $model->getAll();

        $titulo = "Gestión de categorías";
        $contenido = $this->render('admin/categorias', compact('categorias'));
        require_once __DIR__ . '/../views/layout/main.php';
    }

    public function crearCategoria() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new Categoria();
            $model->create(trim($_POST['nombre']));
            header('Location: /index.php?controller=admin&action=categorias');
            exit;
        }
        $titulo = "Nueva categoría";
        $contenido = $this->render('admin/form_categoria');
        require_once __DIR__ . '/../views/layout/main.php';
    }

    public function editarCategoria() {
        $id = (int)($_GET['id'] ?? 0);
        $model = new Categoria();
        $categoria = $model->getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model->update($id, trim($_POST['nombre']));
            header('Location: /index.php?controller=admin&action=categorias');
            exit;
        }

        $titulo = "Editar categoría";
        $contenido = $this->render('admin/form_categoria', compact('categoria'));
        require_once __DIR__ . '/../views/layout/main.php';
    }

    public function eliminarCategoria() {
        $id = (int)($_GET['id'] ?? 0);
        $model = new Categoria();
        $model->delete($id);
        header('Location: /index.php?controller=admin&action=categorias');
        exit;
    }

    // ---- PEDIDOS ----

    public function pedidos() {
        $model = new Pedido();
        $pedidos = $model->getAll();

        $titulo = "Gestión de pedidos";
        $contenido = $this->render('admin/pedidos', compact('pedidos'));
        require_once __DIR__ . '/../views/layout/main.php';
    }

    public function detallePedido() {
        $id = (int)($_GET['id'] ?? 0);
        $model = new Pedido();
        $pedido  = $model->getById($id);
        $detalle = $model->getDetalle($id);

        $titulo = "Pedido #" . $id;
        $contenido = $this->render('admin/detalle_pedido', compact('pedido', 'detalle'));
        require_once __DIR__ . '/../views/layout/main.php';
    }

    public function actualizarEstado() {
        $id     = (int)($_POST['id'] ?? 0);
        $estado = $_POST['estado'] ?? '';
        $estadosValidos = ['Recibido', 'En preparación', 'Listo', 'Entregado'];

        if ($id && in_array($estado, $estadosValidos)) {
            $model = new Pedido();
            $model->updateEstado($id, $estado);
        }

        header('Location: /index.php?controller=admin&action=pedidos');
        exit;
    }

    // ---- UTILIDADES ----

    private function subirImagen() {
        if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
            return null;
        }
    
        $ext = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
        $permitidas = ['jpg', 'jpeg', 'png', 'webp'];
    
        if (!in_array($ext, $permitidas)) return null;
    
        $nombre = uniqid('prod_') . '.' . $ext;
        $destino = '/var/www/html/img/' . $nombre;
        move_uploaded_file($_FILES['imagen']['tmp_name'], $destino);
    
        return $nombre;
    }

    private function render($vista, $datos = []) {
        extract($datos);
        ob_start();
        require_once __DIR__ . '/../views/' . $vista . '.php';
        return ob_get_clean();
    }
}