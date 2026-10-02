<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post;

class PostController extends Controller
{
    private Post $postModel;

    public function __construct()
    {
        $this->postModel = new Post();
    }

    public function noticias(): void
    {
        $this->renderCategoryList(1, 'Notícias', 'noticias', '📰');
    }

    public function eventos(): void
    {
        $this->renderCategoryList(2, 'Eventos', 'eventos', '📅');
    }

    public function palestras(): void
    {
        $this->renderCategoryList(3, 'Palestras', 'palestras', '🎤');
    }

    public function editais(): void
    {
        $this->renderCategoryList(4, 'Editais', 'editais', '📜');
    }

    private function renderCategoryList(int|string $categoria, string $categoriaNome, string $activePage, string $icon): void
    {
        $posts = $this->postModel->getByCategoria($categoria);

        $this->render('posts/index', [
            'activePage'    => $activePage,
            'tituloPagina'  => "{$categoriaNome} — IFolha",
            'categoriaNome' => $categoriaNome,
            'categoriaIcon' => $icon,
            'posts'         => $posts
        ]);
    }

    public function show(string $id): void
    {
        $postId = (int) $id;
        $post = $this->postModel->getById($postId);

        if (!$post) {
            http_response_code(404);
            $this->render('errors/404', ['mensagem' => 'Post não encontrado.'], 'main');
            return;
        }

        // Registra visualização
        $usuarioId = $_SESSION['usuario']['id'] ?? null;
        $this->postModel->addVisualizacao($postId, $usuarioId);
        $post['total_visualizacoes'] = (int) ($post['total_visualizacoes'] ?? 0) + 1;

        $this->render('posts/show', [
            'activePage'   => strtolower($post['categoria_nome']),
            'tituloPagina' => $post['titulo'] . ' — IFolha',
            'post'         => $post
        ]);
    }

    public function curtir(string $id): void
    {
        $postId = (int) $id;
        $usuarioId = $_SESSION['usuario']['id'] ?? null;

        $resultado = $this->postModel->toggleCurtida($postId, $usuarioId);

        $this->json([
            'sucesso' => true,
            'liked'   => $resultado['liked'],
            'total'   => $resultado['total']
        ]);
    }
}
