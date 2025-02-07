<?php

declare(strict_types=1);
require __DIR__ . '/../vendor/autoload.php';
set_error_handler("Deivz\DesafioSoftexpert\helpers\ErrorHandler::handleError");
set_exception_handler("Deivz\DesafioSoftexpert\helpers\ErrorHandler::handleException");

if (!file_exists(__DIR__ . '/../.env')) {
	throw new Exception('Não foi possível carregar as variáveis de ambiente.');
}

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

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

if ($matchedRoute) {
	$allParams = array_merge($params, $queryParams);
	$controller = new $matchedRoute();
	$controller->processRequest("", "");

	// list($controller, $method) = explode('@', $matchedRoute);
	// require "controllers/{$controller}.php";
	// $controllerInstance = new $controller;

	// $allParams = array_merge($params, $queryParams);

	// $controllerInstance->$method($allParams);
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
