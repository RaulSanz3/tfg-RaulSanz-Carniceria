<?php
require_once __DIR__ . '/../models/Usuario.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../libs/PHPMailer/src/Exception.php';
require_once __DIR__ . '/../libs/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../libs/PHPMailer/src/SMTP.php';

class AuthController {

    public function login() {
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            $model = new Usuario();
            $usuario = $model->getByEmail($email);

            if ($usuario && password_verify($password, $usuario['password'])) {
                if (!$usuario['verificado']) {
                    $error = "Debes verificar tu cuenta antes de entrar. Revisa tu correo.";
                } else {
                    $_SESSION['usuario_id']     = $usuario['id'];
                    $_SESSION['usuario_nombre'] = $usuario['nombre'];
                    $_SESSION['usuario_rol']    = $usuario['rol'];

                    if ($usuario['rol'] === 'admin') {
                        header('Location: /index.php?controller=admin&action=index');
                    } else {
                        header('Location: /index.php?controller=tienda&action=index');
                    }
                    exit;
                }
            } else {
                $error = "Email o contraseña incorrectos.";
            }
        }

        $titulo = "Iniciar sesión";
        $contenido = $this->render('auth/login', compact('error'));
        require_once __DIR__ . '/../views/layout/main.php';
    }

    public function registro() {
        $error = null;
        $exito = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new Usuario();
            $emailExistente = $model->getByEmail($_POST['email']);

            if ($emailExistente) {
                $error = "Ya existe una cuenta con ese correo electrónico.";
            } else {
                $codigo = strval(rand(100000, 999999));

                $datos = [
                    'nombre'    => trim($_POST['nombre']),
                    'apellidos' => trim($_POST['apellidos']),
                    'email'     => trim($_POST['email']),
                    'password'  => $_POST['password'],
                    'telefono'  => trim($_POST['telefono']),
                    'codigo'    => $codigo
                ];

                if ($model->create($datos)) {
                    $this->enviarVerificacion($_POST['email'], $datos['nombre'], $codigo);
                    $exito = "Cuenta creada. Revisa tu correo para verificarla.";
                } else {
                    $error = "Error al crear la cuenta. Inténtalo de nuevo.";
                }
            }
        }

        $titulo = "Registro";
        $contenido = $this->render('auth/registro', compact('error', 'exito'));
        require_once __DIR__ . '/../views/layout/main.php';
    }

    public function verificar() {
        $error = null;
        $exito = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email  = trim($_POST['email'] ?? '');
            $codigo = trim($_POST['codigo'] ?? '');

            $model = new Usuario();
            if ($model->verificar($email, $codigo)) {
                $exito = "¡Cuenta verificada! Ya puedes iniciar sesión.";
            } else {
                $error = "Código incorrecto o email no encontrado.";
            }
        }

        $titulo = "Verificar cuenta";
        $contenido = $this->render('auth/verificar', compact('error', 'exito'));
        require_once __DIR__ . '/../views/layout/main.php';
    }

    public function logout() {
        session_destroy();
        header('Location: /index.php');
        exit;
    }

    private function enviarVerificacion($email, $nombre, $codigo) {
        $mail = new PHPMailer(true);
        try {
            $mail->CharSet    = 'UTF-8';
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'rachusanz@gmail.com';
            $mail->Password   = 'jdgl nzwi pcef pzsr';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('rachusanz@gmail.com', 'Carnicería Jesús Sanz');
            $mail->addAddress($email, $nombre);
            $mail->isHTML(true);
            $mail->Subject = '=?UTF-8?B?' . base64_encode('Verifica tu cuenta') . '?=';
            $mail->Body    = "
                <h2>Hola, {$nombre}</h2>
                <p>Tu código de verificación es:</p>
                <h1 style='color:#c9a227; letter-spacing:5px;'>{$codigo}</h1>
                <p>Introdúcelo en la página de verificación para activar tu cuenta.</p>
            ";
            $mail->send();
        } catch (Exception $e) {
            error_log("Error al enviar email: " . $mail->ErrorInfo);
        }
    }

    private function render($vista, $datos = []) {
        extract($datos);
        ob_start();
        require_once __DIR__ . '/../views/' . $vista . '.php';
        return ob_get_clean();
    }
}