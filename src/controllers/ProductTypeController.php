<?php

namespace Deivz\DesafioSoftexpert\controllers;

use Deivz\DesafioSoftexpert\helpers\Validator;
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

			$validationRules = [
				'product_type' => ['RequiredValidation', 'MaxLengthValidation'],
			];

			$requestIsValid = Validator::validate($request, $validationRules);
			if ($requestIsValid) {
				$this->model->save($request);
				http_response_code(201);
				echo json_encode([
					'mensagem' => 'Tipo de produto cadastrado com sucesso!'
				]);

				return;
			}

			http_response_code(400);
			echo json_encode(['errors' => Validator::getErrors()]);
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
}
