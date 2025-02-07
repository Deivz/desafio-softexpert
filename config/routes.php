<?php

use Deivz\CalculadoraIr\controllers\Cadastro;


$rotas = [
    '/cadastro-tipos' => Cadastro::class,
    '/cadastro-produtos' => Cadastro::class,
    '/cadastro-impostos' => Cadastro::class,
];

return $rotas;