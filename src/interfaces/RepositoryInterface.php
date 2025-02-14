<?php

namespace Deivz\DesafioSoftexpert\interfaces;

interface RepositoryInterface
{
	public function save(): bool;
	public function findByUniqueKey(): int;
	public function findAll(int $page, int $limit): array;
	public function findAllNoPagination(array $uuidList): array;
	public function findByUuid(string $uuid): array;
	public function countTotal(): int;
	public function update(): bool;
	public function delete(string $uuid): bool;
}
