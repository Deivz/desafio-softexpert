<?php

namespace Deivz\DesafioSoftexpert\models;

use Deivz\DesafioSoftexpert\helpers\UUIDGenerator;
use Deivz\DesafioSoftexpert\helpers\Validator;
use Deivz\DesafioSoftexpert\interfaces\ModelInterface;

class ProductType implements ModelInterface
{
	private string $uuid;
	private int $deleted;
	private int $active;
	private string $name;
	private string $createdAt;
	private string $updatedAt;

	public function __construct(array $request)
	{
		date_default_timezone_set('America/Sao_Paulo');
		$createdAt = date('Y-m-d H:i:s');
		$updatedAt = date('Y-m-d H:i:s');

		$this->uuid = UUIDGenerator::uuidv4();
		$this->deleted = 0;
		$this->active = 1;
		$this->name = isset($request['name']) ? $request['name'] : "";
		$this->createdAt = $createdAt;
		$this->updatedAt = $updatedAt;
	}

	public function getUuid(): string
	{
		return $this->uuid;
	}

	public function getDeleted(): bool
	{
		return $this->deleted;
	}

	public function getActive(): bool
	{
		return $this->active;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getCreatedAt(): string
	{
		return $this->createdAt;
	}

	public function getUpdatedAt(): string
	{
		return $this->updatedAt;
	}

	public function setUuid(string $uuid): void
	{
		$this->uuid = $uuid;
	}

	public function setName(string $name): void
	{
		$this->name = $name;
	}

	public function validate(): bool
	{
		$name = [
			'name' => $this->name,
		];

		$validationRules = [
			'name' => ['RequiredValidation', 'MaxLengthValidation'],
		];

		return Validator::validate($name, $validationRules);
	}

	public function getSuccessMessage(): string
	{
		return 'Tipo de produto cadastrado com sucesso!';
	}

	public function getAlreadyExistsMessage(): string
	{
		return 'Já existe um tipo de produto com este nome!';
	}

	public function getNotFoundMessage(): string
	{
		return 'Tipo de produto não encontrado!';
	}
}
