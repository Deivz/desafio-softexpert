<?php

namespace Deivz\DesafioSoftexpert\interfaces;

interface ModelInterface
{
	public function validate(): bool;
	public function setUuid(string $uuid): void;
	public function getSuccessMessage(): string;
	public function getAlreadyExistsMessage(): string;
	public function getNotFoundMessage(): string;
}
