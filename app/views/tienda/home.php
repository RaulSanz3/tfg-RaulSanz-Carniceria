<!-- HERO -->
<div class="hero mb-5">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1>Carne de calidad,<br>trato cercano</h1>
            <p>Encarga online y recoge en el mostrador cuando quieras.<br>Sin esperas, sin complicaciones.</p>
            <a href="#productos" class="btn btn-primary btn-lg mt-3"
               onclick="document.getElementById('productos').scrollIntoView({behavior:'smooth'}); return false;">
                Ver productos →
            </a>
        </div>
        <div class="col-md-4 text-center d-none d-md-block">
            <img src="/img/mostrador.png" alt="Mostrador Carnicería Jesús Sanz"
                 style="width:100%; max-height:280px; object-fit:cover; border-radius:12px; opacity:0.9;">
        </div>
    </div>
</div>

<!-- CATEGORÍAS -->
<?php if (!empty($categorias)): ?>
<div class="categoria-bar">
    <a href="/index.php?controller=tienda&action=index"
       class="<?= !isset($categoria) ? 'active' : '' ?>">Todos</a>
    <?php foreach ($categorias as $cat): ?>
        <a href="/index.php?controller=tienda&action=categoria&id=<?= $cat['id'] ?>"
           class="<?= (isset($categoria) && $categoria['id'] == $cat['id']) ? 'active' : '' ?>">
            <?= htmlspecialchars($cat['nombre']) ?>
        </a>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- TÍTULO -->
<h2 class="section-title" id="productos">
    <?= isset($categoria) ? htmlspecialchars($categoria['nombre']) : 'Todos los productos' ?>
</h2>

<!-- GRID DE PRODUCTOS -->
<?php if (empty($productos)): ?>
    <div class="alert alert-warning">No hay productos disponibles en esta categoría.</div>
<?php else: ?>
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
    <?php foreach ($productos as $p): ?>
    <div class="col">
        <div class="product-card">
            <div class="img-wrap">
                <?php if ($p['imagen']): ?>
                    <img src="/img/<?= htmlspecialchars($p['imagen']) ?>" alt="<?= htmlspecialchars($p['nombre']) ?>">
                <?php else: ?>
                    <span class="img-placeholder">🥩</span>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <p class="card-title"><?= htmlspecialchars($p['nombre']) ?></p>
                <p class="card-text"><?= htmlspecialchars(mb_strimwidth($p['descripcion'], 0, 60, '...')) ?></p>
                <p class="price-tag"><?= number_format($p['precio'], 2) ?> € <small style="font-size:0.75rem; color:#999;">/ <?= $p['unidad_medida'] ?></small></p>
                <a href="/index.php?controller=tienda&action=detalle&id=<?= $p['id'] ?>" class="btn-ver">Ver producto</a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>