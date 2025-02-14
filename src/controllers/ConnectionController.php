<?php

namespace Deivz\DesafioSoftexpert\controllers;

use Deivz\DesafioSoftexpert\interfaces\ConnectionInterface;
use PDO;

class ConnectionController implements ConnectionInterface
{
  public function __construct(
    private string $host,
    private string $user,
    private string $password,
    private string $name
  ) {}

  public function connect(): PDO
  {
    $dbId = $_ENV['DB_ID'];

    return new PDO(sprintf(
      "pgsql:host=%s;dbname=%s;user=%s;password=%s;options='endpoint=%s'",
      $this->host,
      $this->name,
      $this->user,
      $this->password,
      $dbId
    ), $this->user, $this->password, [
      PDO::ATTR_EMULATE_PREPARES => false,
      PDO::ATTR_STRINGIFY_FETCHES => false,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
  }
}
