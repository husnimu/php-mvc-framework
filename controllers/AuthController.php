<?php

namespace app\controllers;

use app\models\User;
use app\core\Request;
use app\models\Login;
use app\core\Response;
use app\core\Controller;
use app\core\Application;

class AuthController extends Controller
{

  public function __construct()
  {
    $this->setLayout('auth');
  }

  public function login(Request $request, Response $response)
  {
    $login = new Login();
    if ($request->isPost()) {
      $login->loadData($request->getBody());
      if ($login->validate() && $login->login()) {
        $response->redirect('/');
        return;
      }
      return $this->render('login', [
        'model' => $login
      ]);
    }
    return $this->render('login', ['model' => $login]);
  }

  public function register(Request $request)
  {
    $user = new User();
    if ($request->isPost()) {
      $user->loadData($request->getBody());
      if ($user->validate() && $user->save()) {
        Application::$app->session->setFlash('success', 'Thanks for registering');
        Application::$app->response->redirect('/');
      }

      return $this->render('register', [
        'model' => $user
      ]);
    }
    return $this->render('register', ['model' => $user]);
  }

  public function logout(Request $request, Response $response)
  {
    Application::$app->logout();
    $response->redirect('/');
  }
}
