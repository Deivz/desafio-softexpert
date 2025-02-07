<?php

// use Deivz\DesafioSoftexpert\controllers\Cadastro;

// $rotas = [
// 	'/cadastro-tipos' => Cadastro::class,
// ];

// return $rotas;

use Deivz\DesafioSoftexpert\controllers\Cadastro;

$routes = [
	'GET' => [
			'/cadastro' => Cadastro::class,
			// '/' => 'HomeController@index',
			// '/about' => 'AboutController@index',
			// '/user/{id}' => 'UserController@show', // Rota dinâmica
			// '/user/{id}/produtos' => 'UserController@prod', // Rota dinâmica
	],
];

return $routes;