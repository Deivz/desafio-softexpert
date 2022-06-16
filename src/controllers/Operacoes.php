<?php

namespace Deivz\CalculadoraIr\controllers;

use Deivz\CalculadoraIr\interfaces\IRequisicao;

class Operacoes extends Renderizador implements IRequisicao
{
    function processarRequisicao(): void
    {
        echo $this->renderizarPagina('/operacoes');
    }
}