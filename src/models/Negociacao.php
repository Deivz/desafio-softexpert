<?php

namespace Deivz\CalculadoraIr\models;

use Deivz\CalculadoraIr\helpers\TMensagensDeErro;

class Negociacao
{
    private $data;
    private $aplicacao;
    private $ativo;
    private $operacao;
    private $quantidade;
    private $preco;
    private $taxa;

    public function __construct(string $data, string $aplicacao, string $ativo, string $operacao, int $quantidade, float $preco, float $taxa) {
        $this->data = $data;
        $this->aplicacao = $aplicacao;
        $this->ativo = $ativo;
        $this->operacao = $operacao;
        $this->quantidade = $quantidade;
        $this->preco = $preco;
        $this->taxa = $taxa;
    }

    public function __get($atributo)
    {
        return $this->$atributo;
    }
}

