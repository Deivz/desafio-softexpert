<?php

namespace Deivz\DesafioSoftexpert\controllers;

use Deivz\DesafioSoftexpert\helpers\Validator;
use Deivz\DesafioSoftexpert\models\ProductType;
use Deivz\DesafioSoftexpert\models\Tax;
use Deivz\DesafioSoftexpert\repositories\ProductTypeRepository;
use Deivz\DesafioSoftexpert\repositories\TaxRepository;
use Deivz\DesafioSoftexpert\services\ProductTypeService;
use PDO;

class ProductTypeController extends BaseController
{
	protected Tax $tax;
	protected TaxRepository $taxRepository;

	public function __construct(ConnectionController $connection)
	{
		parent::__construct($connection);
		$request = (array) json_decode(file_get_contents("php://input"), true);
		$this->model = new ProductType($request);
		$repository = new ProductTypeRepository($this->connection, $this->model);
		$this->service = new ProductTypeService($repository);

		$this->tax = new Tax($request);
		$this->taxRepository = new TaxRepository($this->connection, $this->tax);
	}

	public function readByUuid(array $params): void
	{
		try {
			$item = $this->service->getByUuid($params['uuid']);
			echo $this->renderPage("/tipo-produto", [
				'activePage' => 'tipo-produto',
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

			$taxes = $this->taxRepository->findAllNoPagination();
      echo $this->renderPage("/new_tipos_produto", [
				'activePage' => $resource,
				'taxes' => $taxes,
			]);
    } catch (\Throwable $th) {
      http_response_code(500);
      echo json_encode([
        'erro' => $th->getMessage(),
        'mensagem' => 'Não foi possível buscar os impostos no sistema, entre em contato com o suporte.'
      ]);
    }
  }
}
