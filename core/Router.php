<?php

namespace app\core;

use app\core\exception\NotFound;

class Router
{
  public Request $request;
  public Response $response;
  protected array $routes = [];

  public function __construct(Request $request, Response $response)
  {
    $this->request = $request;
    $this->response = $response;
  }

  public function get($path, $callback)
  {
    $this->routes['get'][$path] = $callback;
  }

  public function post($path, $callback)
  {
    $this->routes['post'][$path] = $callback;
  }

  public function resolve()
  {
    $path = $this->request->getPath();
    $method = $this->request->method();

    $callback = $this->routes[$method][$path] ?? false;
    if (!$callback) {
      // // echo "Not Found";
      // // exit();
      // http_response_code(404);
      // Application::$app->response->setStatusCode(404);
      // $this->response->setStatusCode(404);
      // // return "Not Found";
      // // return $this->renderContent('Not Found');
      // return $this->renderView("code/_404");

      // throw new \Exception('Not Found');
      throw new NotFound();

      // $e = new \Exception('Not Found', 404);
      // $this->response->setStatusCode($e->getCode());
      // echo $this->renderView("_error", [
      //   'exception' => $e
      // ]);
    }
    if (is_string($callback)) {
      return $this->renderView($callback);
    }
    // echo call_user_func($callback);
    if (is_array($callback)) {
      // $callback[0] = new $callback[0]();
      /** @var Controller $controller */
      $controller = new $callback[0]();
      Application::$app->controller = $controller;
      $controller->action = $callback[1];
      foreach ($controller->getMiddlewares() as $middleware) {
        $middleware->execute();
      }
      $callback[0] = $controller;
    }
    return call_user_func($callback, $this->request, $this->response);
  }

  public function renderView($view, $params = [])
  {
    $layoutContent = $this->layoutContent();
    $viewContent = $this->renderOnlyView($view, $params);
    return str_replace('{{ content }}', $viewContent, $layoutContent);
  }

  public function renderContent($viewContent)
  {
    $layoutContent = $this->layoutContent();
    return str_replace('{{ content }}', $viewContent, $layoutContent);
  }

  protected function layoutContent()
  {
    $layout = Application::$app->layout;
    if (Application::$app->controller) {
      $layout = Application::$app->controller->layout;
    }
    ob_start();
    include_once Application::$ROOT_DIR . "/views/layouts/$layout.php";
    return ob_get_clean();
  }

  protected function renderOnlyView($view, $params)
  {
    foreach ($params as $key => $value) {
      $$key = $value;
    }
    ob_start();
    include_once Application::$ROOT_DIR . "/views/$view.php";
    return ob_get_clean();
  }
}
