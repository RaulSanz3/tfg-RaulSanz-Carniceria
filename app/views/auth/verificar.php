<div class="row justify-content-center">
<div class="col-md-5">
    <div class="card p-4 shadow">
        <h3 class="mb-4 text-center">Verificar cuenta</h3>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <?php if ($exito): ?>
            <div class="alert alert-success">
                <?= $exito ?>
                <a href="/index.php?controller=auth&action=login" class="d-block mt-2">→ Ir a iniciar sesión</a>
            </div>
        <?php else: ?>
        <p class="text-muted text-center">Introduce el código de 6 dígitos que recibiste en tu correo.</p>
        <form action="/index.php?controller=auth&action=verificar" method="POST">
            <div class="mb-3">
                <label class="form-label">Correo electrónico</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Código de verificación</label>
                <input type="text" name="codigo" class="form-control text-center"
                       maxlength="6" placeholder="123456" required style="letter-spacing:8px; font-size:1.4rem;">
            </div>
            <button type="submit" class="btn btn-primary w-100">Verificar</button>
        </form>
        <?php endif; ?>
    </div>
</div>
</div>