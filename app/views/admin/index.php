<h2 class="mb-4">Panel de administración</h2>

<div class="row g-4 mb-5">
    <div class="col-md-4">
        <a href="/index.php?controller=admin&action=productos" class="text-decoration-none">
            <div class="card text-center p-4 admin-card">
                <div style="font-size:2.5rem;">🥩</div>
                <h5 class="mt-2">Productos</h5>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="/index.php?controller=admin&action=categorias" class="text-decoration-none">
            <div class="card text-center p-4 admin-card">
                <div style="font-size:2.5rem;">📂</div>
                <h5 class="mt-2">Categorías</h5>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="/index.php?controller=admin&action=pedidos" class="text-decoration-none">
            <div class="card text-center p-4 admin-card">
                <div style="font-size:2.5rem;">📋</div>
                <h5 class="mt-2">Pedidos</h5>
            </div>
        </a>
    </div>
</div>

<h4>Últimos pedidos</h4>
<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-dark">
            <tr><th>#</th><th>Cliente</th><th>Fecha</th><th>Total</th><th>Estado</th><th></th></tr>
        </thead>
        <tbody>
            <?php foreach (array_slice($pedidos, 0, 5) as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= htmlspecialchars($p['cliente_nombre']) ?></td>
                <td><?= date('d/m/Y H:i', strtotime($p['fecha'])) ?></td>
                <td><?= number_format($p['total'], 2) ?> €</td>
                <td><span class="badge estado-<?= strtolower(str_replace(' ', '-', $p['estado'])) ?>"><?= $p['estado'] ?></span></td>
                <td><a href="/index.php?controller=admin&action=detallePedido&id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary">Ver</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>