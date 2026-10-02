<?php
// Inicia sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Autoloader para classes no namespace App\...
spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

// Função auxiliar para gerar URLs compatíveis com raiz e subpastas do XAMPP
if (!function_exists('url')) {
    function url(string $path = ''): string {
        $scriptDir = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
        $cleanPath = '/' . ltrim($path, '/');
        if ($scriptDir === '' || $scriptDir === '/' || $scriptDir === '\\') {
            return $cleanPath;
        }
        return $scriptDir . $cleanPath;
    }
}
