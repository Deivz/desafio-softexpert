<?php

namespace Deivz\DesafioSoftexpert\controllers;

use Deivz\DesafioSoftexpert\helpers\Validator;
use Deivz\DesafioSoftexpert\interfaces\ControllerInterface;
use Deivz\DesafioSoftexpert\interfaces\ModelInterface;
use Deivz\DesafioSoftexpert\services\BaseService;
use PDO;

abstract class BaseController extends RendererController implements ControllerInterface
{
  protected ModelInterface $model;
  protected BaseService $service;
  protected PDO $connection;

  public function __construct(ConnectionController $connection)
  {
    $this->connection = $connection->connect();
  }

  public function create(): void
  {
    try {
      $this->connection->beginTransaction();
      $requestIsValid = $this->model->validate();

      if ($requestIsValid) {
        switch ($this->checkExistance()) {
          case 0:
            $itemCreated = $this->service->create($this->model);
            if (!$itemCreated) {
              $this->connection->rollBack();
              http_response_code(500);
              echo json_encode([
                'errors' => 'Algo deu errado, contacte o suporte.'
              ]);
            }

            $this->connection->commit();
            http_response_code(201);
            echo json_encode([
              'mensagem' => $this->model->getSuccessMessage()
            ]);
            break;

          default:
            $this->connection->rollBack();
            http_response_code(409);
            echo json_encode([
              'mensagem' => $this->model->getAlreadyExistsMessage()
            ]);
            break;
        }
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
        'mensagem' => 'Não foi possível realizar a inserção no sistema, contacte o suporte.'
      ]);
    }
  }

  public function checkExistance(): int
  {
    try {
      return $this->service->getByUniqueKey($this->model);
    } catch (\Throwable $th) {
      http_response_code(500);
      echo json_encode([
        'erro' => $th->getMessage(),
        'mensagem' => 'Não foi possível verificar se os dados já existem no sistema, contacte o suporte.'
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

      echo $this->renderPage($_SERVER['REQUEST_URI'], ['items' => $items]);
      // http_response_code(200);
      // echo json_encode($items);
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

      echo $this->renderPage("/{$resource}-novo");
    } catch (\Throwable $th) {
      http_response_code(500);
      echo json_encode([
        'erro' => $th->getMessage(),
        'mensagem' => 'Não foi possível buscar os itens no sistema, entre em contato com o suporte.'
      ]);
    }
  }

  protected function findByUuid(string $uuid): array
  {
    try {
      $item = $this->service->getByUuid($uuid);
      if (empty($item)) {
        return [];
      }
      return $item;
    } catch (\Throwable $th) {
      http_response_code(500);
      echo json_encode([
        'erro' => $th->getMessage(),
        'mensagem' => 'Não foi possível buscar os itens no sistema, entre em contato com o suporte.'
      ]);
    }
  }

  public function update(array $params): void
  {
    try {
      $uuid = $params["uuid"];

      $item = $this->findByUuid($uuid);

      if (empty($item)) {
        http_response_code(404);
        echo json_encode([
          'mensagem' => $this->model->getNotFoundMessage()
        ]);

        return;
      }

      $this->model->setUuid($uuid);
      $requestIsValid = $this->model->validate();

      if ($requestIsValid) {
        switch ($this->checkExistance()) {
          case 0:
            $this->connection->beginTransaction();
            $itemUpdated = $this->service->edit($this->model);

            if (!$itemUpdated) {
              $this->connection->rollBack();
              http_response_code(500);
              echo json_encode([
                'errors' => 'Algo deu errado, contacte o suporte.'
              ]);
            }

            $this->connection->commit();
            http_response_code(200);
            echo json_encode([
              'mensagem' => $this->model->getSuccessMessage()
            ]);
            break;

          default:
            $this->connection->rollBack();
            http_response_code(409);
            echo json_encode([
              'erro' => $this->model->getAlreadyExistsMessage()
            ]);
            break;
        }
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
        'mensagem' => 'Não foi possível realizar a inserção no sistema, contacte o suporte.'
      ]);
    }
  }
}
