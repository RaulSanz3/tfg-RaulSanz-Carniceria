// ── VALIDACIONES DE FORMULARIOS ──

document.addEventListener('DOMContentLoaded', function () {

    // ── REGISTRO: confirmar contraseña y mínimo 6 caracteres ──
    const formRegistro = document.querySelector('form[action*="registro"]');
    if (formRegistro) {
        formRegistro.addEventListener('submit', function (e) {
            const password = formRegistro.querySelector('input[name="password"]');
            const telefono = formRegistro.querySelector('input[name="telefono"]');

            if (password && password.value.length < 6) {
                e.preventDefault();
                mostrarError(password, 'La contraseña debe tener al menos 6 caracteres.');
                return;
            }

            if (telefono && telefono.value !== '' && !/^\d{9}$/.test(telefono.value)) {
                e.preventDefault();
                mostrarError(telefono, 'El teléfono debe tener 9 dígitos.');
                return;
            }
        });
    }

    // ── LOGIN: campos no vacíos ──
    const formLogin = document.querySelector('form[action*="login"]');
    if (formLogin) {
        formLogin.addEventListener('submit', function (e) {
            const email    = formLogin.querySelector('input[name="email"]');
            const password = formLogin.querySelector('input[name="password"]');

            if (email && email.value.trim() === '') {
                e.preventDefault();
                mostrarError(email, 'Introduce tu correo electrónico.');
                return;
            }
            if (password && password.value.trim() === '') {
                e.preventDefault();
                mostrarError(password, 'Introduce tu contraseña.');
                return;
            }
        });
    }

    // ── VERIFICAR: código de 6 dígitos ──
    const formVerificar = document.querySelector('form[action*="verificar"]');
    if (formVerificar) {
        formVerificar.addEventListener('submit', function (e) {
            const codigo = formVerificar.querySelector('input[name="codigo"]');
            if (codigo && !/^\d{6}$/.test(codigo.value.trim())) {
                e.preventDefault();
                mostrarError(codigo, 'El código debe ser exactamente 6 dígitos.');
                return;
            }
        });
    }

    // ── CARRITO: cantidad mayor que 0 ──
    const formCarrito = document.querySelector('form[action*="agregar"]');
    if (formCarrito) {
        formCarrito.addEventListener('submit', function (e) {
            const cantidad = formCarrito.querySelector('input[name="cantidad"]');
            if (cantidad && parseFloat(cantidad.value) <= 0) {
                e.preventDefault();
                mostrarError(cantidad, 'La cantidad debe ser mayor que 0.');
                return;
            }
        });
    }

    // ── ADMIN PRODUCTOS: precio y stock positivos ──
    const formProducto = document.querySelector('form[enctype="multipart/form-data"]');
    if (formProducto) {
        formProducto.addEventListener('submit', function (e) {
            const nombre = formProducto.querySelector('input[name="nombre"]');
            const precio = formProducto.querySelector('input[name="precio"]');
            const stock  = formProducto.querySelector('input[name="stock"]');

            if (nombre && nombre.value.trim() === '') {
                e.preventDefault();
                mostrarError(nombre, 'El nombre no puede estar vacío.');
                return;
            }
            if (precio && parseFloat(precio.value) <= 0) {
                e.preventDefault();
                mostrarError(precio, 'El precio debe ser mayor que 0.');
                return;
            }
            if (stock && parseFloat(stock.value) < 0) {
                e.preventDefault();
                mostrarError(stock, 'El stock no puede ser negativo.');
                return;
            }
        });
    }

    // ── LIMPIAR errores al escribir ──
    document.querySelectorAll('input').forEach(function (input) {
        input.addEventListener('input', function () {
            limpiarError(input);
        });
    });
});

// ── FUNCIONES AUXILIARES ──

function mostrarError(input, mensaje) {
    limpiarError(input);
    input.classList.add('is-invalid');
    const div = document.createElement('div');
    div.className = 'invalid-feedback';
    div.textContent = mensaje;
    input.parentNode.appendChild(div);
    input.focus();
}

function limpiarError(input) {
    input.classList.remove('is-invalid');
    const feedback = input.parentNode.querySelector('.invalid-feedback');
    if (feedback) feedback.remove();
}