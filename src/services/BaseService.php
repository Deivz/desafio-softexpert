<?php

namespace Deivz\DesafioSoftexpert\services;

use Deivz\DesafioSoftexpert\interfaces\RepositoryInterface;
use Deivz\DesafioSoftexpert\interfaces\ServiceInterface;

class BaseService implements ServiceInterface
{
  public function __construct(protected RepositoryInterface $repository)
  {
    $this->repository = $repository;
  }

  public function create(): bool
  {
    return $this->repository->save();
  }

  public function edit(): bool
  {
    return $this->repository->update();
  }

  public function getByUniqueKey(): int
  {
    return $this->repository->findByUniqueKey();
  }

  public function getByUuid(string $uuid): array
  {
    return $this->repository->findByUuid($uuid);
  }

  public function getAll(int $page, int $limit): array
  {
    $offset = ($page - 1) * $limit;
    $items = $this->repository->findAll($limit, $offset);

    return $items;
  }
}
