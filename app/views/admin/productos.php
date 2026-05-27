<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Productos</h2>
    <a href="/index.php?controller=admin&action=crearProducto" class="btn btn-primary">+ Nuevo producto</a>
</div>

<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th style="width:90px;">Imagen</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Stock</th>
                <th style="width:130px;"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $p): ?>
            <tr>
                <td>
                    <?php if ($p['imagen']): ?>
                        <img src="/img/<?= htmlspecialchars($p['imagen']) ?>"
                             style="width:70px; height:70px; object-fit:cover; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.12);">
                    <?php else: ?>
                        <div style="width:70px; height:70px; background:#f0f0f0; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:1.8rem;">🥩</div>
                    <?php endif; ?>
                </td>
                <td><strong><?= htmlspecialchars($p['nombre']) ?></strong></td>
                <td><span class="badge bg-secondary"><?= htmlspecialchars($p['categoria_nombre'] ?? '-') ?></span></td>
                <td class="price-tag"><?= number_format($p['precio'], 2) ?> € / <?= $p['unidad_medida'] ?></td>
                <td><?= $p['stock'] ?></td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="/index.php?controller=admin&action=editarProducto&id=<?= $p['id'] ?>"
                           class="btn btn-sm btn-outline-secondary">Editar</a>
                        <a href="/index.php?controller=admin&action=eliminarProducto&id=<?= $p['id'] ?>"
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('¿Eliminar este producto?')">Eliminar</a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>