<?php

$routes = [
	'GET' => [
		'/cadastro-produto' => 'ProductController@read',
		'/cadastro-tipo-produto' => 'ProductTypeController@read',
		// '/' => 'HomeController@index',
		// '/about' => 'AboutController@index',
		// '/user/{id}' => 'UserController@show', // Rota dinâmica
		// '/user/{id}/produtos' => 'UserController@prod', // Rota dinâmica
	],
	'POST' => [
		'/cadastro-produto' => 'ProductController@create',
		'/cadastro-tipo-produto' => 'ProductTypeController@create',
	],
	'PATCH' => [
		'/cadastro-produto' => 'ProductController@update',
		'/cadastro-tipo-produto' => 'ProductTypeController@update',
	],
	'DELETE' => [
		'/cadastro-produto' => 'ProductController@delete',
		'/cadastro-tipo-produto' => 'ProductTypeController@delete',
	],
];

return $routes;
