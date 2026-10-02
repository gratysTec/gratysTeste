<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Usuario;

class AuthController extends Controller
{
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $senha = trim($_POST['senha'] ?? '');

            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->authenticate($email, $senha);

            if ($usuario) {
                $_SESSION['usuario'] = $usuario;

                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    $this->json(['sucesso' => true, 'mensagem' => 'Login realizado com sucesso!', 'usuario' => $usuario]);
                }

                $this->redirect(url('/'));
            } else {
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    $this->json(['sucesso' => false, 'mensagem' => 'E-mail ou senha inválidos.'], 401);
                }

                $_SESSION['login_erro'] = 'E-mail ou senha incorretos.';
                $this->redirect(url('/'));
            }
        }

        $this->render('home/index', [
            'activePage'   => 'inicio',
            'tituloPagina' => 'Login — IFolha'
        ]);
    }

    public function logout(): void
    {
        unset($_SESSION['usuario']);
        session_destroy();
        $this->redirect(url('/'));
    }
}
