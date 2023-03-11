<?php

namespace app\core;

use app\core\View;
use app\core\UserModel;
use app\core\db\DbModel;
use app\core\db\Database;

class Application
{

  const EVENT_BEFORE_REQUEST = 'beforeRequest';
  const EVENT_AFTER_REQUEST = 'afterRequest';

  private array $eventListeners = [];

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
  public ?UserModel $user;
  public View $view;

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
    $this->view = new View();

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
    $this->triggerEvent(self::EVENT_BEFORE_REQUEST);
    try {
      echo $this->router->resolve();
    } catch (\Exception $e) {
      $this->response->setStatusCode($e->getCode());
      echo $this->view->renderView("_error", [
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

  public function login(UserModel $user)
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

  public function on($eventName, $callback)
  {
    $this->eventListeners[$eventName][] = $callback;
  }

  public function triggerEvent($eventName)
  {
    $callbacks = $this->eventListeners[$eventName] ?? [];
    foreach ($callbacks as $callback) {
      call_user_func($callback);
    }
  }
}
