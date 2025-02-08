<?php

namespace Deivz\DesafioSoftexpert\controllers;

use Deivz\DesafioSoftexpert\interfaces\ControllerInterface;
use PDO;

class ProductController implements ControllerInterface
{
	private PDO $connection;

	public function __construct(ConnectionController $connection)
	{
		$this->connection = $connection->connect();
	}

	public function create(): void
	{
		echo "CRIANDO";
	}
	public function read(): void
	{
		echo "LENDO";
	}
	public function update(): void
	{
		echo "ATUALIZANDO";
	}
	public function delete(): void
	{
		echo "DELETANDO";
	}
}
