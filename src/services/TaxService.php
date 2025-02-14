<?php

namespace Deivz\DesafioSoftexpert\services;

class TaxService extends BaseService
{
  public function delete(string $uuid): bool
  {
    return $this->repository->delete($uuid);
  }
}
