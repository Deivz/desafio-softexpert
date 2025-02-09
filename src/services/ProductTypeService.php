<?php

namespace Deivz\DesafioSoftexpert\services;

use Deivz\DesafioSoftexpert\interfaces\ServiceInterface;
use Deivz\DesafioSoftexpert\repositories\ProductTypeRepository;

class ProductTypeService implements ServiceInterface
{
  private ProductTypeRepository $repository;

  public function __construct(ProductTypeRepository $repository)
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
    $productTypes = $this->repository->findAll($limit, $offset);

    return $productTypes;
  }
}
