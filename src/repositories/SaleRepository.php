<?php

namespace Deivz\DesafioSoftexpert\repositories;

use Deivz\DesafioSoftexpert\controllers\ConnectionController;
use Deivz\DesafioSoftexpert\interfaces\RepositoryInterface;
use Deivz\DesafioSoftexpert\models\Sale;
use PDO;

class SaleRepository implements RepositoryInterface
{
  private PDO $connection;
  private string $table;
  private Sale $sale;

  public function __construct(ConnectionController $connectionController, Sale $sale)
  {
    $this->connection = $connectionController->connect();
    $this->sale = $sale;
    $this->table = $_ENV["TABLE_SALES"];
  }

  public function save(): void
  {
    $this->connection->beginTransaction();

    $sql = "INSERT INTO {$this->table} (uuid, deleted, active, id_product, sell_price, amount, created_at)
      VALUES (:uuid, :deleted, :active, :id_product, :sell_price, :amount, :created_at
    )";
    $stmt = $this->connection->prepare($sql);
    $stmt->execute([
      ':uuid' => $this->sale->getUuid(),
      ':deleted' => 0,
      ':active' => 1,
      ':product_id' => $this->sale->getProductId(),
      ':sell_price' => $this->sale->getSellPrice(),
      ':amount' => $this->sale->getAmount(),
      ':created_at' => $this->sale->getCreatedAt()
    ]);

    if ($this->connection->lastInsertId() > 0) {
      $this->connection->commit();
      return;
    }
    
    $this->connection->rollBack();
  }

  public function findByUniqueKey(): int
  {
    $sql = "SELECT id FROM {$this->table}
      WHERE uuid = :uuid AND deleted = :deleted
      FOR UPDATE";
    $stmt = $this->connection->prepare($sql);
    $stmt->execute([
      ':deleted' => 0,
      ':uuid' => $this->sale->getUuid(),
    ]);

    if($stmt->fetch()){
      return 1;
    }

    return 0;
  }

  public function findAll(int $limit, int $offset): array
  {
    $sql = "SELECT * FROM {$this->table} s
    WHERE s.active = 1
    LIMIT :limit OFFSET :offset";

    $stmt = $this->connection->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
