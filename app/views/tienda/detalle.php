<?php if (!$producto): ?>
    <p class="text-center">Producto no encontrado.</p>
<?php else: ?>
<div class="row">
    <div class="col-md-5 text-center">
        <?php if ($producto['imagen']): ?>
            <img src="/img/<?= htmlspecialchars($producto['imagen']) ?>" class="img-fluid rounded shadow" alt="<?= htmlspecialchars($producto['nombre']) ?>">
        <?php else: ?>
            <div class="product-img-placeholder d-flex align-items-center justify-content-center rounded" style="height:300px; background:#f0f0f0;">
                <span style="font-size:5rem;">🥩</span>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-md-7">
        <h2><?= htmlspecialchars($producto['nombre']) ?></h2>
        <span class="badge bg-secondary mb-3"><?= htmlspecialchars($producto['categoria_nombre'] ?? '') ?></span>
        <p class="text-muted"><?= htmlspecialchars($producto['descripcion']) ?></p>
        <p class="price-tag"><?= number_format($producto['precio'], 2) ?> € / <?= $producto['unidad_medida'] ?></p>

        <?php if (isset($_SESSION['Cliente_id'])): ?>
        <form action="/index.php?controller=carrito&action=agregar" method="POST" class="d-flex align-items-center gap-3 mt-3">
            <input type="hidden" name="id_producto" value="<?= $producto['id'] ?>">
            <div>
                <label class="form-label mb-1">Cantidad (<?= $producto['unidad_medida'] ?>)</label>
                <input type="number" name="cantidad" value="1" min="0.1" step="0.1" class="form-control" style="width:100px;">
            </div>
            <button type="submit" class="btn btn-primary align-self-end">Añadir al carrito 🛒</button>
        </form>
        <?php else: ?>
            <a href="/index.php?controller=auth&action=login" class="btn btn-outline-primary mt-3">Inicia sesión para pedir</a>
        <?php endif; ?>

        <a href="/index.php?controller=tienda&action=index" class="btn btn-link mt-3 d-block">← Volver a la tienda</a>
    </div>
</div>
<?php endif; ?>