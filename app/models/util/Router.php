<?php
namespace app\models\util;

class Router
{
    private $routes = [];

    public function addRoute($url, $controller, $method)
    {
        // バリデーションを追加
        if (!is_string($url) || !is_string($controller) || !is_string($method)) {
            throw new \InvalidArgumentException('Invalid route parameters.');
        }

        $this->routes[$url] = compact('controller', 'method');
    }

    public function dispatch($url)
    {
        $route = $this->routes[$url] ?? $this->getDefaultRoute();

        if ($route !== null && isset($route['controller']) && isset($route['method'])) {
            // コントローラーとメソッドの正当性を確認
            $controllerClass = APP_Path . Controller_Path . $route['controller'];
            $method = $route['method'];

            if (class_exists($controllerClass) && method_exists($controllerClass, $method)) {
                // クラスのインスタンス化
                $controllerInstance = new $controllerClass();

                // メソッドの呼び出し
                $controllerInstance->$method();
            } else {
                // ファイルやメソッドが存在しない場合は 404 エラーを表示
                $this->showErrorPage(404);
            }
        } else {
            // デフォルトのルートがない場合は 404 エラーを表示
            $this->showErrorPage(404);
        }
    }

    private function getDefaultRoute()
    {
        // デフォルトのルートがない場合は 404 エラーを表示
        $this->showErrorPage(404);
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
        // リダイレクト
        header("Location: " . $this->generateUrl($routeName));
        exit;
    }

    private function showErrorPage($statusCode)
    {
        // エラーページを表示するなどの処理を追加
        header("HTTP/1.0 $statusCode Not Found");
        echo "Error $statusCode: Page not found";
        exit;
    }
}
