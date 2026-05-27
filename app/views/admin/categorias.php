<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Categorías</h2>
    <a href="/index.php?controller=admin&action=crearCategoria" class="btn btn-primary">+ Nueva categoría</a>
</div>

<div class="table-responsive" style="max-width:500px;">
    <table class="table table-hover align-middle">
        <thead class="table-dark">
            <tr><th>#</th><th>Nombre</th><th></th></tr>
        </thead>
        <tbody>
            <?php foreach ($categorias as $c): ?>
            <tr>
                <td><?= $c['id'] ?></td>
                <td><?= htmlspecialchars($c['nombre']) ?></td>
                <td class="d-flex gap-1">
                    <a href="/index.php?controller=admin&action=editarCategoria&id=<?= $c['id'] ?>" class="btn btn-sm btn-outline-secondary">Editar</a>
                    <a href="/index.php?controller=admin&action=eliminarCategoria&id=<?= $c['id'] ?>"
                       class="btn btn-sm btn-outline-danger"
                       onclick="return confirm('¿Eliminar esta categoría?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>