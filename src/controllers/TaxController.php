<?php

namespace Deivz\DesafioSoftexpert\controllers;

use Deivz\DesafioSoftexpert\helpers\Validator;
use Deivz\DesafioSoftexpert\interfaces\ControllerInterface;
use Deivz\DesafioSoftexpert\models\Tax;

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
			
			$request['tax'] = $this->convertTax($request['tax']);
			$request['product_type'] = intval($request['product_type']) ? intval($request['product_type']) : $request['product_type'];

			$validationRules = [
				'tax' => [
					'RequiredValidation',
					'IntValidation',
					'MaxTaxValidation',
					'PositiveNumberValidation',
					'PriceConvertionValidation',
				],
				'product_type' => ['RequiredValidation', 'IntValidation'],
			];

			$requestIsValid = Validator::validate($request, $validationRules);
			if ($requestIsValid) {
				$this->model->save($request);
				http_response_code(201);
				echo json_encode([
					'mensagem' => 'Imposto cadastrado com sucesso!'
				]);

				return;
			}

			http_response_code(400);
			echo json_encode(['errors' => Validator::getErrors()]);
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
}
