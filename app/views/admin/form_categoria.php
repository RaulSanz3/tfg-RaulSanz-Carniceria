<h2 class="mb-4"><?= isset($categoria) ? 'Editar categoría' : 'Nueva categoría' ?></h2>

<div class="card p-4 shadow-sm" style="max-width:400px;">
<form action="" method="POST">
    <div class="mb-3">
        <label class="form-label">Nombre de la categoría</label>
        <input type="text" name="nombre" class="form-control" required value="<?= htmlspecialchars($categoria['nombre'] ?? '') ?>">
    </div>
    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="/index.php?controller=admin&action=categorias" class="btn btn-outline-secondary">Cancelar</a>
    </div>
</form>
</div>