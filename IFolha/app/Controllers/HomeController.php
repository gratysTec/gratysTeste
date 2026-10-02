<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post;

class HomeController extends Controller
{
    public function index(): void
    {
        $postModel = new Post();

        $destaque = $postModel->getFeatured();
        $ultimosPosts = $postModel->getAll(6);

        $this->render('home/index', [
            'activePage'   => 'inicio',
            'tituloPagina' => 'Início — IFolha',
            'destaque'     => $destaque,
            'posts'        => $ultimosPosts
        ]);
    }
}
