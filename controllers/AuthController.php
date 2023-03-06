<?php

namespace app\controllers;

use app\core\Application;
use app\core\Request;
use app\core\Controller;
use app\models\User;

class AuthController extends Controller
{

  public function __construct()
  {
    $this->setLayout('auth');
  }

  public function login()
  {
    return $this->render('login');
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
}
