<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Territory;
use App\View\View;

class Form
{
  protected $view;

  public function __construct()
  {
    $this->view = new View();
  }

  public function action($action)
  {
    return $this->$action();
  }

  public function index()
  {
    $regions = Territory::getRegions();
    $this->view->display(
      'theme/templates/register-form.phtml',
      ['regions' => $regions]
    );
  }

  public function load()
  {
    $ter_id = $_POST['ter_id'];
    $territory = Territory::getById($ter_id);
    $data = '<option value=""></option>';
    $return = [];
    $locations = [];

    if ($territory->ter_type_id == 1 && substr($territory->ter_id, 3) === '0100000') {
      $locations = Territory::getArea($territory->reg_id);
      $return['type'] = 'area';
    }

    if ($ter_id == '8000000000' || $ter_id == '8500000000') {
      $locations = Territory::getArea($territory->reg_id);
      $return['type'] = 'area';
    }

    if ($territory->ter_type_id == 0 && $territory->reg_id !== '85' && $territory->reg_id !== '80') {
      $locations = Territory::getCities($territory->reg_id);
      $return['type'] = 'city';
    }

    foreach ($locations as $location) {
      $data .= '<option value="' . $location->ter_id . '">' .
        $location->ter_name . '</option>';
    }
    $return['data'] = $data;
    return $return;
  }

  public function save()
  {
    if ($user = User::getEmail($_POST['email'])) {
      $data = '<div> User name: ' . $user->name . '</div>' .
        '<div> User email: ' . $user->email . '</div>' .
        '<div> User territory: ' . $user->getTerritory() . '</div>';
      return  ['email' => 'true', 'data' => $data];
    } else {
      $user = new User();
      if ($_POST['area_id']) {
        $user->ter_id = $_POST['area_id'];
      } elseif ($_POST['city_id']) {
        $user->ter_id = $_POST['city_id'];
      } elseif ($_POST['reg_id']) {
        $user->ter_id = $_POST['reg_id'];
      }
      $user->name = $_POST['name'];
      $user->email = $_POST['email'];
      $user->save();
      $data = '<div class="alert alert-success" role="alert">User created</div>';
      return  ['email' => 'false', 'data' => $data];
    }
  }
}