<?php

namespace Deivz\DesafioSoftexpert\interfaces;

use PDO;

interface ConnectionInterface
{
  public function connect(): PDO;
}
