<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post;
use App\Models\Categoria;

class AdminController extends Controller
{
    private Post $postModel;
    private Categoria $categoriaModel;

    public function __construct()
    {
        $this->postModel = new Post();
        $this->categoriaModel = new Categoria();
    }

    /**
     * Garante que apenas administradores autenticados tenham acesso
     */
    private function requireAdmin(): void
    {
        if (empty($_SESSION['usuario']) || ($_SESSION['usuario']['tipo'] ?? '') !== 'admin') {
            $_SESSION['login_erro'] = 'Acesso restrito. Faça login como administrador para acessar o painel.';
            $this->redirect(url('/'));
        }
    }

    /**
     * Listagem geral de publicações no painel
     */
    public function index(): void
    {
        $this->requireAdmin();

        $posts = $this->postModel->getAllAdmin();

        $this->render('admin/posts/index', [
            'activePage'   => 'admin',
            'tituloPagina' => 'Painel Administrativo — IFolha',
            'posts'        => $posts
        ]);
    }

    /**
     * Formulário de criação de publicação
     */
    public function create(): void
    {
        $this->requireAdmin();

        $categorias = $this->categoriaModel->getAll();

        $this->render('admin/posts/form', [
            'activePage'   => 'admin',
            'tituloPagina' => 'Nova Publicação — Painel IFolha',
            'categorias'   => $categorias,
            'post'         => null,
            'action'       => '/admin/posts/novo'
        ]);
    }

    /**
     * Salva nova publicação no banco
     */
    public function store(): void
    {
        $this->requireAdmin();

        $titulo      = trim($_POST['titulo'] ?? '');
        $categoriaId = (int) ($_POST['categoria_id'] ?? 0);
        $resumo      = trim($_POST['resumo'] ?? '');
        $conteudo    = trim($_POST['conteudo'] ?? '');
        $publicado   = isset($_POST['publicado']) ? 1 : 0;

        $dataEvento  = !empty($_POST['data_evento']) ? $_POST['data_evento'] : null;
        $horario     = !empty($_POST['horario_evento']) ? $_POST['horario_evento'] : null;
        $local       = !empty($_POST['local_evento']) ? trim($_POST['local_evento']) : null;

        if (empty($titulo) || empty($conteudo) || empty($categoriaId)) {
            $_SESSION['flash_erro'] = 'Por favor, preencha todos os campos obrigatórios (Título, Categoria e Conteúdo).';
            $this->redirect(url('/admin/posts/novo'));
        }

        $postId = $this->postModel->create([
            'titulo'       => $titulo,
            'resumo'       => $resumo,
            'conteudo'     => $conteudo,
            'categoria_id' => $categoriaId,
            'autor_id'     => $_SESSION['usuario']['id'] ?? null,
            'publicado'    => $publicado
        ]);

        $this->postModel->saveEvento($postId, $dataEvento, $horario, $local);

        $_SESSION['flash_sucesso'] = 'Publicação criada com sucesso! 🌸';
        $this->redirect(url('/admin'));
    }

    /**
     * Formulário de edição
     */
    public function edit(string $id): void
    {
        $this->requireAdmin();

        $postId = (int) $id;
        $post = $this->postModel->getById($postId);

        if (!$post) {
            $_SESSION['flash_erro'] = 'Publicação não encontrada.';
            $this->redirect(url('/admin'));
        }

        $categorias = $this->categoriaModel->getAll();

        $this->render('admin/posts/form', [
            'activePage'   => 'admin',
            'tituloPagina' => 'Editar Publicação — Painel IFolha',
            'categorias'   => $categorias,
            'post'         => $post,
            'action'       => "/admin/posts/editar/{$postId}"
        ]);
    }

    /**
     * Atualiza publicação existente
     */
    public function update(string $id): void
    {
        $this->requireAdmin();

        $postId = (int) $id;

        $titulo      = trim($_POST['titulo'] ?? '');
        $categoriaId = (int) ($_POST['categoria_id'] ?? 0);
        $resumo      = trim($_POST['resumo'] ?? '');
        $conteudo    = trim($_POST['conteudo'] ?? '');
        $publicado   = isset($_POST['publicado']) ? 1 : 0;

        $dataEvento  = !empty($_POST['data_evento']) ? $_POST['data_evento'] : null;
        $horario     = !empty($_POST['horario_evento']) ? $_POST['horario_evento'] : null;
        $local       = !empty($_POST['local_evento']) ? trim($_POST['local_evento']) : null;

        if (empty($titulo) || empty($conteudo) || empty($categoriaId)) {
            $_SESSION['flash_erro'] = 'Por favor, preencha todos os campos obrigatórios.';
            $this->redirect(url("/admin/posts/editar/{$postId}"));
        }

        $this->postModel->update($postId, [
            'titulo'       => $titulo,
            'resumo'       => $resumo,
            'conteudo'     => $conteudo,
            'categoria_id' => $categoriaId,
            'publicado'    => $publicado
        ]);

        $this->postModel->saveEvento($postId, $dataEvento, $horario, $local);

        $_SESSION['flash_sucesso'] = 'Publicação atualizada com sucesso! ✨';
        $this->redirect(url('/admin'));
    }

    /**
     * Exclui publicação
     */
    public function delete(string $id): void
    {
        $this->requireAdmin();

        $postId = (int) $id;
        $this->postModel->delete($postId);

        $_SESSION['flash_sucesso'] = 'Publicação excluída com sucesso!';
        $this->redirect(url('/admin'));
    }
}
