<?php
namespace app\models\util;

class Router
{
    private $routes = [];

    public function addRoute($url, $controller, $method)
    {
        $this->routes[$url] = compact('controller', 'method');
    }

    public function dispatch($url)
    {
        $route = $this->routes[$url] ?? $this->getDefaultRoute();

        if ($route !== null && isset($route['controller']) && isset($route['method'])) {
            $controller = APP_Path . Controller_Path . $route['controller'];

            if (file_exists($controller . ".php")) {
                include_once $controller . ".php";

                // クラスのインスタンス化
                $controllerInstance = new $controller();

                // メソッドの呼び出し
                $controllerInstance->{$route['method']}();
            } else {
                // ファイルが存在しない場合は 404 エラーを表示
                header("HTTP/1.0 404 Not Found");
            }
        } else {
            // デフォルトのルートがない場合は 404 エラーを表示
            header("HTTP/1.0 404 Not Found");
        }
    }

    private function getDefaultRoute()
    {
        // デフォルトのルートがない場合は 404 エラーを表示
        header("HTTP/1.0 404 Not Found");
        return null;
    }

    public function generateUrl($routeName, $params = [])
    {
        // ルート名に基づいてURLを生成するロジック
        $url = HOME_URL . $routeName;

        // パラメータがあれば追加
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        return $url;
    }

    public function redirectTo($routeName)
    {
        // ルート名に基づいてURLを生成するロジック
        $url = $this->generateUrl($routeName);

        // リダイレクト
        header("Location: $url");
        exit;
    }
}
?>