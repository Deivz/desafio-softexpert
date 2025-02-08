<?php

namespace Deivz\DesafioSoftexpert\controllers;

use PDO;

class ConnectionController
{
  public function __construct(
    private string $host,
    private int $port,
    private string $user,
    private string $password,
    private string $name
  ) {}

  public function connect(): PDO
  {
    return new PDO("pgsql:" . sprintf(
      "host=%s;port=%d;user=%s;password=%s;dbname=%s",
      $this->host,
      $this->port,
      $this->user,
      $this->password,
      $this->name
    ), $this->user, $this->password, [
      PDO::ATTR_EMULATE_PREPARES => false,
      PDO::ATTR_STRINGIFY_FETCHES => false
    ]);
  }
}
