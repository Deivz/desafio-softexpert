<?php

namespace Deivz\DesafioSoftexpert\controllers;

use Deivz\DesafioSoftexpert\models\ProductType;
use Deivz\DesafioSoftexpert\models\Tax;
use Deivz\DesafioSoftexpert\repositories\ProductTypeRepository;
use Deivz\DesafioSoftexpert\repositories\TaxRepository;
use Deivz\DesafioSoftexpert\services\ProductTypeService;
use Deivz\DesafioSoftexpert\services\TaxService;

class TaxController extends BaseController
{
	protected TaxRepository $repository;
	protected ProductTypeService $productTypeService;

	public function __construct(ConnectionController $connection)
	{
		parent::__construct($connection);
		$request = (array) json_decode(file_get_contents("php://input"), true);
		$this->model = new Tax($request);
		$this->repository = new TaxRepository($this->connection, $this->model);
		$this->service = new TaxService($this->repository);

		$productType = new ProductType($request);
		$productTypeRepository = new ProductTypeRepository($this->connection, $productType);
		$this->productTypeService = new ProductTypeService($productTypeRepository);
	}

	public function readByUuid(array $params): void
	{
		try {
			$item = $this->service->getByUuid($params['uuid']);
			echo $this->renderPage("/impostos", [
				'activePage' => 'impostos',
				'item' => $item,
			]);
		} catch (\Throwable $th) {
			http_response_code(500);
			echo json_encode([
				'erro' => $th->getMessage(),
				'mensagem' => 'Não foi possível buscar o imposto no sistema, entre em contato com o suporte.'
			]);
		}
	}

	public function new(): void
	{
		try {
			$uri = $_SERVER['REQUEST_URI'];
			$uriParts = explode('/', trim($uri, '/'));
			$resource = $uriParts[0];

			$productTypes = $this->productTypeService->getAllNoPagination();
			$productTypes = $this->groupProducts($productTypes);
			echo $this->renderPage("/new_impostos", [
				'activePage' => $resource,
				'productTypes' => $productTypes,
			]);
		} catch (\Throwable $th) {
			http_response_code(500);
			echo json_encode([
				'erro' => $th->getMessage(),
				'mensagem' => 'Não foi possível buscar os tipos de produto no sistema, entre em contato com o suporte.'
			]);
		}
	}

	public function delete(array $params): void
	{
		try {
			$uuid = $params["uuid"];

			$this->connection->beginTransaction();

			$itemDeleted = $this->repository->delete($uuid);
			if (!$itemDeleted) {
				$this->connection->rollBack();
				http_response_code(500);
				echo json_encode([
					'errors' => 'Algo deu errado, contacte o suporte.'
				]);
			}

			$this->connection->commit();
			http_response_code(204);
		} catch (\Throwable $th) {
			http_response_code(500);
			echo json_encode([
				'erro' => $th->getMessage(),
				'mensagem' => 'Não foi possível deletar o imposto do sistema, entre em contato com o suporte.'
			]);
		}
	}

	private function groupProducts(array $products): array
	{
		$groupedProducts = [];

		foreach ($products as $product) {
			$uuid = $product['uuid'];

			if (!isset($groupedProducts[$uuid])) {
				$groupedProducts[$uuid] = [
					'id' => $product['id'],
					'uuid' => $product['uuid'],
					'name' => $product['name'],
					'taxes' => [],
				];
			}

			$groupedProducts[$uuid]['taxes'][] = $product['tax_name'];
		}

		// Remove duplicatas na lista de taxas
		foreach ($groupedProducts as &$product) {
			$product['taxes'] = array_unique($product['taxes']);
		}

		return array_values($groupedProducts);
	}
}
