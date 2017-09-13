<?php

namespace App\Models;

use App\Db;

class User
{
  protected static $table = 'users';

    public $name;
    public $email;
    public $ter_id;

    public function getTerritory () {
      return Territory::getById($this->ter_id)->ter_address;
    }

  public static function getEmail($email) {
    $res = Db::instance()->query(
      'SELECT * FROM ' . self::$table . ' WHERE email = :email',
      [':email' => $email],
      self::class
    );
    return $res[0];
  }

  public function save() {
    {
      return Db::instance()->execute(
        'INSERT INTO ' . self::$table .
        '(name, email, ter_id) VALUES (:name,:email,:ter_id)',
        [':name' => $this->name, ':email' => $this->email, ':ter_id' => $this->ter_id]
      );
    }
  }

}