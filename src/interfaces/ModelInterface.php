<?php

namespace Deivz\DesafioSoftexpert\interfaces;

interface ModelInterface
{
	public function save(): void;
	public function get(): void;
	public function update(): void;
	public function delete(): void;
}
