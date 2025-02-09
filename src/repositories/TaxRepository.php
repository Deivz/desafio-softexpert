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

  public function __construct(ConnectionController $connectionController, Tax $tax)
  {
    $this->connection = $connectionController->connect();
    $this->tax = $tax;
    $this->table = $_ENV["TABLE_TAXES"];
  }

  public function save(): void
  {
    $this->connection->beginTransaction();

    $sql = "INSERT INTO {$this->table} (uuid, deleted, active, tax, product_type, created_at)
      VALUES (:uuid, :deleted, :active, :tax, :product_type, :created_at
    )";
    $stmt = $this->connection->prepare($sql);
    $stmt->execute([
      ':uuid' => $this->tax->getUuid(),
      ':deleted' => 0,
      ':active' => 1,
      ':tax' => $this->tax->getTax(),
      ':product_type' => $this->tax->getProductType(),
      ':created_at' => $this->tax->getCreatedAt()
    ]);

    if ($this->connection->lastInsertId() > 0) {
      $this->connection->commit();
      return;
    }
    
    $this->connection->rollBack();
  }

  public function findAll(int $limit, int $offset): array
  {
    $sql = "SELECT * FROM {$this->table} t
    LIMIT :limit OFFSET :offset";

    $stmt = $this->connection->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
