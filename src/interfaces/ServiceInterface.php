<?php

namespace Deivz\DesafioSoftexpert\interfaces;

interface ServiceInterface
{
	public function create();
	public function getByUniqueKey(): int;
	public function getByUuid(string $uuid): array;
	public function getAll(int $page, int $limit): array;
	public function edit();
}
