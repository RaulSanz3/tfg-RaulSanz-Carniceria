<h2 class="mb-4">🛒 Mi carrito</h2>

<?php if (empty($carrito)): ?>
    <div class="alert alert-warning">Tu carrito está vacío. <a href="/index.php?controller=tienda&action=index">Ver productos</a></div>
<?php else: ?>
<div class="table-responsive">
    <table class="table align-middle">
        <thead class="table-dark">
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($carrito as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['nombre']) ?></td>
                <td><?= number_format($item['precio'], 2) ?> € / <?= $item['unidad'] ?></td>
                <td><?= $item['cantidad'] ?> <?= $item['unidad'] ?></td>
                <td class="price-tag"><?= number_format($item['precio'] * $item['cantidad'], 2) ?> €</td>
                <td>
                    <a href="/index.php?controller=carrito&action=eliminar&id=<?= $item['id'] ?>"
                       class="btn btn-sm btn-outline-danger">✕</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-end fw-bold">Total:</td>
                <td class="price-tag"><?= number_format($total, 2) ?> €</td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>

<div class="d-flex justify-content-between mt-3">
    <a href="/index.php?controller=carrito&action=vaciar" class="btn btn-outline-secondary">Vaciar carrito</a>
    <a href="/index.php?controller=pedido&action=confirmar" class="btn btn-primary">Confirmar pedido ✓</a>
</div>
<?php endif; ?>