<?php

namespace Controllers;

use Model\Usuario;
use MVC\Router;

class LoginController
{
    public static function login(Router $router)
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
        }

        $router->render('auth/login', [
            'titulo' => 'Iniciar sesión'
        ]);
    }

    public static function logout()
    {
        echo "from logout";
    }

    public static function create(Router $router)
    {
        $usuario = new Usuario();
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCueta();

            if (empty($alertas)) {
                $existeUsuario = Usuario::where('email', $usuario->email);

                if ($existeUsuario) {
                    Usuario::setAlerta('error', 'El usuario ya está registrado');

                    $alertas = Usuario::getAlertas();
                } else {
                    unset($usuario->password2);

                    $usuario->hashPassword();
                    $usuario->crearToken();
                    $resultado = $usuario->guardar();

                    if ($resultado) header('Location: /message');
                }
            }
        }

        $router->render('auth/create', [
            'titulo' => 'Crear tu cuenta',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function forgotPassword(Router $router)
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
        }

        $router->render('auth/forgot-password', [
            'titulo' => 'Olvidé mi contraseña'
        ]);
    }

    public static function resetPassword(Router $router)
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
        }

        $router->render('auth/reset-password', [
            'titulo' => 'Olvidé mi contraseña'
        ]);
    }

    public static function message(Router $router)
    {
        $router->render('auth/message', [
            'titulo' => 'Cuenta creada con éxito'
        ]);
    }

    public static function confirmUser(Router $router)
    {
        $router->render('auth/confirm-user', [
            'titulo' => 'Confirma tu cuenta'
        ]);
    }
}
