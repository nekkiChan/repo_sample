<?php
namespace util;

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
            include_once APP_Path . Controller_Path . $route['controller'] . ".php";
            // クラスのインスタンス化
            $controllerInstance = new $controller();
            // メソッドの呼び出し
            $controllerInstance->{$route['method']}();
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

    public function generateUrl($routeName)
    {
        // ルート名に基づいてURLを生成するロジック
        // 例：$routeNameが'test'なら、'/repo_sample/test'を生成
        return HOME_URL . $routeName;
    }

    public function redirectTo($routeName)
    {
        echo 'aaaa';
        // ルート名に基づいてURLを生成するロジック
        $url = $this->generateUrl($routeName);
        echo $url;
        
        // リダイレクト
        header("Location: $url");
        exit;
    }
}
?>