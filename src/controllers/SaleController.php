<?php

namespace Deivz\DesafioSoftexpert\controllers;

use Deivz\DesafioSoftexpert\helpers\Validator;
use Deivz\DesafioSoftexpert\interfaces\ConnectionInterface;
use Deivz\DesafioSoftexpert\interfaces\ModelInterface;
use Deivz\DesafioSoftexpert\interfaces\ServiceInterface;
use Deivz\DesafioSoftexpert\models\Sale;
use Deivz\DesafioSoftexpert\repositories\SaleRepository;
use Deivz\DesafioSoftexpert\services\SaleService;
use Deivz\DesafioSoftexpert\repositories\ProductRepository;
use Deivz\DesafioSoftexpert\models\Product;
use Deivz\DesafioSoftexpert\services\ProductService;
use Deivz\DesafioSoftexpert\services\ProductTypeService;
use PDO;

class SaleController
{
	public function __construct(
		protected PDO $connection,
    protected Sale $model,
    protected SaleService $service,
		protected Product $product,
		protected ProductRepository $productRepository,
		protected ProductService $productService
	) {
		$this->connection = $connection;
		$this->model = $model;
		$this->service = $service;
		$this->product = $product;
		$this->productRepository = $productRepository;
		$this->productService = $productService;
	}

	public function create(array $params): void
	{
		try {
			$this->connection->beginTransaction();
			$productUuid = $params["uuid"];

			$requestIsValid = $this->model->validate();

			if ($requestIsValid) {
				$product = $this->productService->getByUuid($productUuid);

				$sellPrice = $this->calculateSell($product);
				$this->model->setSellPrice($sellPrice);
				$this->model->setProductId($product["id"]);

				$saleCreated = $this->service->create();
				if (!$saleCreated) {
					$this->connection->rollBack();
					http_response_code(500);
					echo json_encode([
						'errors' => 'Algo deu errado, contacte o suporte.'
					]);
					return;
				}

				$this->product->setAmount($product["amount"]);
				$amountChanged = $this->setProductAmount($product);
				if (!$amountChanged) {
					$this->connection->rollBack();
					http_response_code(400);
					echo json_encode(['errors' => 'Quantidade de produtos insuficiente!']);
					return;
				}

				$this->connection->commit();
				http_response_code(201);
				echo json_encode([
					'mensagem' => $this->model->getSuccessMessage()
				]);
				return;
			}

			$this->connection->rollBack();
			http_response_code(400);
			echo json_encode(['errors' => Validator::getErrors()]);
		} catch (\Throwable $th) {
			$this->connection->rollBack();
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

		return intval($sellPrice * 100);
	}

	private function setProductAmount(array $product): bool
	{
		$productAmount = $this->product->getAmount();
		$soldAmount = $this->model->getAmount();


		if ($soldAmount <= 0) {
			return false;
		}

		if ($productAmount < $soldAmount) {
			return false;
		}

		$newAmount = $productAmount - $soldAmount;
		return $this->productRepository->newAmount($product["id"], $newAmount);
	}
}
