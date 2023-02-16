<?php

namespace app\models;

use app\core\Model;

class Register extends Model
{

  public string $firstname = '';
  public string $lastname = '';
  public string $email = '';
  public string $password = '';
  public string $confirmpassword = '';

  public function rules(): array
  {
    return [
      'firstname' => [self::RULE_REQUIRED],
      'lastname' => [self::RULE_REQUIRED],
      'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
      'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8]],
      'confirmpassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']]
    ];
  }

  public function register()
  {
    return 'Creating new user';
  }
}