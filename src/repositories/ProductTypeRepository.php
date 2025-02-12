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
  private ProductType $productType;

  public function __construct(PDO $connection, ProductType $productType)
  {
    $this->connection = $connection;
    $this->productType = $productType;
    $this->table = $_ENV["TABLE_PRODUCT_TYPES"];
  }

  public function save(): bool
  {
    $sql = "INSERT INTO {$this->table} (uuid, deleted, active, name, created_at)
      VALUES (:uuid, :deleted, :active, :name, :created_at
    )";
    $stmt = $this->connection->prepare($sql);
    $stmt->execute([
      ':uuid' => $this->productType->getUuid(),
      ':deleted' => 0,
      ':active' => 1,
      ':name' => $this->productType->getName(),
      ':created_at' => $this->productType->getCreatedAt()
    ]);

    $insertedId = $this->connection->lastInsertId();

    if ($insertedId > 0) {
      return true;
    }

    return false;
  }

  public function findByUniqueKey(): int
  {
    $sql = "SELECT id FROM {$this->table}
      WHERE name = :name AND deleted = :deleted
      AND uuid != :uuid
      FOR UPDATE";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindValue(':deleted', 0, PDO::PARAM_INT);
    $stmt->bindValue(':name', $this->productType->getName(), PDO::PARAM_STR);
    $stmt->bindValue(':uuid', $this->productType->getUuid(), PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->fetch()) {
      return 1;
    }

    return 0;
  }

  public function findAll(int $limit, int $offset): array
  {
    $sql = "SELECT * FROM {$this->table} pt
    WHERE pt.active = 1
    ORDER BY pt.product_type ASC
    LIMIT :limit OFFSET :offset";

    $stmt = $this->connection->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function findAllNoPagination(): array
  {
    $sql = "SELECT * FROM {$this->table} pt
    WHERE pt.active = 1
    ORDER BY pt.product_type ASC";

    $stmt = $this->connection->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function findByUuid(string $uuid): array
  {
    $sql = "SELECT * FROM {$this->table} pt
    WHERE pt.uuid = :uuid AND pt.active = 1";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindValue(':uuid', $uuid, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function update(): bool
  {
    $sql = "UPDATE {$this->table}
    SET name = :name, updated_at = :updated_at
    WHERE uuid = :uuid AND active = 1";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindValue(':name', $this->productType->getName(), PDO::PARAM_STR);
    $stmt->bindValue(':updated_at', $this->productType->getUpdatedAt(), PDO::PARAM_STR);
    $stmt->bindValue(':uuid', $this->productType->getUuid(), PDO::PARAM_STR);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return true;
    }

    return false;
  }

  public function countTotal(): int
  {
    $sql = "SELECT COUNT(id) FROM {$this->table} WHERE active = 1";
    $stmt = $this->connection->prepare($sql);
    $stmt->execute();

    return $stmt->fetchColumn();
  }
}
