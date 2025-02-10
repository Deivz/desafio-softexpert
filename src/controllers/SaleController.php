<?php

namespace Deivz\DesafioSoftexpert\controllers;

use Deivz\DesafioSoftexpert\helpers\Validator;
use Deivz\DesafioSoftexpert\models\Sale;
use Deivz\DesafioSoftexpert\repositories\SaleRepository;
use Deivz\DesafioSoftexpert\services\SaleService;
use Deivz\DesafioSoftexpert\repositories\ProductRepository;
use Deivz\DesafioSoftexpert\models\Product;
use Deivz\DesafioSoftexpert\services\ProductService;
use PDO;

class SaleController
{
	private Sale $model;
	private SaleService $service;

	private Product $product;
	private ProductRepository $productRepository;
	private ProductService $productService;

	private PDO $connection;

	public function __construct(ConnectionController $connection)
	{
		$this->connection = $connection->connect();
		$request = (array) json_decode(file_get_contents("php://input"), true);
		$this->model = new Sale($request);
		$repository = new SaleRepository($this->connection, $this->model);
		$this->service = new SaleService($repository);

		$this->product = new Product($request);
		$this->productRepository = new ProductRepository($connection, $this->product);
		$this->productService = new ProductService($this->productRepository);

		$this->connection = $connection->connect();
	}

	public function create(array $params): void
	{
		try {
			$this->connection->beginTransaction();

			$saleCreated = $this->service->create();

			if (!$saleCreated) {
				$this->connection->rollBack();
				http_response_code(500);
				echo json_encode(['errors' => 'Não foi possível salvar a venda.']);
			}

			$this->connection->commit();
			http_response_code(201);
			echo json_encode([
				'mensagem' => $this->model->getSuccessMessage()
			]);

			// $productUuid = $params["uuid"];

			// $requestIsValid = $this->model->validate();

			// if ($requestIsValid) {
			// 	$this->connection->beginTransaction();

			// 	$product = $this->productService->getByUuid($productUuid);
				
			// 	$this->product->setAmount($product["amount"]);
			// 	$amountChanged = $this->setProductAmount($product);
			// 	if (!$amountChanged) {
			// 		http_response_code(400);
			// 		echo json_encode(['errors' => 'Quantidade de produtos insuficiente!']);
			// 		return;
			// 	}

			// 	$sellPrice = $this->calculateSell($product);
			// 	$this->model->setSellPrice($sellPrice);
			// 	$this->model->setProductId($product["id"]);
				
			// 	$this->service->create();
			// 	http_response_code(201);
			// 	echo json_encode([
			// 		'mensagem' => $this->model->getSuccessMessage()
			// 	]);
			// 	return;
			// }

			// http_response_code(400);
			// echo json_encode(['errors' => Validator::getErrors()]);
		} catch (\Throwable $th) {
			http_response_code(500);
			echo json_encode([
				'erro' => $th->getMessage(),
				'mensagem' => 'Não foi inserir a venda no sistema, contacte o suporte.'
			]);
		}
	}

	private function calculateSell(array $product): int
	{
		$productAmount = $this->product->getAmount();
		$pricePerProduct = $product["price_per_product"];
		$sellPrice = $productAmount * $pricePerProduct;

		return $sellPrice;
	}

	private function setProductAmount(array $product): bool
	{
		$productAmount = $this->product->getAmount();
		$soldAmount = $this->model->getAmount();

		if ($productAmount < $soldAmount) {
			return false;
		}

		$newAmount = $productAmount - $soldAmount;
		$this->productRepository->newAmount($product["id"], $newAmount);
		return true;
	}
}
