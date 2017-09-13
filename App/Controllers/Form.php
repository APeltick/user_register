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
    $this->view = $view = new View();
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

  public function loadCities()
  {
    $reg_id = $_POST['reg_id'];
    $region = Territory::getById($reg_id);
    $data = '<option value=""></option>';
    if ($region->ter_type_id == 0) {
      $cities = Territory::getCities($region->reg_id);
      foreach ($cities as $city) {
        $data .= '<option value="' . $city->ter_id . '">' .
          $city->ter_name . '</option>';
      }
    }
    return $return = ['data' => $data];
  }

  public function loadAreas()
  {
    $city_id = $_POST['city_id'];
    $city = Territory::getById($city_id);
    $cap = substr($city->ter_id, 3);
    $data = '<option value=""></option>';
    if ($city->ter_type_id == 1 && $cap == '0100000') {
      $areas = Territory::getArea($city->reg_id);
      foreach ($areas as $area) {
        $data .= '<option value="' . $area->ter_id . '">' .
          $area->ter_name . '</option>';
      }
    }
    return $return = ['data' => $data];
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
      }
      elseif ($_POST['city_id']) {
        $user->ter_id = $_POST['city_id'];
      }
      elseif ($_POST['reg_id']) {
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