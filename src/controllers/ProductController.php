<?php

namespace Deivz\DesafioSoftexpert\controllers;

use Deivz\DesafioSoftexpert\helpers\Validator;
use Deivz\DesafioSoftexpert\interfaces\ControllerInterface;
use Deivz\DesafioSoftexpert\models\Product;
use Deivz\DesafioSoftexpert\repositories\ProductRepository;
use Deivz\DesafioSoftexpert\services\ProductService;

class ProductController implements ControllerInterface
{
	private Product $model;
	private ProductService $service;

	public function __construct(ConnectionController $connection)
	{
		$request = (array) json_decode(file_get_contents("php://input"), true);
		$this->model = new Product($request);
		$repository = new ProductRepository($connection, $this->model);
		$this->service = new ProductService($repository);
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
				'mensagem' => 'Não foi possível realizar a inserção do produto no sistema, contacte o suporte.'
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
				'mensagem' => 'Não foi possível buscar os produtos no sistema, entre em contato com o suporte.'
			]);
		}
	}
}
