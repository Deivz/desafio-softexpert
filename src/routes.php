<?php

$routes = [
	'GET' => [
		'/produto' => 'ProductController@read',
		'/tipo-produto' => 'ProductTypeController@read',
		'/imposto' => 'TaxController@read',
		// '/' => 'HomeController@index',
		// '/about' => 'AboutController@index',
		// '/user/{id}' => 'UserController@show', // Rota dinâmica
		// '/user/{id}/produtos' => 'UserController@prod', // Rota dinâmica
	],
	'POST' => [
		'/produto' => 'ProductController@create',
		'/tipo-produto' => 'ProductTypeController@create',
		'/imposto' => 'TaxController@create',
	],
	'PATCH' => [
		'/produto' => 'ProductController@update',
		'/tipo-produto' => 'ProductTypeController@update',
		'/imposto' => 'TaxController@update',
	],
	'DELETE' => [
		'/produto' => 'ProductController@delete',
		'/tipo-produto' => 'ProductTypeController@delete',
		'/imposto' => 'TaxController@delete',
	],
];

return $routes;
