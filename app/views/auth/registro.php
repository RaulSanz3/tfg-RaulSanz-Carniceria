<div class="row justify-content-center">
<div class="col-md-6">
    <div class="card p-4 shadow">
        <h3 class="mb-4 text-center">Crear cuenta</h3>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <?php if ($exito): ?>
            <div class="alert alert-success">
                <?= $exito ?>
                <a href="/index.php?controller=auth&action=verificar" class="d-block mt-2">→ Ir a verificar cuenta</a>
            </div>
        <?php else: ?>
        <form action="/index.php?controller=auth&action=registro" method="POST">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Apellidos</label>
                    <input type="text" name="apellidos" class="form-control" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Correo electrónico</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <input type="tel" name="telefono" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" required minlength="6">
            </div>
            <button type="submit" class="btn btn-primary w-100">Crear cuenta</button>
        </form>
        <?php endif; ?>
        <p class="text-center mt-3 mb-0">
            ¿Ya tienes cuenta? <a href="/index.php?controller=auth&action=login">Inicia sesión</a>
        </p>
    </div>
</div>
</div>