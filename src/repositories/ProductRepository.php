<?php

namespace Deivz\DesafioSoftexpert\repositories;

use Deivz\DesafioSoftexpert\interfaces\RepositoryInterface;
use Deivz\DesafioSoftexpert\models\Product;
use PDO;

class ProductRepository implements RepositoryInterface
{
  private PDO $connection;
  private string $table;
  private array $tableJoin = [];
  private Product $product;

  public function __construct(PDO $connection, Product $product)
  {
    $this->connection = $connection;
    $this->product = $product;
    $this->table = $_ENV["TABLE_PRODUCTS"];
    $this->tableJoin = [
      $_ENV["TABLE_PRODUCT_TYPES"],
      $_ENV["TABLE_TAXES"]
    ];
  }

  public function save(): bool
  {
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
    $stmt->bindValue(':name', $this->product->getName(), PDO::PARAM_STR);
    $stmt->bindValue(':uuid', $this->product->getUuid(), PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->fetch()) {
      return 1;
    }

    return 0;
  }

  public function findAll(int $limit, int $offset): array
  {
    $sql = "SELECT p.uuid, p.name, p.price, p.amount, pt.product_type, t.tax
    FROM {$this->table} p
    INNER JOIN {$this->tableJoin[0]} pt ON (p.product_type = pt.id and pt.active = 1)
    INNER JOIN {$this->tableJoin[1]} t ON (pt.id = t.product_type and t.active = 1)
    WHERE p.active = 1
    ORDER BY p.name ASC
    LIMIT :limit OFFSET :offset";

    $stmt = $this->connection->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function findByUuid(string $uuid): array
  {
    $sql = "SELECT p.id, p.uuid, p.name, p.price, p.amount, pt.product_type, t.tax
    FROM {$this->table} p
    INNER JOIN {$this->tableJoin[0]} pt (p.product_type = pt.id and pt.active = 1)
    INNER JOIN {$this->tableJoin[1]} t ON (pt.id = t.product_type and t.active = 1)
    WHERE p.active = 1
    AND p.uuid = :uuid";

    $stmt = $this->connection->prepare($sql);
    $stmt->bindValue(':uuid', $uuid, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function update(): bool
  {
    $sql = "UPDATE {$this->table}
    SET price = :price, amount = :amount, product_type = :product_type, updated_at = :updated_at
    WHERE uuid = :uuid AND active = 1";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindValue(':price', $this->product->getPrice(), PDO::PARAM_INT);
    $stmt->bindValue(':amount', $this->product->getAmount(), PDO::PARAM_INT);
    $stmt->bindValue(':product_type', $this->product->getProductType(), PDO::PARAM_INT);
    $stmt->bindValue(':updated_at', $this->product->getUpdatedAt(), PDO::PARAM_STR);
    $stmt->bindValue(':uuid', $this->product->getUuid(), PDO::PARAM_STR);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return true;
    }

    return false;
  }

  public function newAmount(int $productId, int $amount): bool
  {
    $sql = "UPDATE {$this->table}
      SET amount = :amount, updated_at = :updated_at
      WHERE id = :id AND active = 1";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindValue(':amount', $amount, PDO::PARAM_INT);
    $stmt->bindValue(':updated_at', $this->product->getUpdatedAt(), PDO::PARAM_STR);
    $stmt->bindValue(':id', $productId, PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->rowCount() > 0;
  }

  public function countTotal(): int
  {
    $sql = "SELECT COUNT(id) FROM {$this->table} WHERE active = 1";
    $stmt = $this->connection->prepare($sql);
    $stmt->execute();

    return $stmt->fetchColumn();
  }
}