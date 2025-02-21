<?php

namespace Deivz\DesafioSoftexpert\models;

use Deivz\DesafioSoftexpert\helpers\UUIDGenerator;
use Deivz\DesafioSoftexpert\helpers\Validator;
use Deivz\DesafioSoftexpert\interfaces\ModelInterface;

class Sale implements ModelInterface
{
	private string $uuid;
	private int $deleted;
	private int $active;
	private int $productId;
	private int $sellPrice;
	private int $amount;
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

	public function getProductId(): int
	{
		return $this->productId;
	}

	public function getSellPrice(): int
	{
		return $this->sellPrice;
	}

	public function getAmount(): int
	{
		return $this->amount;
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

	public function setProductId(int $productId): void
	{
		$this->productId = $productId;
	}

	public function setSellPrice(int $sellPrice): void
	{
		$this->sellPrice = $sellPrice;
	}

	private function convertPrice($price): int
	{
		$price = str_replace(',', '.', $price);

		if (!preg_match('/^\d+(\.\d{1,2})?$/', $price)) {
			return -1;
		}

		$priceFloat = floatval($price);
		$convertedPrice = intval($priceFloat * 100);

		return $convertedPrice;
	}

	private function convertInt($numericalString): int
	{
		return intval($numericalString) ? intval($numericalString) : -1;
	}

	public function validate(): bool
	{
		$sale = [
			'amount' => $this->amount
		];

		$validationRules = [
			'amount' => [
				'RequiredValidation',
				'IntValidation',
				'MaxNumberValidation',
				'PositiveNumberValidation',
			],
		];

		return Validator::validate($sale, $validationRules);
	}

	public function getSuccessMessage(): string
	{
		return 'Venda registrada com sucesso!';
	}

	public function getAlreadyExistsMessage(): string
	{
		return 'Venda já registrada no sistema!';
	}

	public function getNotFoundMessage(): string
	{
		return 'Venda não encontrada!';
	}
}