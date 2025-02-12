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
		'/impostos/new' => 'TaxController@new',
		'/impostos/{uuid}/edit' => 'TaxController@edit',
	],
	'POST' => [
		'/produtos' => 'ProductController@create',
		'/produtos/{uuid}/venda' => 'SaleController@create',

		'/tipos_produto' => 'ProductTypeController@create',

		'/impostos' => 'TaxController@create',
	],
	'PATCH' => [
		'/tipos_produto/{uuid}' => 'ProductTypeController@update',
	],
	'DELETE' => [
		'/impostos/{uuid}' => 'TaxController@delete',
	],
];

return $routes;
