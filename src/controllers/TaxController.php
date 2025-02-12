<?php

namespace Deivz\DesafioSoftexpert\controllers;

use Deivz\DesafioSoftexpert\models\Tax;
use Deivz\DesafioSoftexpert\repositories\TaxRepository;
use Deivz\DesafioSoftexpert\services\TaxService;

class TaxController extends BaseController
{
	protected TaxRepository $repository;

	public function __construct(ConnectionController $connection)
	{
		parent::__construct($connection);
		$request = (array) json_decode(file_get_contents("php://input"), true);
		$this->model = new Tax($request);
		$this->repository = new TaxRepository($this->connection, $this->model);
		$this->service = new TaxService($this->repository);
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
				'mensagem' => 'Não foi possível buscar os impostos no sistema, entre em contato com o suporte.'
			]);
		}
	}

	public function new(): void
	{
		try {
			$uri = $_SERVER['REQUEST_URI'];
			$uriParts = explode('/', trim($uri, '/'));
			$resource = $uriParts[0];

			echo $this->renderPage("/new_impostos", [
				'activePage' => $resource,
			]);
		} catch (\Throwable $th) {
			http_response_code(500);
			echo json_encode([
				'erro' => $th->getMessage(),
				'mensagem' => 'Não foi possível renderizar a página de impostos, entre em contato com o suporte.'
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
}
