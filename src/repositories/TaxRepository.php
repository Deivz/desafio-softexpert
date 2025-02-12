<?php

namespace Deivz\DesafioSoftexpert\repositories;

use Deivz\DesafioSoftexpert\controllers\ConnectionController;
use Deivz\DesafioSoftexpert\interfaces\RepositoryInterface;
use Deivz\DesafioSoftexpert\models\Tax;
use PDO;

class TaxRepository implements RepositoryInterface
{
  private PDO $connection;
  private string $table;
  private Tax $tax;
  private array $tableJoin = [];

  public function __construct(PDO $connection, Tax $tax)
  {
    $this->connection = $connection;
    $this->tax = $tax;
    $this->table = $_ENV["TABLE_TAXES"];
    $this->tableJoin = [
      $_ENV["TABLE_PRODUCT_TYPES"],
    ];
  }

  public function findByUniqueKey(): int
  {
    $sql = "SELECT id FROM {$this->table}
      WHERE product_type = :product_type AND deleted = :deleted
      AND uuid != :uuid
      FOR UPDATE";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindValue(':deleted', 0, PDO::PARAM_INT);
    $stmt->bindValue(':product_type', $this->tax->getProductType(), PDO::PARAM_INT);
    $stmt->bindValue(':uuid', $this->tax->getUuid(), PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->fetch()) {
      return 1;
    }

    return 0;
  }

  public function save(): bool
  {
    $sql = "INSERT INTO {$this->table} (uuid, deleted, active, tax, product_type, created_at)
      VALUES (:uuid, :deleted, :active, :tax, :product_type, :created_at)";
    $stmt = $this->connection->prepare($sql);
    $stmt->execute([
      ':uuid' => $this->tax->getUuid(),
      ':deleted' => 0,
      ':active' => 1,
      ':tax' => $this->tax->getTax(),
      ':product_type' => $this->tax->getProductType(),
      ':created_at' => $this->tax->getCreatedAt()
    ]);

    $insertedId = $this->connection->lastInsertId();

    if ($insertedId > 0) {
      return true;
    }

    return false;
  }

  public function findAll(int $limit, int $offset): array
  {
    $sql = "SELECT t.uuid, t.tax, pt.product_type
    FROM {$this->table} t
    INNER JOIN {$this->tableJoin[0]} pt ON (pt.id = t.product_type AND pt.active = 1)
    WHERE t.active = 1
    ORDER BY pt.product_type ASC
    LIMIT :limit OFFSET :offset";

    $stmt = $this->connection->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function findByUuid(string $uuid): array
  {
    $sql = "SELECT * FROM {$this->table} t
    WHERE t.uuid = :uuid AND t.active = 1";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindValue(':uuid', $uuid, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function update(): bool
  {
    $sql = "UPDATE {$this->table}
    SET tax = :tax, product_type = :product_type, updated_at = :updated_at
    WHERE uuid = :uuid AND active = 1";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindValue(':tax', $this->tax->getTax(), PDO::PARAM_INT);
    $stmt->bindValue(':product_type', $this->tax->getProductType(), PDO::PARAM_INT);
    $stmt->bindValue(':updated_at', $this->tax->getUpdatedAt(), PDO::PARAM_STR);
    $stmt->bindValue(':uuid', $this->tax->getUuid(), PDO::PARAM_STR);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return true;
    }

    return false;
  }

  public function delete(string $uuid): bool
  {
    $sql = "UPDATE {$this->table}
    SET deleted = :deleted, active = :active, updated_at = :updated_at
    WHERE uuid = :uuid";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindValue(':deleted', 1, PDO::PARAM_INT);
    $stmt->bindValue(':active', 0, PDO::PARAM_INT);
    $stmt->bindValue(':updated_at', $this->tax->getUpdatedAt(), PDO::PARAM_STR);
    $stmt->bindValue(':uuid', $uuid, PDO::PARAM_STR);

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
