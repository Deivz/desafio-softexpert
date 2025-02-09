<?php

namespace Deivz\DesafioSoftexpert\services;

use Deivz\DesafioSoftexpert\interfaces\ServiceInterface;
use Deivz\DesafioSoftexpert\repositories\ProductTypeRepository;

class ProductTypeService implements ServiceInterface
{
  private ProductTypeRepository $productTypeRepository;

  public function __construct(ProductTypeRepository $productTypeRepository)
  {
    $this->productTypeRepository = $productTypeRepository;
  }

  public function create(): void
  {
    $this->productTypeRepository->save();
  }

  public function getAll(int $page, int $limit): array
  {
    $offset = ($page - 1) * $limit;
    $productTypes = $this->productTypeRepository->findAll($limit, $offset);

    return $productTypes;
  }
}
