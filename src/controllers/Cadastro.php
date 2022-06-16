<?php

namespace Deivz\CalculadoraIr\controllers;

use Deivz\CalculadoraIr\interfaces\IRequisicao;

class Cadastro extends Renderizador implements IRequisicao
{
    public function processarRequisicao(): void
    {
        echo $this->renderizarPagina('/cadastro');
    }
}