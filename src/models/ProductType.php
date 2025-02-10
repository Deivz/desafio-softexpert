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

	public function getCreatedAt(): string
	{
		return $this->createdAt;
	}

	public function getUpdatedAt(): string
	{
		return $this->updatedAt;
	}

	public function validate(): bool
	{
		$productType = [
			'product_type' => $this->productType,
		];

		$validationRules = [
			'product_type' => ['RequiredValidation', 'MaxLengthValidation'],
		];

		return Validator::validate($productType, $validationRules);
	}

	public function getSuccessMessage(): string
	{
		return 'Tipo de produto cadastrado com sucesso!';
	}
}