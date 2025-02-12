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

  public function __construct(PDO $connection, Tax $tax)
  {
    $this->connection = $connection;
    $this->tax = $tax;
    $this->table = $_ENV["TABLE_TAXES"];
  }

  public function findByUniqueKey(): int
  {
    $sql = "SELECT id FROM {$this->table}
      WHERE name = :name AND deleted = :deleted
      AND uuid != :uuid
      FOR UPDATE";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindValue(':deleted', 0, PDO::PARAM_INT);
    $stmt->bindValue(':name', $this->tax->getName(), PDO::PARAM_STR);
    $stmt->bindValue(':uuid', $this->tax->getUuid(), PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->fetch()) {
      return 1;
    }

    return 0;
  }

  public function save(): bool
  {
    $sql = "INSERT INTO {$this->table} (uuid, deleted, active, name, tax, created_at)
      VALUES (:uuid, :deleted, :active, :name, :tax, :created_at)";
    $stmt = $this->connection->prepare($sql);
    $stmt->execute([
      ':uuid' => $this->tax->getUuid(),
      ':deleted' => 0,
      ':active' => 1,
      ':name' => $this->tax->getName(),
      ':tax' => $this->tax->getTax(),
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
    $sql = "SELECT t.uuid, t.name, t.tax
    FROM {$this->table} t
    WHERE t.active = 1
    ORDER BY t.name ASC
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
    SET name = :name, tax = :tax, updated_at = :updated_at
    WHERE uuid = :uuid AND active = 1";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindValue(':tax', $this->tax->getTax(), PDO::PARAM_INT);
    $stmt->bindValue(':name', $this->tax->getName(), PDO::PARAM_STR);
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
