<?php

namespace Deivz\DesafioSoftexpert\services;

use Deivz\DesafioSoftexpert\interfaces\ServiceInterface;
use Deivz\DesafioSoftexpert\repositories\TaxRepository;

class TaxService implements ServiceInterface
{
  private TaxRepository $repository;

  public function __construct(TaxRepository $repository)
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
    $taxes = $this->repository->findAll($limit, $offset);

    return $taxes;
  }
}
