<?php

namespace Controllers;

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
        echo "from create";

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
        }

        $router->render('auth/create', [
            'titulo' => 'Crear tu cuenta'
        ]);
    }

    public static function forgotPassword()
    {
        echo "from forgotPassword";

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
        }
    }

    public static function resetPassword()
    {
        echo "from resetPassword";

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
        }
    }

    public static function message()
    {
        echo "from message";
    }

    public static function confirmUser()
    {
        echo "from confirmUser";
    }
}
