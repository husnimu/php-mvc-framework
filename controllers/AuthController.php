<?php

namespace app\controllers;

use app\core\Request;
use app\core\Controller;
use app\models\Register;

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
    $register = new Register();
    if ($request->isPost()) {
      $register->loadData($request->getBody());
      if ($register->validate() && $register->register()) {
        return 'success';
      }

      return $this->render('register', [
        'model' => $register
      ]);
    }
    return $this->render('register', ['model' => $register]);
  }
}