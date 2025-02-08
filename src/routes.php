<?php

$routes = [
	'GET' => [
		'/cadastro-produto' => 'ProductController@read',
		'/cadastro-tipo-produto' => 'ProductTypeController@read',
		'/cadastro-imposto' => 'TaxController@read',
		// '/' => 'HomeController@index',
		// '/about' => 'AboutController@index',
		// '/user/{id}' => 'UserController@show', // Rota dinâmica
		// '/user/{id}/produtos' => 'UserController@prod', // Rota dinâmica
	],
	'POST' => [
		'/cadastro-produto' => 'ProductController@create',
		'/cadastro-tipo-produto' => 'ProductTypeController@create',
		'/cadastro-imposto' => 'TaxController@create',
	],
	'PATCH' => [
		'/cadastro-produto' => 'ProductController@update',
		'/cadastro-tipo-produto' => 'ProductTypeController@update',
		'/cadastro-imposto' => 'TaxController@update',
	],
	'DELETE' => [
		'/cadastro-produto' => 'ProductController@delete',
		'/cadastro-tipo-produto' => 'ProductTypeController@delete',
		'/cadastro-imposto' => 'TaxController@delete',
	],
];

return $routes;
