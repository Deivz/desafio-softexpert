<?php

namespace Deivz\DesafioSoftexpert\controllers;

use Deivz\DesafioSoftexpert\models\Product;
use Deivz\DesafioSoftexpert\models\ProductType;
use Deivz\DesafioSoftexpert\repositories\ProductRepository;
use Deivz\DesafioSoftexpert\repositories\ProductTypeRepository;
use Deivz\DesafioSoftexpert\services\ProductService;

class ProductController extends BaseController
{

	public ProductType $productType;
	public ProductTypeRepository $productTypeRepository;

	public function __construct(ConnectionController $connection)
	{
		parent::__construct($connection);
		$request = (array) json_decode(file_get_contents("php://input"), true);
		$this->model = new Product($request);
		$repository = new ProductRepository($this->connection, $this->model);
		$this->service = new ProductService($repository);

		$this->productType = new ProductType($request);
		$this->productTypeRepository = new ProductTypeRepository($this->connection, $this->productType);
	}


  public function readByUuid(array $params): void
  {
    try {
      $item = $this->service->getByUuid($params['uuid']);
      echo $this->renderPage("/produto", [
        'activePage' => 'produto',
        'item' => $item,
      ]);
    } catch (\Throwable $th) {
      http_response_code(500);
      echo json_encode([
        'erro' => $th->getMessage(),
        'mensagem' => 'Não foi possível buscar os itens no sistema, entre em contato com o suporte.'
      ]);
    }
  }

	public function new(): void
  {
    try {
			$uri = $_SERVER['REQUEST_URI'];
      $uriParts = explode('/', trim($uri, '/'));
      $resource = $uriParts[0];

			$productTypes = $this->productTypeRepository->findAll(50, 1);
      echo $this->renderPage("/produtos-novo", [
				'activePage' => $resource,
				'productTypes' => $productTypes,
			]);
    } catch (\Throwable $th) {
      http_response_code(500);
      echo json_encode([
        'erro' => $th->getMessage(),
        'mensagem' => 'Não foi possível buscar os itens no sistema, entre em contato com o suporte.'
      ]);
    }
  }
}
