<?php

namespace Controllers;

use Model\Proyecto;
use MVC\Router;

class DashboardController
{
    public static function index(Router $router)
    {
        session_start();
        isAuth();

        $proyectos = Proyecto::belongsTo('propietarioId', $_SESSION['id']);

        $router->render('dashboard/index', [
            'titulo' => 'Proyectos',
            'proyectos' => $proyectos
        ]);
    }

    public static function createProject(Router $router)
    {
        session_start();
        isAuth();

        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $proyecto = new Proyecto($_POST);
            $alertas = $proyecto->validarProyecto();

            if (empty($alertas)) {
                $proyecto->url = md5(uniqid());
                $proyecto->propietarioId = $_SESSION['id'];
                $proyecto->guardar();

                header('Location: /project?id=' . $proyecto->url);
            }
        }

        $router->render('dashboard/create-project', [
            'titulo' => 'Crear Proyecto',
            'alertas' => $alertas
        ]);
    }

    public static function project(Router $router)
    {
        session_start();
        isAuth();

        $url = $_GET['id'];
        if (!$url) header('Location: /dashboard');

        // Verificar el creador del proyecto
        $proyecto = Proyecto::where('url', $url);

        if ($proyecto->propietarioId !== $_SESSION['id']) header('Location: /dashboard');

        $router->render('dashboard/project', [
            'titulo' => $proyecto->proyecto
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
