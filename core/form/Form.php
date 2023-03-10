<?php

namespace app\core\form;

use app\core\Model;
use app\core\form\InputField;
use app\core\form\TextAreaField;

class Form
{

  public static function begin($action, $method)
  {
    echo sprintf('<form action="%s" method="%s">', $action, $method);
    return new Form();
  }

  public static function end()
  {
    echo '</form>';
  }

  public function inputField(Model $model, $attribute)
  {
    return new InputField($model, $attribute);
  }

  public function textAreaField(Model $model, $attribute)
  {
    return new TextAreaField($model, $attribute);
  }
}
