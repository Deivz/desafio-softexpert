<?php

namespace Deivz\DesafioSoftexpert\interfaces;

interface ProductTypeRepositoryInterface
{
	public function findAllNoPaginationOnlyIfHasTax(): array;
}
