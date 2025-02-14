<?php

use Deivz\DesafioSoftexpert\controllers\ConnectionController;
use Deivz\DesafioSoftexpert\controllers\ProductTypeController;
use Deivz\DesafioSoftexpert\models\ProductType;
use Deivz\DesafioSoftexpert\repositories\ProductTypeRepository;
use Deivz\DesafioSoftexpert\services\ProductTypeService;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class ProductTypeRouteTest extends TestCase
{
  private Client $client;
  private PDO $connection;
  private $controller;
  private ProductType $model;
  private ProductTypeRepository $repository;
  private ProductTypeService $service;

  protected function setUp(): void
  {

    if (!file_exists(__DIR__ . '/../../.env')) {
      throw new Exception('Não foi possível carregar as variáveis de ambiente.');
    }

    $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
    $dotenv->load();

    $connection = new ConnectionController(
      $_ENV['DB_HOST'],
      $_ENV['DB_PORT'],
      $_ENV['DB_USER'],
      $_ENV['DB_PASS'],
      $_ENV['DB_NAME']
    );

    $this->connection = $connection->connect();

    $request = [
      'name' => 'Test Product Type Two',
    ];

    $this->model = new ProductType($request);
    $this->repository = new ProductTypeRepository($this->connection, $this->model);
    $this->service = new ProductTypeService($this->repository);
    $this->controller = new ProductTypeController($this->connection, $this->model, $this->service);

    $this->client = new Client([
      'base_uri' => 'http://localhost:8080',
      'http_errors' => false
    ]);

    // uuid será usado pra remover o dado do banco
    //rollback não vai funcionar por conta da transação do proprio controller
    $this->model->setUuid('03a934b4-f06f-43f1-b2ce-a5ab93115703');
  }

  protected function tearDown(): void
  {
    $stmt = $this->connection->query(
      "DELETE FROM {$_ENV["TABLE_PRODUCT_TYPES"]}
      WHERE uuid = '{$this->model->getUuid()}'"
    );
    $stmt->execute();
  }

  public function test_create_product_type()
  {
    // ARRANGE
    // feito no método setUp 

    // ACT
    ob_start();
    $this->controller->create();
    $output = ob_get_clean();

    // ASSERT
    $this->assertEquals(201, http_response_code());
    $this->assertJsonStringEqualsJsonString(
      json_encode(['mensagem' => 'Tipo de produto cadastrado com sucesso!']),
      $output
    );

    // Verificação no banco de dados
    $stmt = $this->connection->query(
      "SELECT * FROM {$_ENV["TABLE_PRODUCT_TYPES"]}
      WHERE name = '{$this->model->getName()}'"
    );
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->assertNotEmpty($result);
    $this->assertEquals($this->model->getName(), $result['name']);
  }

  public function test_read_product_type(): void
  {
    // ARRANGE

    // ACT
    $response = $this->client->get('/tipos_produto');

    // ASSERT
    $this->assertEquals(200, $response->getStatusCode());
  }

  public function test_read_product_type_by_uuid(): void
  {
    // ARRANGE
    $this->controller->create();

    // ACT
    $response = $this->client->get("/tipos_produto/{$this->model->getUuid()}/edit");

    // ASSERT
    $this->assertEquals(200, $response->getStatusCode());
  }

  public function test_update_product_type(): void
  {
    // ARRANGE
    $this->controller->create();
    $updatedData = [
      'name' => 'Test Updated Product Type',
    ];

    // ACT
    $response = $this->client->patch("/tipos_produto/{$this->model->getUuid()}", [
      'json' => $updatedData,
    ]);

    // ASSERT
    $this->assertEquals(200, $response->getStatusCode());
    $data = json_decode($response->getBody(), true);
    $this->assertArrayHasKey('mensagem', $data);
    $this->assertEquals('Tipo de produto cadastrado com sucesso!', $data['mensagem']);

    $stmt = $this->connection->query(
      "SELECT * FROM {$_ENV["TABLE_PRODUCT_TYPES"]}
        WHERE uuid = '{$this->model->getUuid()}'"
    );
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->assertNotEmpty($result);
    $this->assertEquals($updatedData['name'], $result['name']);
  }
}
