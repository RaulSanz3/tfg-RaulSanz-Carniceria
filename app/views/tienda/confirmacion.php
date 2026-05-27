<div class="text-center py-5">
    <div style="font-size:4rem;">✅</div>
    <h2 class="mt-3">¡Pedido confirmado!</h2>
    <p class="lead">Tu pedido <strong>#<?= $id_pedido ?></strong> ha sido recibido correctamente.</p>
    <p>El importe total es <strong class="price-tag"><?= number_format($total, 2) ?> €</strong>.</p>
    <p class="text-muted">Cuando esté listo te avisaremos. Pasa a recogerlo por el mostrador y abona en el momento.</p>
    <div class="mt-4 d-flex justify-content-center gap-3">
        <a href="/index.php?controller=pedido&action=historial" class="btn btn-outline-primary">Ver mis pedidos</a>
        <a href="/index.php?controller=tienda&action=index" class="btn btn-primary">Seguir comprando</a>
    </div>
</div>