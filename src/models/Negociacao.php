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

    public function __construct(string $data, string $aplicacao, string $ativo, string $operacao, string $quantidade, string $preco, string $taxa)
    {
        $this->data = $data;
        $this->aplicacao = $aplicacao;
        if($this->validarAtivo($ativo)){
            $this->ativo = $ativo;
        }
        
        $this->operacao = $operacao;
        
        if($this->validarQuantidade($quantidade)){
            $this->quantidade = $quantidade;
        }

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

    private function validarQuantidade($quantidade): int
    {
        $procurarVirgula = strpos($quantidade, ',');
        $procurarPonto = strpos($quantidade, '.');

        if((intval($quantidade) === 0) || $procurarVirgula || $procurarPonto){
            $this->mostrarMensagensDeErro('A quantidade deve ser um número e do tipo inteiro.');
            return $quantidade = null;
        }
        return $quantidade = intval($quantidade);
    }

    private function validarPreco($preco): int
    {
        $procurarVirgula = strpos($preco, ',');
        $procurarPonto = strpos($preco, '.');

        if((intval($preco) === 0) || $procurarVirgula || $procurarPonto){
            $this->mostrarMensagensDeErro('O preço do ativo deve ser um número.');
            return $preco = null;
        }
        return $preco = intval($preco);
    }
}
