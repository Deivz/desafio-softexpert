<?php

namespace Deivz\DesafioSoftexpert\models;

use Deivz\DesafioSoftexpert\helpers\UUIDGenerator;
use Deivz\DesafioSoftexpert\helpers\Validator;
use Deivz\DesafioSoftexpert\interfaces\ModelInterface;

class Tax implements ModelInterface
{
	private string $uuid;
	private int $deleted;
	private int $active;
	private string $name;
	private int $tax;
	private int $productType;
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
		$this->tax = isset($request['tax']) ? $this->convertTax($request['tax']) : 0;
		$this->productType = isset($request['product_type']) ? $this->convertInt($request['product_type']) : 0;
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

	public function getTax(): int
	{
		return $this->tax;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getProductType(): int
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

	public function setUuid(string $uuid): void
	{
		$this->uuid = $uuid;
	}

	private function convertTax($tax): int
	{
		$tax = str_replace(',', '.', $tax);

		if (!preg_match('/^\d+(\.\d{1,2})?$/', $tax)) {
			return -1;
		}

		$taxFloat = floatval($tax);
		$convertedTax = intval($taxFloat * 100);

		return $convertedTax;
	}

	private function convertInt($numericalString): int
	{
		return intval($numericalString) ? intval($numericalString) : -1;
	}

	public function validate(): bool
	{
		$product = [
			'name' => $this->name,
			'tax' => $this->tax,
			'product_type' => $this->productType
		];

		$validationRules = [
			'name' => ['RequiredValidation', 'MaxLengthValidation'],
			'tax' => [
				'RequiredValidation',
				'IntValidation',
				'MaxTaxValidation',
				'PositiveNumberValidation',
				'PriceConvertionValidation',
			],
			'product_type' => [
				'RequiredValidation',
				'IntValidation',
				'PositiveNumberValidation',
			],
		];

		return Validator::validate($product, $validationRules);
	}

	public function getSuccessMessage(): string
	{
		return 'Imposto cadastrado com sucesso!';
	}

	public function getAlreadyExistsMessage(): string
	{
		return 'Já existe um imposto cadastrado com este nome!';
	}

	public function getNotFoundMessage(): string
	{
		return 'Imposto não encontrado!';
	}
}