<?php

namespace app\core;

class Application
{

  public static string $ROOT_DIR;

  public string $layout = 'main';
  public string $userClass;
  public Router $router;
  public Request $request;
  public Response $response;
  public Session $session;
  public Database $db;
  public static Application $app;
  public ?Controller $controller = null;
  public ?DbModel $user;

  public function __construct($rootPath, array $config)
  {
    self::$ROOT_DIR = $rootPath;
    self::$app = $this;
    $this->userClass = $config['userClass'];
    $this->request = new Request();
    $this->response = new Response();
    $this->session = new Session();
    $this->router = new Router($this->request, $this->response);
    $this->db = new Database($config['db']);

    $primaryValue = $this->session->get('user');
    if ($primaryValue) {
      $primaryKey = (new $this->userClass)->primaryKey();
      $this->user = (new $this->userClass)->findOne([$primaryKey => $primaryValue]);
    } else {
      $this->user = null;
    }
  }

  public function run()
  {
    // $this->router->resolve();
    try {
      echo $this->router->resolve();
    } catch (\Exception $e) {
      $this->response->setStatusCode($e->getCode());
      echo $this->router->renderView("_error", [
        'exception' => $e
      ]);
    }
  }

  public function getController(): Controller
  {
    return $this->controller;
  }

  public function setController(Controller $controller): void
  {
    $this->controller = $controller;
  }

  public function login(DbModel $user)
  {
    $this->user = $user;
    $primaryKey = $user->primaryKey();
    $primaryKeyValue = $user->{$primaryKey};
    $this->session->set('user', $primaryKeyValue);
    return true;
  }

  public function logout()
  {
    $this->user = null;
    $this->session->remove('user');
  }

  public static function isGuest()
  {
    return !self::$app->user;
  }
}