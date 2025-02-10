<?php

namespace Deivz\DesafioSoftexpert\interfaces;

interface RepositoryInterface
{
	public function save(): bool;
	public function findByUniqueKey(): int;
	public function findAll(int $page, int $limit): array;
	public function findByUuid(string $uuid): array;
	public function update(): bool;
}
