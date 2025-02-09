<?php

namespace Deivz\DesafioSoftexpert\controllers;

use Deivz\DesafioSoftexpert\helpers\IntValidation;
use Deivz\DesafioSoftexpert\helpers\RequiredValidation;
use Deivz\DesafioSoftexpert\helpers\Validator;
use Deivz\DesafioSoftexpert\interfaces\ControllerInterface;
use Deivz\DesafioSoftexpert\models\Product;
use PDO;

class ProductController implements ControllerInterface
{
	private $model;

	public function __construct(ConnectionController $connection)
	{
		$this->model = new Product($connection);
	}

	public function create(array $request): void
	{
		try {
			$request = (array) json_decode(file_get_contents("php://input"), true);

			$request['price'] = $this->convertPrice($request['price']);
			$request['product_type'] = intval($request['product_type']) ? intval($request['product_type']) : $request['product_type'];
			$request['amount'] = intval($request['amount']) ? intval($request['amount']) : $request['amount'];

			$validationRules = [
				'name' => ['RequiredValidation', 'MaxLengthValidation'],
				'price' => [
					'RequiredValidation',
					'IntValidation',
					'MaxNumberValidation',
					'PositiveNumberValidation',
					'PriceConvertionValidation',
				],
				'product_type' => ['RequiredValidation', 'IntValidation'],
				'amount' => ['RequiredValidation', 'IntValidation'],
			];

			if (Validator::validate($request, $validationRules)) {
				$this->model->save($request);
				http_response_code(201);
				echo json_encode([
					'mensagem' => 'Produto cadastrado com sucesso!'
				]);

				return;
			}

			http_response_code(400);
			echo json_encode(['errors' => Validator::getErrors()]);
		} catch (\Throwable $th) {
			http_response_code(500);
			echo json_encode([
				'erro' => $th->getMessage(),
				'mensagem' => 'Não foi possível realizar a inserção do produto no sistema, contacte o suporte.'
			]);
		}
	}

	public function read(array $params): void
	{
		try {
			$products = $this->model->get($params);
			http_response_code(200);
			echo json_encode($products);
		} catch (\Throwable $th) {
			http_response_code(500);
			echo json_encode([
				'erro' => $th->getMessage(),
				'mensagem' => 'Não foi possível buscar os produtos no sistema, entre em contato com o suporte.'
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

	private function convertPrice(&$price): int
	{
		$price = str_replace(',', '.', $price);

		if (!preg_match('/^\d+(\.\d{1,2})?$/', $price)) {
			return -1;
		}

		$priceFloat = floatval($price);
		$convertedPrice = intval(round($priceFloat * 100));

		return $convertedPrice;
	}
}
