<?php

namespace Deivz\DesafioSoftexpert\interfaces;

interface ModelInterface
{
	public function validate(): bool;
	public function getSuccessMessage(): string;
	public function getAlreadyExistsMessage(): string;
}
