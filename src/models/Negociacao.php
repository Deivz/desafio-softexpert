<?php

namespace Deivz\CalculadoraIr\models;

use Deivz\CalculadoraIr\helpers\TMensagensDeErro;

class Negociacao
{
    use TMensagensDeErro;

    private $data;
    private $aplicacao;
    private $ativo;
    private $operacao;
    private $quantidade;
    private $preco;
    private $taxa;

    public function __construct(string $data, string $aplicacao, string $ativo, string $operacao, int $quantidade, float $preco, float $taxa)
    {
        $this->data = $data;
        $this->aplicacao = $aplicacao;
        if($this->validarAtivo($ativo)){
            $this->ativo = $ativo;
        }
        
        $this->operacao = $operacao;
        $this->quantidade = $quantidade;
        $this->preco = $preco;
        $this->taxa = $taxa;
    }

    public function __get($atributo)
    {
        return $this->$atributo;
    }

    private function validarAtivo($ativo): string
    {
        $quatroCaracteresIniciais = substr($ativo, 0 ,4);
        $filtrarNumeros = filter_var($quatroCaracteresIniciais, FILTER_SANITIZE_NUMBER_INT);

        if(is_numeric($filtrarNumeros)){
            $this->mostrarMensagensDeErro('Os quatro primeiros caracteres de um ativo devem ser somente letras.');
            return $ativo = null;
        }
        return $ativo = $ativo;
    }
}
