<?php

namespace Deivz\DesafioSoftexpert\interfaces;

interface ControllerInterface
{
	public function create(): void;
	public function checkExistance(): int;
	public function read(array $params): void;
	public function readByUuid(array $params): void;
	public function new(): void;
	public function update(array $params): void;
}
