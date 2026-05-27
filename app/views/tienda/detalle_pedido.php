<h2 class="mb-1">Pedido #<?= $pedido['id'] ?></h2>
<p class="text-muted mb-4"><?= date('d/m/Y H:i', strtotime($pedido['fecha'])) ?></p>

<div class="table-responsive mb-4">
    <table class="table align-middle">
        <thead class="table-dark">
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio ud.</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detalle as $d): ?>
            <tr>
                <td><?= htmlspecialchars($d['producto_nombre']) ?></td>
                <td><?= $d['cantidad'] ?></td>
                <td><?= number_format($d['precio_unitario'], 2) ?> €</td>
                <td><?= number_format($d['cantidad'] * $d['precio_unitario'], 2) ?> €</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-end fw-bold">Total:</td>
                <td class="price-tag"><?= number_format($pedido['total'], 2) ?> €</td>
            </tr>
        </tfoot>
    </table>
</div>

<p>Estado: <span class="badge estado-<?= strtolower(str_replace(' ', '-', $pedido['estado'])) ?>"><?= $pedido['estado'] ?></span></p>
<a href="/index.php?controller=pedido&action=historial" class="btn btn-outline-secondary mt-3">← Volver a mis pedidos</a>