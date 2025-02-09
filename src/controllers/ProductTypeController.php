<?php

namespace Deivz\DesafioSoftexpert\controllers;

use Deivz\DesafioSoftexpert\helpers\Validator;
use Deivz\DesafioSoftexpert\interfaces\ControllerInterface;
use Deivz\DesafioSoftexpert\models\ProductType;
use Deivz\DesafioSoftexpert\repositories\ProductTypeRepository;
use Deivz\DesafioSoftexpert\services\ProductTypeService;
use PDO;

class ProductTypeController implements ControllerInterface
{
	private ProductType $model;
	private ProductTypeService $service;

	public function __construct(ConnectionController $connection)
	{
		$request = (array) json_decode(file_get_contents("php://input"), true);
		$this->model = new ProductType($request);
		$repository = new ProductTypeRepository($connection, $this->model);
		$this->service = new ProductTypeService($repository);
	}

	public function create(): void
	{
		try {
			$requestIsValid = $this->model->validate();

			if ($requestIsValid) {
				$this->service->create($this->model);
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
				'mensagem' => 'Não foi possível realizar a inserção do tipo de produto no sistema, contacte o suporte.'
			]);
		}
	}

	public function read(array $params): void
	{
		try {
			$productsPerPage = 50;
			$limit = isset($params["limit"]) ? $params["limit"] : $productsPerPage;
			$page = isset($params["page"]) ? $params["page"] : 1;

			$products = $this->service->getAll($page, $limit);
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
