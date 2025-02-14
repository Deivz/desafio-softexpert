<?php

use Deivz\DesafioSoftexpert\controllers\ConnectionController;
use Deivz\DesafioSoftexpert\controllers\ProductController;
use Deivz\DesafioSoftexpert\models\ProductType;
use Deivz\DesafioSoftexpert\models\Product;
use Deivz\DesafioSoftexpert\repositories\ProductTypeRepository;
use Deivz\DesafioSoftexpert\repositories\ProductRepository;
use Deivz\DesafioSoftexpert\services\ProductTypeService;
use Deivz\DesafioSoftexpert\services\ProductService;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class ProductRouteTest extends TestCase
{
  private Client $client;
  private PDO $connection;
  private $controller;
  private Product $model;
  private ProductRepository $repository;
  private ProductService $service;
  private ProductTypeService $productTypeService;

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
      'name' => 'Test Product Two',
      'price' => '15',
      'amount' => '10',
      'product_type' => '1',
    ];

    $model = new ProductType($request);
    $repository = new ProductTypeRepository($this->connection, $model);
    $this->productTypeService = new ProductTypeService($repository);
    
    $this->model = new Product($request);
    $this->repository = new ProductRepository($this->connection, $this->model);
    $this->service = new ProductService($this->repository);
    $this->controller = new ProductController($this->connection, $this->model, $this->service, $this->productTypeService);

    $this->client = new Client([
      'base_uri' => 'http://localhost:8080',
      'http_errors' => false
    ]);

    // uuid será usado pra remover o dado do banco
    //rollback não vai funcionar por conta da transação do proprio controller
    $this->model->setUuid('03a934b4-f06f-43f1-b2ce-a5ab93115715');
  }

  protected function tearDown(): void
  {
    $stmt = $this->connection->query(
      "DELETE FROM {$_ENV["TABLE_PRODUCTS"]}
      WHERE uuid = '{$this->model->getUuid()}'"
    );
    $stmt->execute();
  }

  public function test_create_product()
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
      json_encode(['mensagem' => 'Produto cadastrado com sucesso!']),
      $output
    );

    // Verificação no banco de dados
    $stmt = $this->connection->query(
      "SELECT * FROM {$_ENV["TABLE_PRODUCTS"]}
      WHERE name = '{$this->model->getName()}'"
    );
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->assertNotEmpty($result);
    $this->assertEquals($this->model->getName(), $result['name']);
  }

  public function test_product_already_exists()
  {
    // ARRANGE
    $this->controller->create();
    
    $request = [
      'name' => 'Test Product Two',
      'price' => '15',
      'amount' => '10',
      'product_type' => '1',
    ];

    $this->model = new Product($request);
    $this->repository = new ProductRepository($this->connection, $this->model);
    $this->service = new ProductService($this->repository);
    $this->controller = new ProductController($this->connection, $this->model, $this->service, $this->productTypeService);

    // ACT
    ob_start();
    $this->controller->create();
    $output = ob_get_clean();

    // ASSERT
    $this->assertEquals(409, http_response_code());
    $this->assertJsonStringEqualsJsonString(
      json_encode(['mensagem' => 'Este produto já está cadastrado!']),
      $output
    );

    // Verificação no banco de dados
    $stmt = $this->connection->query(
      "SELECT * FROM {$_ENV["TABLE_PRODUCTS"]}
      WHERE name = '{$this->model->getName()}'"
    );
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->assertNotEmpty($result);
    $this->assertEquals($this->model->getName(), $result['name']);
  }

  public function test_read_product(): void
  {
    // ARRANGE

    // ACT
    $response = $this->client->get('/produtos');

    // ASSERT
    $this->assertEquals(200, $response->getStatusCode());
  }
}
