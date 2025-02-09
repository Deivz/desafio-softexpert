<?php

$routes = [
	'GET' => [
		'/produtos' => 'ProductController@read',
		'/tipos-produto' => 'ProductTypeController@read',
		'/impostos' => 'TaxController@read',
		// '/' => 'HomeController@index',
		// '/about' => 'AboutController@index',
		// '/user/{id}' => 'UserController@show', // Rota dinâmica
		// '/user/{id}/produtos' => 'UserController@prod', // Rota dinâmica
	],
	'POST' => [
		'/produtos' => 'ProductController@create',
		'/tipos-produto' => 'ProductTypeController@create',
		'/impostos' => 'TaxController@create',
	],
	'PATCH' => [
		'/produtos' => 'ProductController@update',
		'/tipos-produto' => 'ProductTypeController@update',
		'/imposto' => 'TaxController@update',
	],
	'DELETE' => [
		'/produtos' => 'ProductController@delete',
		'/tipos-produto' => 'ProductTypeController@delete',
		'/impostos' => 'TaxController@delete',
	],
];

return $routes;
