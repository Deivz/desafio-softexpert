<?php

declare(strict_types=1);

use Deivz\DesafioSoftexpert\controllers\ConnectionController;
use Deivz\DesafioSoftexpert\controllers\ProductController;
use Deivz\DesafioSoftexpert\controllers\ProductTypeController;
use Deivz\DesafioSoftexpert\controllers\SaleController;
use Deivz\DesafioSoftexpert\controllers\TaxController;
use Deivz\DesafioSoftexpert\models\Product;
use Deivz\DesafioSoftexpert\models\ProductType;
use Deivz\DesafioSoftexpert\models\Sale;
use Deivz\DesafioSoftexpert\models\Tax;
use Deivz\DesafioSoftexpert\repositories\ProductRepository;
use Deivz\DesafioSoftexpert\repositories\ProductTypeRepository;
use Deivz\DesafioSoftexpert\repositories\SaleRepository;
use Deivz\DesafioSoftexpert\repositories\TaxRepository;
use Deivz\DesafioSoftexpert\services\ProductService;
use Deivz\DesafioSoftexpert\services\ProductTypeService;
use Deivz\DesafioSoftexpert\services\SaleService;
use Deivz\DesafioSoftexpert\services\TaxService;

require __DIR__ . '/../vendor/autoload.php';
set_error_handler("Deivz\DesafioSoftexpert\helpers\ErrorHandler::handleError");
set_exception_handler("Deivz\DesafioSoftexpert\helpers\ErrorHandler::handleException");

if (!file_exists(__DIR__ . '/../.env')) {
	throw new Exception('Não foi possível carregar as variáveis de ambiente.');
}

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// header('Content-type: application/json; charset = UTF-8');

$routes = require __DIR__ . '/../src/routes.php';

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$queryString = $_SERVER['QUERY_STRING'] ?? '';
$requestMethod = $_SERVER['REQUEST_METHOD'];

$matchedRoute = null;
$params = [];
$queryParams = [];

if (!empty($queryString)) {
	parse_str($queryString, $queryParams);
}

foreach ($routes[$requestMethod] as $route => $handler) {
	if (matchRoute($route, $requestUri, $params)) {
		$matchedRoute = $handler;
		break;
	}
}

$connection = new ConnectionController(
	$_ENV["DB_HOST"],
	$_ENV["DB_PORT"],
	$_ENV["DB_USER"],
	$_ENV["DB_PASS"],
	$_ENV["DB_NAME"]
);

$connection = $connection->connect();

$request = (array) json_decode(file_get_contents("php://input"), true);

$productType = new ProductType($request);
$productTypeRepository = new ProductTypeRepository($connection, $productType);
$productTypeService = new ProductTypeService($productTypeRepository);
$controllers['ProductTypeController'] = new ProductTypeController($connection, $productType, $productTypeService);

$tax = new Tax($request);
$taxRepository = new TaxRepository($connection, $tax);
$taxService = new TaxService($taxRepository);
$controllers['TaxController'] = new TaxController($connection, $tax, $taxService, $productTypeService);

$product = new Product($request);
$productRepository = new ProductRepository($connection, $product);
$productService = new ProductService($productRepository);
$controllers['ProductController'] = new ProductController($connection, $product, $productService, $productTypeService);

$sale = new Sale($request);
$saleRepository = new SaleRepository($connection, $sale);
$saleService = new SaleService($saleRepository);
$controllers['SaleController'] = new SaleController(
	$connection,
	$sale,
	$saleService,
	$product,
	$productRepository,
	$productService
);

if ($matchedRoute) {
	list($controller, $method) = explode('@', $matchedRoute);
	$allParams = array_merge($params, $queryParams);

	if (!isset($controllers[$controller])) {
		http_response_code(404);
		echo "Página não encontrada.";
		return;
	}

	$controllerInstance = $controllers[$controller];
	$controllerInstance->$method($allParams);
} else {
	http_response_code(404);
	echo "Página não encontrada.";
}

function matchRoute($route, $requestUri, &$params): bool
{
	$pattern = preg_replace('/\{([a-zA-Z]+)\}/', '(?P<\1>[^/]+)', $route);
	$pattern = "@^" . $pattern . "$@D";

	if (preg_match($pattern, $requestUri, $matches)) {
		foreach ($matches as $key => $value) {
			if (is_string($key)) {
				$params[$key] = $value;
			}
		}
		return true;
	}
	return false;
}
