<?php
require_once __DIR__ . '/app/bootstrap.php';

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\PostController;
use App\Controllers\RegrasController;
use App\Controllers\AuthController;
use App\Controllers\AdminController;

$router = new Router();

// Rota raiz e início
$router->get('/', [HomeController::class, 'index']);
$router->get('/home', [HomeController::class, 'index']);

// Categorias
$router->get('/noticias', [PostController::class, 'noticias']);
$router->get('/eventos', [PostController::class, 'eventos']);
$router->get('/palestras', [PostController::class, 'palestras']);
$router->get('/editais', [PostController::class, 'editais']);

// Exibição detalhada de post
$router->get('/post/{id}', [PostController::class, 'show']);

// Interações (curtida via AJAX/POST)
$router->post('/curtir/{id}', [PostController::class, 'curtir']);

// Regras acadêmicas do campus
$router->get('/regras', [RegrasController::class, 'index']);

// Autenticação
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

// Painel Administrativo (CRUD de Publicações)
$router->get('/admin', [AdminController::class, 'index']);
$router->get('/admin/posts', [AdminController::class, 'index']);
$router->get('/admin/posts/novo', [AdminController::class, 'create']);
$router->post('/admin/posts/novo', [AdminController::class, 'store']);
$router->get('/admin/posts/editar/{id}', [AdminController::class, 'edit']);
$router->post('/admin/posts/editar/{id}', [AdminController::class, 'update']);
$router->post('/admin/posts/excluir/{id}', [AdminController::class, 'delete']);

// Executa o roteador
$router->dispatch();