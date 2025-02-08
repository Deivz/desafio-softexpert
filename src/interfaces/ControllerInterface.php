<?php

namespace Deivz\DesafioSoftexpert\interfaces;

interface ControllerInterface
{
	public function create(array $request): void;
	public function read(): void;
	public function update(): void;
	public function delete(): void;
}
