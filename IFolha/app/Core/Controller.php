<?php
namespace App\Core;

abstract class Controller
{
    /**
     * Renderiza uma view dentro de um layout
     *
     * @param string $view Nome da view relativa à pasta Views (ex: 'home/index')
     * @param array $data Dados passados para a view
     * @param string|null $layout Nome do layout em Views/layouts (ex: 'main') ou null para renderizar sem layout
     */
    protected function render(string $view, array $data = [], ?string $layout = 'main'): void
    {
        extract($data);

        $viewFile = __DIR__ . '/../Views/' . $view . '.php';

        if (!file_exists($viewFile)) {
            http_response_code(500);
            die("View '{$view}' não encontrada em {$viewFile}");
        }

        // Se houver layout, captura o conteúdo da view em buffer e passa como $content para o layout
        if ($layout !== null) {
            ob_start();
            require $viewFile;
            $content = ob_get_clean();

            $layoutFile = __DIR__ . '/../Views/layouts/' . $layout . '.php';
            if (file_exists($layoutFile)) {
                require $layoutFile;
                return;
            }
            // Se o layout não existir, imprime o conteúdo diretamente
            echo $content;
            return;
        }

        require $viewFile;
    }

    /**
     * Retorna uma resposta JSON
     */
    protected function json(mixed $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Redireciona para uma URL
     */
    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }
}
