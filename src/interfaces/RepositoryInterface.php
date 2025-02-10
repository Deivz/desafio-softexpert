<?php

namespace Deivz\DesafioSoftexpert\interfaces;

interface RepositoryInterface
{
	public function save();
	public function findByUniqueKey(): array;
	public function findAll(int $page, int $limit): array;
}
