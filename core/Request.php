<?php

namespace app\core;

class Request
{

  public function getPath()
  {
    $path = $_SERVER['PATH_INFO'] ?? '/';
    return $path;
  }

  public function getMethod()
  {
    return strtolower($_SERVER['REQUEST_METHOD']);
  }
}
