<?php

namespace Deivz\DesafioSoftexpert\controllers;

class ProductTypeController extends BaseController
{
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
			http_response_code(200);
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
