<?php
namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, array $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, array $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    private function addRoute(string $method, string $path, array $handler): void
    {
        $this->routes[] = [
            'method'  => strtoupper($method),
            'path'    => $path,
            'pattern' => $this->convertPathToRegex($path),
            'handler' => $handler
        ];
    }

    private function convertPathToRegex(string $path): string
    {
        // Converte {param} em regex capture group
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $path);
        return '#^' . $pattern . '$#';
    }

    public function dispatch(): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = $this->getCurrentUri();

        foreach ($this->routes as $route) {
            if ($route['method'] !== $requestMethod) {
                continue;
            }

            if (preg_match($route['pattern'], $uri, $matches)) {
                array_shift($matches); // Remove o match completo

                [$controllerClass, $action] = $route['handler'];

                if (!class_exists($controllerClass)) {
                    http_response_code(500);
                    die("Controller '{$controllerClass}' não encontrado.");
                }

                $controller = new $controllerClass();

                if (!method_exists($controller, $action)) {
                    http_response_code(500);
                    die("Ação '{$action}' não encontrada em '{$controllerClass}'.");
                }

                call_user_func_array([$controller, $action], $matches);
                return;
            }
        }

        // Se nenhuma rota for encontrada (404)
        http_response_code(404);
        echo "<!DOCTYPE html><html lang='pt-BR'><head><meta charset='UTF-8'><title>404 - Página Não Encontrada</title><link rel='stylesheet' href='style.css'></head><body style='text-align:center; padding: 50px;'><h1>404 - Ops! Página não encontrada</h1><p>O conteúdo que você procurou não existe no IFolha.</p><a href='index.php' style='display:inline-block; margin-top:20px; padding:10px 20px; background:#286b48; color:white; border-radius:8px;'>Voltar ao Início</a></body></html>";
    }

    private function getCurrentUri(): string
    {
        // 1. Verifica se veio pelo query param `url` (via .htaccess rewrite)
        if (isset($_GET['url']) && !empty($_GET['url'])) {
            $uri = '/' . trim($_GET['url'], '/');
            return $this->cleanUri($uri);
        }

        // 2. Ou lê a partir de REQUEST_URI
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

        // Remove prefixos de subpastas comuns, se houver
        $scriptName = dirname($_SERVER['SCRIPT_NAME'] ?? '');
        if ($scriptName !== '/' && str_starts_with($uri, $scriptName)) {
            $uri = substr($uri, strlen($scriptName));
        }

        return $this->cleanUri($uri);
    }

    private function cleanUri(string $uri): string
    {
        $uri = '/' . trim($uri, '/');
        if ($uri === '' || $uri === '/index.php') {
            return '/';
        }

        // Suporte a caminhos com .php (ex: /noticias.php -> /noticias)
        if (str_ends_with($uri, '.php')) {
            $uri = substr($uri, 0, -4);
        }

        return $uri === '' ? '/' : $uri;
    }
}
