<?php

namespace Deivz\CalculadoraIr\controllers;

use Deivz\CalculadoraIr\interfaces\IRequisicao;

class Logout extends Renderizador implements IRequisicao
{
    public function processarRequisicao(): void
    {
        session_destroy();
        header('Location: /login');
    }
}