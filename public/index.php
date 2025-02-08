<?php

declare(strict_types=1);

use Deivz\DesafioSoftexpert\controllers\ConnectionController;

require __DIR__ . '/../vendor/autoload.php';
set_error_handler("Deivz\DesafioSoftexpert\helpers\ErrorHandler::handleError");
set_exception_handler("Deivz\DesafioSoftexpert\helpers\ErrorHandler::handleException");

if (!file_exists(__DIR__ . '/../.env')) {
	throw new Exception('Não foi possível carregar as variáveis de ambiente.');
}

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
$controllerNameSpace = "Deivz\DesafioSoftexpert\controllers\\";

header('Content-type: application/json; charset = UTF-8');

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
	$_ENV["DB_HOST"], $_ENV["DB_USER"], $_ENV["DB_PASS"], $_ENV["DB_NAME"]
);

if ($matchedRoute) {
	list($controller, $method) = explode('@', $matchedRoute);
	$controller = $controllerNameSpace . $controller;
	$controllerInstance = new $controller($connection);
	$allParams = array_merge($params, $queryParams);
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
