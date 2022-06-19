<?php

namespace Deivz\CalculadoraIr\controllers;

use Deivz\CalculadoraIr\interfaces\IRequisicao;

class Operacoes extends Renderizador implements IRequisicao
{
    function processarRequisicao(): void
    {
        echo $this->renderizarPagina('/operacoes');
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_SESSION['quantidadeOperacoes'])){
                $_SESSION['segundaEtapa'] = true;
                header('Location: /operacoes');
            }
        }
    }
}