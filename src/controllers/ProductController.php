<?php

namespace Deivz\DesafioSoftexpert\controllers;

use Deivz\DesafioSoftexpert\interfaces\ModelInterface;
use Deivz\DesafioSoftexpert\interfaces\ServiceInterface;
use Deivz\DesafioSoftexpert\services\ProductTypeService;
use PDO;

class ProductController extends BaseController
{
  public function __construct(
    protected PDO $connection,
    protected ModelInterface $model,
    protected ServiceInterface $service,
    protected ProductTypeService $productTypeService,
  ) {
    parent::__construct($connection, $model, $service);
    $this->productTypeService = $productTypeService;
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

      $productTypes = $this->productTypeService->getAllNoPaginationOnlyIfHasTax();
      $productTypes = $this->groupProducts($productTypes);
      echo $this->renderPage("/new_produtos", [
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
