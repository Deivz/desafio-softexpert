<?php

namespace Deivz\DesafioSoftexpert\controllers;

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

			$errors = $this->validateRequestData($request['name'], $request['price'], $request['product_type']);

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
				'mensagem' => 'Produto cadastrado com sucesso!'
			]);
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
				'mensagem' => 'Não foi possível buscaro produtos no sistema, contacte o suporte.'
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

	private function validateRequestData(string $name, string $price, string &$productType): array
	{
		$errors = [];

		if (empty($name)) {
			array_push($errors, "Nome não informado.");
		}

		if (strlen($name) > 255) {
			array_push($errors, "Nome do produto deve possuir no máximo 255 caracteres.");
		}

		if (empty($price)) {
			array_push($errors, "Preço não informado.");
		}

		$price = $this->convertPrice($price);
		if ($price === -1) {
			array_push($errors, "O preço precisa ser um número valido!");
		}

		if ($price <= 0) {
			array_push($errors, "O preço do produto não pode ser 0 ou negativo.");
		}

		if ($price > 100000000) {
			array_push($errors, "Não é possível cadastrar um produto com preço maior que R$1.000.000,00.");
		}

		$productType = intval($productType);
		if ($productType <= 0) {
			array_push($errors, "Informe um tipo de produto.");
		}

		return $errors;
	}
}
