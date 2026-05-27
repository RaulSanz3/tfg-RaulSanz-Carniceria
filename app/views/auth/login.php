<div class="row justify-content-center">
<div class="col-md-5">
    <div class="card p-4 shadow">
        <h3 class="mb-4 text-center">Iniciar sesión</h3>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form action="/index.php?controller=auth&action=login" method="POST">
            <div class="mb-3">
                <label class="form-label">Correo electrónico</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>
        <p class="text-center mt-3 mb-0">
            ¿No tienes cuenta? <a href="/index.php?controller=auth&action=registro">Regístrate</a>
        </p>
    </div>
</div>
</div>