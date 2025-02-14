<?php

use Deivz\DesafioSoftexpert\controllers\ConnectionController;
use Deivz\DesafioSoftexpert\controllers\TaxController;
use Deivz\DesafioSoftexpert\models\ProductType;
use Deivz\DesafioSoftexpert\models\Tax;
use Deivz\DesafioSoftexpert\repositories\ProductTypeRepository;
use Deivz\DesafioSoftexpert\repositories\TaxRepository;
use Deivz\DesafioSoftexpert\services\ProductTypeService;
use Deivz\DesafioSoftexpert\services\TaxService;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class TaxRouteTest extends TestCase
{
  private Client $client;
  private PDO $connection;
  private $controller;
  private Tax $model;
  private TaxRepository $repository;
  private TaxService $service;

  protected function setUp(): void
  {

    if (!file_exists(__DIR__ . '/../../.env')) {
      throw new Exception('Não foi possível carregar as variáveis de ambiente.');
    }

    $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
    $dotenv->load();

    $connection = new ConnectionController(
      $_ENV['DB_HOST'],
      $_ENV['DB_USER'],
      $_ENV['DB_PASS'],
      $_ENV['DB_NAME']
    );

    $this->connection = $connection->connect();

    $request = [
      'name' => 'Tax Test Two',
      'tax' => '15',
      'product_type' => '1',
    ];

    $model = new ProductType($request);
    $repository = new ProductTypeRepository($this->connection, $model);
    $service = new ProductTypeService($repository);
    
    $this->model = new Tax($request);
    $this->repository = new TaxRepository($this->connection, $this->model);
    $this->service = new TaxService($this->repository);
    $this->controller = new TaxController($this->connection, $this->model, $this->service, $service);

    $this->client = new Client([
      'base_uri' => 'http://localhost:8080',
      'http_errors' => false
    ]);

    // uuid será usado pra remover o dado do banco
    //rollback não vai funcionar por conta da transação do proprio controller
    $this->model->setUuid('03a934b4-f06f-43f1-b2ce-a5ab93115705');
  }

  protected function tearDown(): void
  {
    $stmt = $this->connection->query(
      "DELETE FROM {$_ENV["TABLE_TAXES"]}
      WHERE uuid = '{$this->model->getUuid()}'"
    );
    $stmt->execute();
  }

  public function test_create_tax()
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
      json_encode(['mensagem' => 'Imposto cadastrado com sucesso!']),
      $output
    );

    // Verificação no banco de dados
    $stmt = $this->connection->query(
      "SELECT * FROM {$_ENV["TABLE_TAXES"]}
      WHERE name = '{$this->model->getName()}'"
    );
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->assertNotEmpty($result);
    $this->assertEquals('Tax Test Two', $result['name']);
  }

  public function test_read_tax(): void
  {
    // ARRANGE

    // ACT
    $response = $this->client->get('/impostos');

    // ASSERT
    $this->assertEquals(200, $response->getStatusCode());
  }

  public function test_delete_tax(): void
  {
    // ARRANGE
    $this->controller->create();

    // ACT
    $response = $this->client->delete("/impostos/{$this->model->getUuid()}");

    // ASSERT
    $this->assertEquals(204, $response->getStatusCode());
  }
}
