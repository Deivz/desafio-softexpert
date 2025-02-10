<?php

namespace Deivz\DesafioSoftexpert\controllers;

use Deivz\DesafioSoftexpert\helpers\Validator;
use Deivz\DesafioSoftexpert\interfaces\ControllerInterface;
use Deivz\DesafioSoftexpert\interfaces\ModelInterface;
use Deivz\DesafioSoftexpert\services\BaseService;

abstract class BaseController implements ControllerInterface
{
  protected ModelInterface $model;
  protected BaseService $service;

  public function create(): void
  {
    try {
      $requestIsValid = $this->model->validate();

      if ($requestIsValid) {
        $this->service->create($this->model);
        http_response_code(201);
        echo json_encode([
          'mensagem' => $this->model->getSuccessMessage()
        ]);

        return;
      }

      http_response_code(400);
      echo json_encode(['errors' => Validator::getErrors()]);
    } catch (\Throwable $th) {
      http_response_code(500);
      echo json_encode([
        'erro' => $th->getMessage(),
        'mensagem' => 'Não foi possível realizar a inserção no sistema, contacte o suporte.'
      ]);
    }
  }

  public function read(array $params): void
  {
    try {
      $itemsPerPage = 50;
      $limit = isset($params["limit"]) ? $params["limit"] : $itemsPerPage;
      $page = isset($params["page"]) ? $params["page"] : 1;

      $items = $this->service->getAll($page, $limit);
      http_response_code(200);
      echo json_encode($items);
    } catch (\Throwable $th) {
      http_response_code(500);
      echo json_encode([
        'erro' => $th->getMessage(),
        'mensagem' => 'Não foi possível buscar os itens no sistema, entre em contato com o suporte.'
      ]);
    }
  }
}
