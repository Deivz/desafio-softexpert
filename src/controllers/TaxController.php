<?php

namespace Deivz\DesafioSoftexpert\controllers;

use Deivz\DesafioSoftexpert\interfaces\ControllerInterface;
use Deivz\DesafioSoftexpert\models\Tax;
use PDO;

class TaxController implements ControllerInterface
{
	private $model;

	public function __construct(ConnectionController $connection)
	{
		$this->model = new Tax($connection);
	}

	public function create(array $request): void
	{
		try {
			$request = (array) json_decode(file_get_contents("php://input"), true);

			$errors = $this->validateRequestData($request['tax'], $request['product_type']);

			if (!empty($errors)) {
				http_response_code(400);
				echo json_encode([
					"erros" => $errors
				]);

				return;
			}

			$this->model->save($request);
			http_response_code(201);
			echo json_encode([
				'mensagem' => 'Imposto cadastrado com sucesso!'
			]);
		} catch (\Throwable $th) {
			http_response_code(500);
			echo json_encode([
				'erro' => $th->getMessage(),
				'mensagem' => 'Não foi possível realizar a inserção do imposto no sistema, contacte o suporte.'
			]);
		}
	}

	public function read(array $params): void
	{
		try {
			$taxes = $this->model->get($params);
			http_response_code(200);
			echo json_encode($taxes);
		} catch (\Throwable $th) {
			http_response_code(500);
			echo json_encode([
				'erro' => $th->getMessage(),
				'mensagem' => 'Não foi possível buscar os impostos no sistema, entre em contato com o suporte.'
			]);
		}
	}

	public function update(): void
	{
		echo "ATUALIZANDO";
	}

	public function delete(): void
	{
		echo "DELETANDO";
	}

	private function convertTax(&$tax): int
	{
		$tax = str_replace(',', '.', $tax);

		if (!preg_match('/^\d+(\.\d{1,2})?$/', $tax)) {
			return -1;
		}

		$taxFloat = floatval($tax);
		$convertedPrice = intval(round($taxFloat * 100));

		return $convertedPrice;
	}

	private function validateRequestData(string $tax, string &$productType): array
	{
		$errors = [];

		if (empty($tax)) {
			array_push($errors, "Valor do imposto não informado.");
		}

		$tax = $this->convertTax($tax);
		if ($tax === -1) {
			array_push($errors, "O valor do imposto precisa ser um número valido!");
		}

		if ($tax <= 0) {
			array_push($errors, "O valor do imposto não pode ser 0 ou negativo.");
		}

		if ($tax > 20000) {
			array_push($errors, "Não é possível cadastrar um imposto superior a 200%.");
		}

		$productType = intval($productType);
		if ($productType <= 0) {
			array_push($errors, "Informe um tipo de produto.");
		}

		return $errors;
	}
}
