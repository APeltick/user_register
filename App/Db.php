<?php

namespace App;

class Db
{
  use Singleton;

  protected static $dbh;

  protected function __construct()
  {
    self::$dbh = new \PDO(
      DSN,
      USER,
      PASSWORD,
      array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")
    );
  }

  public static function execute($sql, $params = [])
  {

    $sth = self::$dbh->prepare($sql);
    $sth->execute($params);
  }

  public static function query($sql, $params = [], $class = \stdClass::class)
  {
    $sth = self::$dbh->prepare($sql);
    $res = $sth->execute($params);
    if (false !== $res) {
      return $sth->fetchAll(\PDO::FETCH_CLASS, $class);
    }
    return [];
  }
}