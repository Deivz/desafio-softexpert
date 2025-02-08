<?php

namespace Deivz\DesafioSoftexpert\controllers;

use Deivz\DesafioSoftexpert\interfaces\ControllerInterface;
use Deivz\DesafioSoftexpert\models\ProductType;
use PDO;

class ProductTypeController implements ControllerInterface
{
	private $model;

	public function __construct(ConnectionController $connection)
	{
		$this->model = new ProductType($connection);
	}

	public function create(array $request): void
	{
		try {
			$request = (array) json_decode(file_get_contents("php://input"), true);

			$errors = $this->validateRequestData($request['product_type']);

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
				'mensagem' => 'Tipo de produto cadastrado com sucesso!'
			]);
		} catch (\Throwable $th) {
			http_response_code(500);
			echo json_encode([
				'erro' => $th->getMessage(),
				'mensagem' => 'Não foi possível realizar a inserção do tipo de produto no sistema, contacte o suporte.'
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
				'mensagem' => 'Não foi possível buscar os tipos de produto no sistema, entre em contato com o suporte.'
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

	private function validateRequestData(string $productType): array
	{
		$errors = [];

		if (empty($productType)) {
			array_push($errors, "Tipo de produto não informado");
		}

		if(strlen($productType) > 255) {
			array_push($errors, "Tipo de produto deve possuir no máximo 255 caracteres");
		}

		return $errors;
	}
}
