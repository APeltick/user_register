<?php

namespace App\View;

class View
{
  public function display($template, $data = [])
  {
    include $template;
  }
}
