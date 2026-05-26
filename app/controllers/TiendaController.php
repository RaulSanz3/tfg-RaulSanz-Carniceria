<?php
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../models/Categoria.php';

class TiendaController {

    public function index() {
        $productoModel = new Producto();
        $categoriaModel = new Categoria();

        $productos = $productoModel->getAll();
        $categorias = $categoriaModel->getAll();

        $titulo = "Carnicería Jesús Sanz";
        $contenido = $this->render('tienda/home', compact('productos', 'categorias'));
        require_once __DIR__ . '/../views/layout/main.php';
    }

    public function detalle() {
        $id = $_GET['id'] ?? null;
        if (!$id) header('Location: /index.php');

        $productoModel = new Producto();
        $producto = $productoModel->getById($id);

        $titulo = $producto['nombre'] ?? "Producto";
        $contenido = $this->render('tienda/detalle', compact('producto'));
        require_once __DIR__ . '/../views/layout/main.php';
    }

    public function categoria() {
        $id = $_GET['id'] ?? null;
        if (!$id) header('Location: /index.php');

        $productoModel = new Producto();
        $categoriaModel = new Categoria();

        $productos = $productoModel->getByCategoria($id);
        $categoria = $categoriaModel->getById($id);
        $categorias = $categoriaModel->getAll();

        $titulo = $categoria['nombre'] ?? "Categoría";
        $contenido = $this->render('tienda/home', compact('productos', 'categorias', 'categoria'));
        require_once __DIR__ . '/../views/layout/main.php';
    }

    private function render($vista, $datos = []) {
        extract($datos);
        ob_start();
        require_once __DIR__ . '/../views/' . $vista . '.php';
        return ob_get_clean();
    }
}