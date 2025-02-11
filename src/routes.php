<?php

$routes = [
	'GET' => [
		'/produtos' => 'ProductController@read',
		'/produtos/novo' => 'ProductController@new',
		'/tipos-produto' => 'ProductTypeController@read',
		'/impostos' => 'TaxController@read',
		'/produtos/{uuid}/venda' => 'ProductController@readByUuid',
	],
	'POST' => [
		'/produtos' => 'ProductController@create',
		'/tipos-produto' => 'ProductTypeController@create',
		'/impostos' => 'TaxController@create',
		'/produtos/{uuid}/venda' => 'SaleController@create',
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
