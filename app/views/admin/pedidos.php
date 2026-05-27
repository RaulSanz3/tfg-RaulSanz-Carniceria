<h2 class="mb-4">Gestión de pedidos</h2>

<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-dark">
            <tr><th>#</th><th>Cliente</th><th>Email</th><th>Fecha</th><th>Total</th><th>Estado</th><th></th></tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= htmlspecialchars($p['cliente_nombre']) ?></td>
                <td><?= htmlspecialchars($p['cliente_email']) ?></td>
                <td><?= date('d/m/Y H:i', strtotime($p['fecha'])) ?></td>
                <td><?= number_format($p['total'], 2) ?> €</td>
                <td><span class="badge estado-<?= strtolower(str_replace(' ', '-', $p['estado'])) ?>"><?= $p['estado'] ?></span></td>
                <td><a href="/index.php?controller=admin&action=detallePedido&id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary">Ver</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>