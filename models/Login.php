<?php

namespace app\models;

use app\core\Model;
use app\models\User;
use app\core\Application;

class Login extends Model
{

  public string $email = '';
  public string $password = '';

  public function rules(): array
  {
    return [
      'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
      'password' => [self::RULE_REQUIRED]
    ];
  }

  public function labels(): array
  {
    return [
      'email' => 'email',
      'password' => 'Password'
    ];
  }

  public function login()
  {
    $user = new User;
    $user = $user->findOne(['email' => $this->email]);
    if (!$user) {
      $this->addError('email', 'User does not exist with this email');
      return false;
    }
    if (!password_verify($this->password, $user->password)) {
      $this->addError('password', 'Password is incorrect');
      return false;
    }
    return Application::$app->login($user);
  }
}
