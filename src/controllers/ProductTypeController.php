<?php

namespace Deivz\DesafioSoftexpert\controllers;

use Deivz\DesafioSoftexpert\models\ProductType;
use Deivz\DesafioSoftexpert\repositories\ProductTypeRepository;
use Deivz\DesafioSoftexpert\services\ProductTypeService;

class ProductTypeController extends BaseController
{
	public function __construct(ConnectionController $connection)
	{
		parent::__construct($connection);
		$request = (array) json_decode(file_get_contents("php://input"), true);
		$this->model = new ProductType($request);
		$repository = new ProductTypeRepository($this->connection, $this->model);
		$this->service = new ProductTypeService($repository);
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
				'mensagem' => 'Não foi possível buscar os tipos de produto no sistema, entre em contato com o suporte.'
			]);
		}
	}

	public function edit(array $params): void
	{
		try {
			$uri = $_SERVER['REQUEST_URI'];
			$resource = parse_url($uri, PHP_URL_PATH);
			$segments = explode('/', trim($resource, '/'));
			$activePage = $segments[0] ?? '';

			$item = $this->service->getByUuid($params['uuid']);
			echo $this->renderPage("/edit_$activePage", [
				'activePage' => $activePage,
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
}
