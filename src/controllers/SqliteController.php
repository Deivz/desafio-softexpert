<?php

namespace Deivz\DesafioSoftexpert\controllers;

use Deivz\DesafioSoftexpert\interfaces\ConnectionInterface;
use PDO;

class SqliteController implements ConnectionInterface
{
  private $pdo;

  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  public function connect(): PDO
  {
    return $this->pdo;
  }
}
