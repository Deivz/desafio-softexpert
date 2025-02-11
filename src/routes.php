<?php

$routes = [
	'GET' => [
		'/produtos' => 'ProductController@read',
		'/produtos/novo' => 'ProductController@new',
		'/produtos/{uuid}/venda' => 'ProductController@readByUuid',

		'/tipos-produto' => 'ProductTypeController@read',
		'/tipos-produto/novo' => 'ProductTypeController@new',
		'/tipos-produto/{uuid}' => 'ProductTypeController@readByUuid',

		'/impostos' => 'TaxController@read',
	],
	'POST' => [
		'/produtos' => 'ProductController@create',
		'/produtos/{uuid}/venda' => 'SaleController@create',

		'/tipos-produto' => 'ProductTypeController@create',

		'/impostos' => 'TaxController@create',
	],
	'PATCH' => [
		'/produtos/{uuid}' => 'ProductController@update',

		'/tipos-produto/{uuid}' => 'ProductTypeController@update',

		'/impostos/{uuid}' => 'TaxController@update',
	],
	'DELETE' => [
		'/produtos' => 'ProductController@delete',

		'/tipos-produto' => 'ProductTypeController@delete',
		
		'/impostos' => 'TaxController@delete',
	],
];

return $routes;
