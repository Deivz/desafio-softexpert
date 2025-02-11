<?php

$routes = [
	'GET' => [
		'/produtos' => 'ProductController@read',
		'/produtos/new' => 'ProductController@new',
		'/produtos/{uuid}/venda' => 'ProductController@readByUuid',

		'/tipos_produto' => 'ProductTypeController@read',
		'/tipos_produto/new' => 'ProductTypeController@new',
		'/tipos_produto/{uuid}/edit' => 'ProductTypeController@edit',

		'/impostos' => 'TaxController@read',
	],
	'POST' => [
		'/produtos' => 'ProductController@create',
		'/produtos/{uuid}/venda' => 'SaleController@create',

		'/tipos_produto' => 'ProductTypeController@create',

		'/impostos' => 'TaxController@create',
	],
	'PATCH' => [
		'/produtos/{uuid}' => 'ProductController@update',

		'/tipos_produto/{uuid}' => 'ProductTypeController@update',

		'/impostos/{uuid}' => 'TaxController@update',
	],
	'DELETE' => [
		'/produtos' => 'ProductController@delete',

		'/tipos_produto' => 'ProductTypeController@delete',

		'/impostos' => 'TaxController@delete',
	],
];

return $routes;
