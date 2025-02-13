<?php

namespace Deivz\DesafioSoftexpert\services;

use Deivz\DesafioSoftexpert\models\Product;

class ProductService extends BaseService
{
  public function getAll(int $page, int $limit): array
  {
    $offset = ($page - 1) * $limit;
    $products = $this->repository->findAll($limit, $offset);

    $groupedProducts = [];

    foreach ($products as $product) {
      $uuid = $product['uuid'];

      if (!isset($groupedProducts[$uuid])) {
        $groupedProducts[$uuid] = [
          'uuid' => $product['uuid'],
          'name' => $product['name'],
          'price' => ($product['price'] / 100),
          'amount' => $product['amount'],
          'product_type' => $product['product_type'],
          'tax' => 0,
          'tax_price' => 0,
          'price_per_product' => 0,
          'tax_details' => [],
        ];
      }

      $tax = $product['tax'] / 10000;
      $groupedProducts[$uuid]['tax'] += $tax;
      $groupedProducts[$uuid]['tax_details'][$product['tax_name']] = $product['tax'];
    }

    foreach ($groupedProducts as &$product) {
      $product['tax_price'] = $product['price'] * $product['tax'];
      $product['price_per_product'] = $product['price'] + $product['tax_price'];
    }

    return array_values($groupedProducts);
  }

  public function getByUuid(string $uuid): array
  {
    $products = $this->repository->findByUuid($uuid);

    if (empty($products)) {
      return [];
    }

    $groupedProduct = [
      'uuid' => $products[0]['uuid'],
      'name' => $products[0]['name'],
      'price' => ($products[0]['price'] / 100),
      'amount' => $products[0]['amount'],
      'product_type' => $products[0]['product_type'],
      'tax' => 0,
      'tax_price' => 0,
      'price_per_product' => 0,
      'tax_details' => [],
    ];

    foreach ($products as $product) {
      $tax = $product['tax'] / 10000;
      $groupedProduct['tax'] += $tax;
      $groupedProduct['tax_details'][$product['tax_name']] = $product['tax'];
    }

    $groupedProduct['tax_price'] = $groupedProduct['price'] * $groupedProduct['tax'];
    $groupedProduct['price_per_product'] = $groupedProduct['price'] + $groupedProduct['tax_price'];

    return $groupedProduct;
  }
}
