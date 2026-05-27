<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<h2 class="mb-1">Pedido #<?= $pedido['id'] ?></h2>
<p class="text-muted"><?= date('d/m/Y H:i', strtotime($pedido['fecha'])) ?></p>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card p-3">
            <h6 class="fw-bold">Cliente</h6>
            <p class="mb-0"><?= htmlspecialchars($pedido['cliente_nombre']) ?></p>
            <p class="mb-0 text-muted"><?= htmlspecialchars($pedido['cliente_email']) ?></p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-3">
            <h6 class="fw-bold">Actualizar estado</h6>
            <form action="/index.php?controller=admin&action=actualizarEstado" method="POST" class="d-flex gap-2">
                <input type="hidden" name="id" value="<?= $pedido['id'] ?>">
                <select name="estado" class="form-select form-select-sm">
                    <?php foreach (['Recibido','En preparación','Listo','Entregado'] as $estado): ?>
                        <option value="<?= $estado ?>" <?= $pedido['estado'] === $estado ? 'selected' : '' ?>><?= $estado ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
            </form>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table align-middle">
        <thead class="table-dark">
            <tr><th>Producto</th><th>Cantidad</th><th>Precio ud.</th><th>Subtotal</th></tr>
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

<a href="/index.php?controller=admin&action=pedidos" class="btn btn-outline-secondary mt-3">← Volver a pedidos</a>