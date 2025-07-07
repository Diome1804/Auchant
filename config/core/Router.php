<?php

namespace App\Config\Core;

class Router
{
    private static array $routes = [];

    public static function get(string $uri, string $controller, string $action): void
    {
        self::$routes['GET'][$uri] = ['controller' => $controller, 'action' => $action];
    }

    public static function post(string $uri, string $controller, string $action): void
    {
        self::$routes['POST'][$uri] = ['controller' => $controller, 'action' => $action];
    }

   public static function resolve(): void
{
    $method = $_SERVER['REQUEST_METHOD'];
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    // Liste des routes publiques
    $publicRoutes = ['/', '/login', '/logout'];

    // Vérifier la présence du cookie auth_token pour les routes protégées
    if (!in_array($uri, $publicRoutes)) {
        if (!isset($_COOKIE['auth_token']) || empty($_COOKIE['auth_token'])) {
            header('Location: /login');
            exit;
        }

        // Optionnel : vérifier que le token est valide (si tu stockes les tokens côté serveur)
    }

    // Redirection vers /list si on accède à /
    if ($uri === '/') {
        header('Location: /list');
        exit;
    }

    if (isset(self::$routes[$method][$uri])) {
        $route = self::$routes[$method][$uri];
        $controllerName = $route['controller'];
        $action = $route['action'];

        $controller = new $controllerName();
        $controller->$action();
    } else {
        // 404 - Route non trouvée
        http_response_code(404);
        require_once __DIR__ . '/../../template/commande/404.php';
    }
}

}