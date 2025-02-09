<?php

namespace Deivz\DesafioSoftexpert\services;

use Deivz\DesafioSoftexpert\interfaces\ServiceInterface;
use Deivz\DesafioSoftexpert\repositories\ProductRepository;

class ProductService implements ServiceInterface
{
  private ProductRepository $repository;

  public function __construct(ProductRepository $repository)
  {
    $this->repository = $repository;
  }

  public function create(): void
  {
    $this->repository->save();
  }

  public function getAll(int $page, int $limit): array
  {
    $offset = ($page - 1) * $limit;
    $products = $this->repository->findAll($limit, $offset);

    return array_map(function ($product) {
      $taxPrice = $product['price'] * ($product['tax'] / 10000);
      $priceWithTax = $product['price'] + $taxPrice;
      $product['total'] = ($priceWithTax / 100) * $product['amount'];
      return $product;
    }, $products);
  }
}
