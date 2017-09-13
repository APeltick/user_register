<?php

require __DIR__ . '/autoload.php';
require __DIR__ . '/config.php';

$action = $_POST['action'] ? $_POST['action'] : 'index';
$controller = new \App\Controllers\Form();
$data = $controller->action($action);
if ($data) {
  echo json_encode($data);
  return;
}



