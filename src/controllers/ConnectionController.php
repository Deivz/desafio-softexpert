<?php

namespace Deivz\DesafioSoftexpert\controllers;

use Deivz\DesafioSoftexpert\interfaces\ConnectionInterface;
use PDO;

class ConnectionController implements ConnectionInterface
{
  public function __construct(
    private string $host,
    private string $port,
    private string $user,
    private string $password,
    private string $name
  ) {}

  public function connect(): PDO
  {
    $this->port = (int) $this->port;

    return new PDO(sprintf(
      "pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s;",
      $this->host,
      $this->port,
      $this->name,
      $this->user,
      $this->password,
    ), $this->user, $this->password, [
      PDO::ATTR_EMULATE_PREPARES => false,
      PDO::ATTR_STRINGIFY_FETCHES => false,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
  }
}
