<?php

namespace app\models;

use app\core\UserModel;

class User extends UserModel
{

  const STATUS_INACTIVE = 0;
  const STATUS_ACTIVE = 1;
  const STATUS_DELETED = 2;

  public string $firstname = '';
  public string $lastname = '';
  public string $email = '';
  public int $status = self::STATUS_INACTIVE;
  public string $password = '';
  public string $confirmpassword = '';

  public function tableName(): string
  {
    return 'users';
  }

  public function attributes(): array
  {
    return ['firstname', 'lastname', 'email', 'status', 'password'];
  }

  public function primaryKey(): string
  {
    return 'id';
  }

  public function getDisplayName(): string
  {
    return $this->firstname . ' ' . $this->lastname;
  }

  public function labels(): array
  {
    return [
      'firstname' => 'First Name',
      'lastname' => 'Last Name',
      'email' => 'Email',
      'password' => 'Password',
      'confirmpassword' => 'Confirm Password'
    ];
  }

  public function rules(): array
  {
    return [
      'firstname' => [self::RULE_REQUIRED],
      'lastname' => [self::RULE_REQUIRED],
      'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class, 'attribute' => 'email']],
      'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8]],
      'confirmpassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']]
    ];
  }

  public function save()
  {
    $this->status = self::STATUS_INACTIVE;
    $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    // return $this->save();
    return parent::save();
  }
}