<?php

namespace Deivz\DesafioSoftexpert\interfaces;

interface RepositoryInterface
{
	public function save(): void;
	public function findByUniqueKey(): int;
	public function findAll(int $page, int $limit): array;
	public function findByUuid(string $uuid): array;
	public function update(): void;
}
