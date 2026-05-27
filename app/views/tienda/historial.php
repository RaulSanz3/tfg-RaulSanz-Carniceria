<h2 class="mb-4">Mis pedidos</h2>

<?php if (empty($pedidos)): ?>
    <div class="alert alert-info">Aún no has realizado ningún pedido. <a href="/index.php?controller=tienda&action=index">Ver productos</a></div>
<?php else: ?>
<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Estado</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= date('d/m/Y H:i', strtotime($p['fecha'])) ?></td>
                <td class="price-tag"><?= number_format($p['total'], 2) ?> €</td>
                <td><span class="badge estado-<?= strtolower(str_replace(' ', '-', $p['estado'])) ?>"><?= $p['estado'] ?></span></td>
                <td><a href="/index.php?controller=pedido&action=detalle&id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary">Ver detalle</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>