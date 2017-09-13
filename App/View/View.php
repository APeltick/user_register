<?php

namespace App\View;


class View
{
  protected $storage;

  public function display($template, $data = [])
  {
    include $template;
  }
}
