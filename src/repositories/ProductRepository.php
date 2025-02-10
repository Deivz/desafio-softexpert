<?php

namespace Deivz\DesafioSoftexpert\repositories;

use Deivz\DesafioSoftexpert\controllers\ConnectionController;
use Deivz\DesafioSoftexpert\interfaces\RepositoryInterface;
use Deivz\DesafioSoftexpert\models\Product;
use PDO;

class ProductRepository implements RepositoryInterface
{
  private PDO $connection;
  private string $table;
  private array $tableJoin = [];
  private Product $product;

  public function __construct(ConnectionController $connectionController, Product $product)
  {
    $this->connection = $connectionController->connect();
    $this->product = $product;
    $this->table = $_ENV["TABLE_PRODUCTS"];
    $this->tableJoin = [
      $_ENV["TABLE_PRODUCT_TYPES"],
      $_ENV["TABLE_TAXES"]
    ];
  }

  public function save(): void
  {
    $this->connection->beginTransaction();

    $sql = "INSERT INTO {$this->table} (uuid, deleted, active, name, price, amount, product_type, created_at)
      VALUES (:uuid, :deleted, :active, :name, :price, :amount, :product_type, :created_at
    )";
    $stmt = $this->connection->prepare($sql);
    $stmt->execute([
      ':uuid' => $this->product->getUuid(),
      ':deleted' => 0,
      ':active' => 1,
      ':name' => $this->product->getName(),
      ':price' => $this->product->getPrice(),
      ':amount' => $this->product->getAmount(),
      ':product_type' => $this->product->getProductType(),
      ':created_at' => $this->product->getCreatedAt()
    ]);

    if ($this->connection->lastInsertId() > 0) {
      $this->connection->commit();
      return;
    }
    
    $this->connection->rollBack();
  }

  public function findByUniqueKey(): array
  {
    $sql = "SELECT id FROM {$this->table}
      WHERE name = :name AND deleted = :deleted
      FOR UPDATE";
    $stmt = $this->connection->prepare($sql);
    $stmt->execute([
      ':deleted' => 0,
      ':name' => $this->product->getName(),
    ]);

    if($stmt->fetch()){
      return $stmt->fetch();
    }

    return [];
  }

  public function findAll(int $limit, int $offset): array
  {
    $sql = "SELECT p.uuid, p.name, p.price, p.amount, pt.product_type, t.tax
    FROM {$this->table} p
    INNER JOIN {$this->tableJoin[0]} pt ON p.product_type = pt.id
    INNER JOIN {$this->tableJoin[1]} t ON pt.id = t.product_type
    WHERE p.active = 1
    LIMIT :limit OFFSET :offset";

    $stmt = $this->connection->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
