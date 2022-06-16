<?php

use Deivz\CalculadoraIr\controllers\Cadastro;
use Deivz\CalculadoraIr\controllers\Login;
use Deivz\CalculadoraIr\controllers\operacoes;

$rotas = [
    '/cadastro' => Cadastro::class,
    '/login' => Login::class,
    '/operacoes' => Operacoes::class
];

return $rotas;