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
	private string $productType;
	private int $taxId;
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
		$this->productType = isset($request['product_type']) ? $request['product_type'] : "";
		$this->taxId = isset($request['tax_id']) ? $this->convertInt($request['tax_id']) : 0;
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

	public function getProductType(): string
	{
		return $this->productType;
	}

	public function getTaxId(): int
	{
		return $this->taxId;
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

	private function convertInt($numericalString): int
	{
		return intval($numericalString) ? intval($numericalString) : -1;
	}

	public function validate(): bool
	{
		$productType = [
			'product_type' => $this->productType,
			'tax_id' => $this->taxId
		];

		$validationRules = [
			'product_type' => ['RequiredValidation', 'MaxLengthValidation'],
			'tax_id' => [
				'RequiredValidation',
				'IntValidation',
				'PositiveNumberValidation',
			],
		];

		return Validator::validate($productType, $validationRules);
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