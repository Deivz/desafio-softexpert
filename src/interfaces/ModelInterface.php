<?php

namespace Deivz\DesafioSoftexpert\interfaces;

interface ModelInterface
{
	public function save(array $request);
	public function get(array $params): array;
	public function update(): void;
	public function delete(): void;
}
