<h2 class="mb-4"><?= isset($producto) ? 'Editar producto' : 'Nuevo producto' ?></h2>

<div class="card p-4 shadow-sm" style="max-width:600px;">
<form action="" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" required value="<?= htmlspecialchars($producto['nombre'] ?? '') ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Descripción</label>
        <textarea name="descripcion" class="form-control" rows="3"><?= htmlspecialchars($producto['descripcion'] ?? '') ?></textarea>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Precio (€)</label>
            <input type="number" name="precio" class="form-control" step="0.01" required value="<?= $producto['precio'] ?? '' ?>">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Unidad de medida</label>
            <select name="unidad_medida" class="form-select">
                <option value="kg" <?= (($producto['unidad_medida'] ?? '') === 'kg') ? 'selected' : '' ?>>Kilogramo (kg)</option>
                <option value="ud" <?= (($producto['unidad_medida'] ?? '') === 'ud') ? 'selected' : '' ?>>Unidad (ud)</option>
            </select>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Stock</label>
        <input type="number" name="stock" class="form-control" step="0.1" value="<?= $producto['stock'] ?? 0 ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Categoría</label>
        <select name="id_categoria" class="form-select">
            <?php foreach ($categorias as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= (isset($producto) && $producto['id_categoria'] == $cat['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Imagen</label>
        <?php if (!empty($producto['imagen'])): ?>
            <div class="mb-2">
                <img src="/img/<?= htmlspecialchars($producto['imagen']) ?>" width="80" style="border-radius:4px;">
                <small class="text-muted d-block">Sube una nueva para reemplazarla</small>
            </div>
        <?php endif; ?>
        <input type="file" name="imagen" class="form-control" accept="image/*">
    </div>
    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="/index.php?controller=admin&action=productos" class="btn btn-outline-secondary">Cancelar</a>
    </div>
</form>
</div>