<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $titulo ?? "Carnicería-Salchicheria  Jesús Sanz" ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="/index.php">
            <img src="/img/logo.png" alt="Logo" style="height:45px; width:auto; object-fit:contain;">
            Carnicería-Salchicheria <span style="color:var(--dorado); margin-left:6px;">Jesús Sanz</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-center gap-1">
                <li class="nav-item">
                    <a class="nav-link" href="/index.php?controller=tienda&action=index">Tienda</a>
                </li>
                <?php if (isset($_SESSION['Cliente_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/index.php?controller=pedido&action=historial">Mis pedidos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/index.php?controller=carrito&action=ver">
                            🛒
                            <?php
                            $numCarrito = array_sum(array_column($_SESSION['carrito'] ?? [], 'cantidad'));
                            if ($numCarrito > 0) echo "<span class='badge-carrito'>{$numCarrito}</span>";
                            ?>
                        </a>
                    </li>
                    <?php if ($_SESSION['Cliente_rol'] === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/index.php?controller=admin&action=index">Admin</a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/index.php?controller=auth&action=logout">
                            <i class="bi bi-person-circle"></i>
                            <?= htmlspecialchars($_SESSION['Cliente_nombre']) ?> &nbsp;|&nbsp; Salir
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/index.php?controller=auth&action=login">Entrar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary px-4 ms-2"
                           href="/index.php?controller=auth&action=registro">Registrarse</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main class="container py-4">
    <?= $contenido ?>
</main>

<footer>
    <p>&copy; <?= date("Y") ?> <span>Carnicería Jesús Sanz</span> — Navas de Oro, Segovia</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/app.js"></script>
</body>
</html>