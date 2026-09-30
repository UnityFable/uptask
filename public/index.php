<?php

require_once __DIR__ . '/../includes/app.php';

use Controllers\DashboardController;
use MVC\Router;
use Controllers\LoginController;
use Controllers\TaskController;

$router = new Router();

$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);

$router->get('/register', [LoginController::class, 'register']);
$router->post('/register', [LoginController::class, 'register']);

$router->get('/reset', [LoginController::class, 'reset']);
$router->post('/reset', [LoginController::class, 'reset']);
$router->get('/restore', [LoginController::class, 'restore']);
$router->post('/restore', [LoginController::class, 'restore']);

$router->get('/message', [LoginController::class, 'message']);
$router->get('/confirm', [LoginController::class, 'confirm']);

$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/project', [DashboardController::class, 'project']);
$router->get('/new-project', [DashboardController::class, 'newProject']);
$router->post('/new-project', [DashboardController::class, 'newProject']);
$router->get('/profile', [DashboardController::class, 'profile']);
$router->post('/profile', [DashboardController::class, 'profile']);

$router->get('/api/tasks', [TaskController::class, 'getAll']);
$router->post('/api/task', [TaskController::class, 'create']);
$router->post('/api/task/update', [TaskController::class, 'update']);
$router->post('/api/task/delete', [TaskController::class, 'delete']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->checkRoutes();
