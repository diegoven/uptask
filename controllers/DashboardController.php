<?php

namespace Controllers;

use MVC\Router;

class DashboardController
{
    public static function index(Router $router)
    {
        session_start();

        isAuth();

        $router->render('dashboard/index', [
            'titulo' => 'Proyectos'
        ]);
    }

    public static function createProject(Router $router)
    {
        session_start();

        isAuth();

        $router->render('dashboard/create-project', [
            'titulo' => 'Crear Proyecto'
        ]);
    }

    public static function profile(Router $router)
    {
        session_start();

        isAuth();

        $router->render('dashboard/profile', [
            'titulo' => 'Perfil de Usuario'
        ]);
    }
}
