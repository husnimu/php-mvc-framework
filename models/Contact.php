<?php

namespace app\models;

use app\core\Model;

class Contact extends Model
{
  public string $subject = '';
  public string $email = '';
  public string $message = '';

  public function tableName(): string
  {
    return 'contacts';
  }

  public function attributes(): array
  {
    return ['subject', 'email', 'message'];
  }

  public function primaryKey(): string
  {
    return 'id';
  }

  public function labels(): array
  {
    return [
      'subject' => 'Subject',
      'email' => 'Email',
      'message' => 'Message'
    ];
  }

  public function rules(): array
  {
    return [
      'subject' => [self::RULE_REQUIRED],
      'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
      'message' => [self::RULE_REQUIRED]
    ];
  }

  public function getDisplayName(): string
  {
    return $this->subject;
  }

  public function save()
  {
    return true;
  }
}
