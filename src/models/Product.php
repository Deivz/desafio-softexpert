<?php

namespace Deivz\DesafioSoftexpert\models;

use Deivz\DesafioSoftexpert\helpers\UUIDGenerator;
use Deivz\DesafioSoftexpert\helpers\Validator;
use Deivz\DesafioSoftexpert\interfaces\ModelInterface;

class Product implements ModelInterface
{
	private string $uuid;
	private int $deleted;
	private int $active;
	private string $name;
	private int $price;
	private int $amount;
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
		$this->price = isset($request['price']) ? $this->convertPrice($request['price']) : 0;
		$this->productType = isset($request['product_type']) ? $this->convertInt($request['product_type']) : 0;
		$this->amount = isset($request['amount']) ? $this->convertInt($request['amount']) : 0;
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

	public function getPrice(): int
	{
		return $this->price;
	}

	public function getAmount(): int
	{
		return $this->amount;
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

	private function convertPrice($price): int
	{
		$price = str_replace(',', '.', $price);

		if (!preg_match('/^\d+(\.\d{1,2})?$/', $price)) {
			return -1;
		}

		$priceFloat = floatval($price);
		$convertedPrice = intval($priceFloat * 100);
		// $convertedPrice = intval(round($priceFloat * 100));

		return $convertedPrice;
	}

	private function convertInt($numericalString): int
	{
		return intval($numericalString) ? intval($numericalString) : -1;
	}

	public function validate(): bool
	{
		$product = [
			'name' => $this->name,
			'price' => $this->price,
			'product_type' => $this->productType,
			'amount' => $this->amount
		];

		$validationRules = [
			'name' => ['RequiredValidation', 'MaxLengthValidation'],
			'price' => [
				'RequiredValidation',
				'IntValidation',
				'MaxNumberValidation',
				'PositiveNumberValidation',
				'PriceConvertionValidation',
			],
			'product_type' => [
				'RequiredValidation',
				'IntValidation',
				'PositiveNumberValidation',
			],
			'amount' => [
				'RequiredValidation',
				'IntValidation',
				'MaxNumberValidation',
				'PositiveNumberValidation',
			],
		];

		return Validator::validate($product, $validationRules);
	}

	public function getSuccessMessage(): string
	{
		return 'Produto cadastrado com sucesso!';
	}

	public function getAlreadyExistsMessage(): string
	{
		return 'Este produto já está cadastrado!';
	}
	
	public function getNotFoundMessage(): string
	{
		return 'Produto não encontrado!';
	}
}