<?php

namespace Deivz\DesafioSoftexpert\interfaces;

interface ServiceInterface
{
	public function create();
	public function getByUniqueKey(): array;
	public function getAll(int $page, int $limit): array;
}
