<?php

namespace Deivz\DesafioSoftexpert\repositories;

use Deivz\DesafioSoftexpert\controllers\ConnectionController;
use Deivz\DesafioSoftexpert\interfaces\RepositoryInterface;
use Deivz\DesafioSoftexpert\models\Sale;
use PDO;

class SaleRepository
{
  private PDO $connection;
  private string $table;
  private Sale $sale;

  public function __construct(PDO $connection, Sale $sale)
  {
    $this->connection = $connection;
    $this->sale = $sale;
    $this->table = $_ENV["TABLE_SALES"];
  }

  public function save(): bool
  {
    $sql = "INSERT INTO {$this->table} (uuid, deleted, active, id_product, sell_price, amount, created_at)
      VALUES (:uuid, :deleted, :active, :id_product, :sell_price, :amount, :created_at
    )";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindValue(':uuid', $this->sale->getUuid(), PDO::PARAM_STR);
    $stmt->bindValue(':deleted', 0, PDO::PARAM_INT);
    $stmt->bindValue(':active', 1, PDO::PARAM_INT);
    $stmt->bindValue(':product_id', $this->sale->getProductId(), PDO::PARAM_INT);
    $stmt->bindValue(':sell_price', $this->sale->getSellPrice(), PDO::PARAM_INT);
    $stmt->bindValue(':amount', $this->sale->getAmount(), PDO::PARAM_INT);
    $stmt->bindValue(':created_at', $this->sale->getCreatedAt(), PDO::PARAM_STR);
    $stmt->execute();

    $insertedId = $this->connection->lastInsertId();

    if ($insertedId > 0) {
      return true;
    }
    
    return false;
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

    if ($stmt->rowCount() == 0) {
      return [];
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
