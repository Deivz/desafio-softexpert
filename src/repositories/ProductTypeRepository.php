<?php

namespace Deivz\DesafioSoftexpert\repositories;

use Deivz\DesafioSoftexpert\controllers\ConnectionController;
use Deivz\DesafioSoftexpert\interfaces\RepositoryInterface;
use Deivz\DesafioSoftexpert\models\ProductType;
use PDO;

class ProductTypeRepository implements RepositoryInterface
{
  private PDO $connection;
  private string $table;
  private array $tableJoin = [];
  private ProductType $productType;

  public function __construct(ConnectionController $connectionController, ProductType $productType)
  {
    $this->connection = $connectionController->connect();
    $this->productType = $productType;
    $this->table = $_ENV["TABLE_PRODUCT_TYPES"];
  }

  public function save(): void
  {
    $this->connection->beginTransaction();

    $sql = "INSERT INTO {$this->table} (uuid, deleted, active, product_type, created_at)
      VALUES (:uuid, :deleted, :active, :product_type, :created_at
    )";
    $stmt = $this->connection->prepare($sql);
    $stmt->execute([
      ':uuid' => $this->productType->getUuid(),
      ':deleted' => 0,
      ':active' => 1,
      ':product_type' => $this->productType->getProductType(),
      ':created_at' => $this->productType->getCreatedAt()
    ]);

    if ($this->connection->lastInsertId() > 0) {
      $this->connection->commit();
      return;
    }
    
    $this->connection->rollBack();
  }

  public function findAll(int $limit, int $offset): array
  {
    $sql = "SELECT * FROM {$this->table} pt
    LIMIT :limit OFFSET :offset";

    $stmt = $this->connection->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
