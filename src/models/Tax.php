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

	public function validate(): bool
	{
		$product = [
			'name' => $this->name,
			'tax' => $this->tax,
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
		];

		return Validator::validate($product, $validationRules);
	}

	public function getSuccessMessage(): string
	{
		return 'Imposto cadastrado com sucesso!';
	}

	public function getAlreadyExistsMessage(): string
	{
		return 'Já existe uma taxa cadastrada para este imposto!';
	}

	public function getNotFoundMessage(): string
	{
		return 'Imposto não encontrado!';
	}
}