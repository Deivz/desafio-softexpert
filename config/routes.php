<?php

use Deivz\CalculadoraIr\controllers\Cadastro;
use Deivz\CalculadoraIr\controllers\ListaOperacoes;
use Deivz\CalculadoraIr\controllers\Login;
use Deivz\CalculadoraIr\controllers\Logout;
use Deivz\CalculadoraIr\controllers\Operacoes;

$rotas = [
    '' => Login::class,
    '/cadastro' => Cadastro::class,
    '/login' => Login::class,
    '/operacoes' => Operacoes::class,
    '/logout' => Logout::class,
    '/operacoes/lista' => ListaOperacoes::class
];

return $rotas;