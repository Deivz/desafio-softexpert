<?php

$routes = [
	'GET' => [
		'/cadastro-produto' => 'ProductController@read',
		// '/' => 'HomeController@index',
		// '/about' => 'AboutController@index',
		// '/user/{id}' => 'UserController@show', // Rota dinâmica
		// '/user/{id}/produtos' => 'UserController@prod', // Rota dinâmica
	],
	'POST' => [
		'/cadastro-produto' => 'ProductController@create',
	],
	'PATCH' => [
		'/cadastro-produto' => 'ProductController@update',
	],
	'DELETE' => [
		'/cadastro-produto' => 'ProductController@delete',
	],
];

return $routes;
