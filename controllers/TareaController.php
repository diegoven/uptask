<?php

namespace Controllers;

use Model\Proyecto;
use Model\Tarea;

class TareaController
{
    public static function index()
    {
        $proyectoId = $_GET['id'];

        if (!$proyectoId) header('Location: /dashboard');

        $proyecto = Proyecto::where("url", $proyectoId);

        session_start();

        if (!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) header('Location: /404');

        $tareas = Tarea::belongsTo("proyectoId", $proyecto->id);

        echo json_encode(['tareas' => $tareas]);
    }

    public static function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            session_start();

            $proyecto = Proyecto::where('url', $_POST['proyectoUrl']);

            if (!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Ocurrió un error al agregar la tarea'
                ];

                echo json_encode($respuesta);
                return;
            }

            $tarea = new Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;
            $resultado = $tarea->guardar();

            $respuesta = [
                'tipo' => 'exito',
                'id' => $resultado['id'],
                'mensaje' => 'Tarea creada correctamente'
            ];

            echo json_encode($respuesta);
        }
    }

    public static function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
        }
    }

    public static function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
        }
    }
}
