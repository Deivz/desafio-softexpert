<?php

namespace Deivz\DesafioSoftexpert\services;

class ProductService extends BaseService
{
  public function getAll(int $page, int $limit): array
  {
    $offset = ($page - 1) * $limit;
    $products = $this->repository->findAll($limit, $offset);

    return array_map(function ($product) {
      $product['tax'] = ($product['tax'] / 10000);
      $product['price'] = ($product['price'] / 100);
      $product['tax_price'] = $product['price'] * $product['tax'];
      $product['price_per_product'] = $product['price'] + $product['tax_price'];
      return $product;
    }, $products);
  }
}
