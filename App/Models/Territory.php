<?php
/**
 * Created by PhpStorm.
 * User: alexandr
 * Date: 11.09.17
 * Time: 22:45
 */

namespace App\Models;

use App\Db;

class Territory
{
  protected static $table = 't_koatuu_tree';

  public $ter_id;
  public $ter_pid;
  public $ter_name;
  public $ter_address;
  public $ter_type_id;
  public $ter_level;
  public $ter_mask;
  public $reg_id;

  public static function getRegions ()
  {
    $db = Db::instance();
    return $db->query(
      'SELECT * FROM ' . self::$table . ' WHERE ter_level = 1',
      [],
      self::class
    );
  }

  public static function getCities ($id)
  {
    $db = Db::instance();
    return $db->query(
      'SELECT * FROM ' . self::$table . ' WHERE ter_type_id NOT IN(0,2,3) AND reg_id = :id',
      [':id' => $id],
      static::class
    );
  }

  public static function getArea ($id)
  {
    $db = Db::instance();
    return $db->query(
      'SELECT * FROM ' . self::$table . ' WHERE ter_type_id = 3 AND reg_id = :id',
      [':id' => $id],
      self::class
    );
  }


  public static function getById ($id)
  {
    $db = Db::instance();
    $res = $db->query(
      'SELECT * FROM ' . self::$table . ' WHERE ter_id = :id',
      [':id' => $id],
      self::class
    );
    return $res[0];
  }
}