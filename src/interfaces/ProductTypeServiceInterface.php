<?php

namespace Deivz\DesafioSoftexpert\interfaces;

interface ProductTypeServiceInterface
{
	public function getAllNoPaginationOnlyIfHasTax(): array;
}
