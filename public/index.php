<?php

require_once __DIR__ . '/../includes/app.php';

use Controllers\DashboardController;
use Controllers\LoginController;
use Controllers\TareaController;
use MVC\Router;

$router = new Router();

// Login
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);

// Create user
$router->get('/create', [LoginController::class, 'create']);
$router->post('/create', [LoginController::class, 'create']);

// Password recovery form
$router->get('/forgot-password', [LoginController::class, 'forgotPassword']);
$router->post('/forgot-password', [LoginController::class, 'forgotPassword']);

// Reset password
$router->get('/reset-password', [LoginController::class, 'resetPassword']);
$router->post('/reset-password', [LoginController::class, 'resetPassword']);

// User confirmation
$router->get('/message', [LoginController::class, 'message']);
$router->get('/confirm-user', [LoginController::class, 'confirmUser']);

// projects zone
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/create-project', [DashboardController::class, 'createProject']);
$router->post('/create-project', [DashboardController::class, 'createProject']);
$router->get('/project', [DashboardController::class, 'project']);
$router->get('/profile', [DashboardController::class, 'profile']);
$router->post('/profile', [DashboardController::class, 'profile']);

// API for tasks
$router->get('/api/tasks', [TareaController::class, 'index']);
$router->post('/api/task', [TareaController::class, 'create']);
$router->post('/api/task/update', [TareaController::class, 'update']);
$router->post('/api/task/delete', [TareaController::class, 'delete']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
