<?php

namespace Deivz\DesafioSoftexpert\services;

class ProductTypeService extends BaseService
{
  public function getAll(int $page, int $limit): array
  {
    $offset = ($page - 1) * $limit;
    $products = $this->repository->findAll($limit, $offset);

    return $this->groupProducts($products);
  }

  public function getByUuid(string $uuid): array
  {
    $products = $this->repository->findByUuid($uuid);
    return $this->groupProducts([$products])[0] ?? [];
  }

  private function groupProducts(array $products): array
  {
    $groupedProducts = [];

    foreach ($products as $product) {
      $uuid = $product['uuid'];

      if (!isset($groupedProducts[$uuid])) {
        $groupedProducts[$uuid] = [
          'uuid' => $product['uuid'],
          'name' => $product['name'],
          'taxes' => [],
        ];
      }

      $groupedProducts[$uuid]['taxes'][] = $product['tax_name'];
    }

    // Remove duplicatas na lista de taxas
    foreach ($groupedProducts as &$product) {
      $product['taxes'] = array_unique($product['taxes']);
    }

    return array_values($groupedProducts);
  }
}
