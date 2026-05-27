<?php
session_start();

// Autoload manual de controladores y modelos
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/app/controllers/' . $class . '.php',
        __DIR__ . '/app/models/' . $class . '.php',
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

require_once __DIR__ . '/config/database.php';

// Leer controlador y acción de la URL
$controller = $_GET['controller'] ?? 'tienda';
$action     = $_GET['action']     ?? 'index';

// Whitelist de controladores permitidos
$allowed = ['tienda', 'auth', 'admin', 'pedido', 'carrito'];

if (!in_array($controller, $allowed)) {
    $controller = 'tienda';
    $action = 'index';
}

// Instanciar controlador
$controllerName = ucfirst($controller) . 'Controller';
$controllerFile = __DIR__ . '/app/controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $ctrl = new $controllerName();
    if (method_exists($ctrl, $action)) {
        $ctrl->$action();
    } else {
        http_response_code(404);
        echo "Acción no encontrada.";
    }
} else {
    http_response_code(404);
    echo "Controlador no encontrado.";
}