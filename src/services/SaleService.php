<?php

namespace Deivz\DesafioSoftexpert\services;

use Deivz\DesafioSoftexpert\repositories\SaleRepository;

class SaleService
{
  public function __construct(protected SaleRepository $repository)
  {
    $this->repository = $repository;
  }

  public function create(): bool
  {
    return $this->repository->save();
  }
}
