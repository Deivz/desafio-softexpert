<?php

namespace Deivz\DesafioSoftexpert\models;

use DateInterval;
use DateTime;
use Deivz\DesafioSoftexpert\controllers\ConnectionController;
use Deivz\DesafioSoftexpert\helpers\UUIDGenerator;
use Deivz\DesafioSoftexpert\interfaces\ModelInterface;
use PDO;

use function Deivz\DesafioSoftexpert\helpers\uuidv4;

class Product implements ModelInterface
{
	// private string $name;
	// private int $price;
	private ConnectionController $connectionController;
	private PDO $connection;
	private string $table;
	private array $columns = [];

	public function __construct(ConnectionController $connectionController)
	{
		$this->connectionController = $connectionController;
		$this->table = $_ENV["TABLE_PRODUCTS"];
		$this->columns = [
			'id',
			'uuid',
			'deleted',
			'active',
			'name',
			'price',
			'amount',
			'product_type',
			'created_at',
			'updated_at',
		];
	}

	public function __get($attribute)
	{
		return $this->$attribute;
	}

	public function save(array $request)
	{
		$this->connection = $this->connectionController->connect();
		$this->connection->beginTransaction();
		date_default_timezone_set('America/Sao_Paulo');
		$uuid = UUIDGenerator::uuidv4();
		$createdAt = date('Y-m-d H:i:s');

		$sql = "INSERT INTO
      {$this->table}
      (
        {$this->columns[1]},
        {$this->columns[2]},
        {$this->columns[3]},
        {$this->columns[4]},
        {$this->columns[5]},
        {$this->columns[6]},
        {$this->columns[7]},
        {$this->columns[8]}
      )
      VALUES(:uuid, :deleted, :active, :name, :price, :amount, :product_type, :createdAt);";
		$stmt = $this->connection->prepare($sql);
		$stmt->bindValue(":uuid", $uuid, PDO::PARAM_STR);
		$stmt->bindValue(":deleted", 0, PDO::PARAM_INT);
		$stmt->bindValue(":active", 1, PDO::PARAM_INT);
		$stmt->bindValue(":name", $request['name'], PDO::PARAM_STR);
		$stmt->bindValue(":price", $request['price'], PDO::PARAM_INT);
		$stmt->bindValue(":amount", $request['amount'], PDO::PARAM_INT);
		$stmt->bindValue(":product_type", $request['product_type'], PDO::PARAM_INT);
		$stmt->bindValue(":createdAt", $createdAt, PDO::PARAM_INT);

		$stmt->execute();

		if ($this->connection->lastInsertId() > 0) {
			$this->connection->commit();
			return;
		}

		$this->connection->rollBack();
	}

	public function get(array $params): array
	{
		$productsPerPage = 10;
		$limit = isset($params["limit"]) ? $params["limit"] : $productsPerPage;
		$page = isset($params["page"]) ? $params["page"] - 1 : 0;

		$offset = $page * $limit;

		$products = [];

		$this->connection = $this->connectionController->connect();
		$sql = "SELECT * FROM {$this->table} LIMIT {$limit} OFFSET {$offset};";
		$stmt = $this->connection->query($sql);
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$products[] = $row;
		}

		return $products;
	}

	public function update(): void
	{
		
	}

	public function delete(): void
	{

	}
}
