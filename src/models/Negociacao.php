<?php

namespace Deivz\CalculadoraIr\models;

use Deivz\CalculadoraIr\helpers\TVerificarErros;
use Deivz\CalculadoraIr\interfaces\IValidacao;

class Negociacao implements IValidacao
{
    use TVerificarErros;

    private $data;
    private $aplicacao;
    private $ativo;
    private $operacao;
    private $quantidade;
    private $preco;
    private $taxa;

    public function __construct(string $data, string $aplicacao, int $quantidadeOperacoes, string $ativo, string $operacao, string $quantidade, string $preco, string $taxa)
    {
        $_SESSION['data'] = $data;
        $_SESSION['aplicacao'] = $aplicacao;
        $_SESSION['quantidadeOperacoes'] = $quantidadeOperacoes;
        for ($i = 0; $i < $quantidadeOperacoes; $i++) {
            $_SESSION["ativo{$i}"] = $ativo;
            $_SESSION["operacao{$i}"] = $operacao;
            $_SESSION["quantidade{$i}"] = $quantidade;
            $_SESSION["preco{$i}"] = $preco;
            $_SESSION["taxa{$i}"] = $taxa;
        }

        if($this->validarData($data)){
            $this->data = $data;
        }
        
        if($this->validarAplicacao($aplicacao)){
            $this->aplicacao = $aplicacao;
        }
        
        if($this->validarAtivo($ativo)){
            $this->ativo = $ativo;
        }
        
        if($this->validarOperacao($operacao)){
            $this->operacao = $operacao;
        }
        
        if($this->validarQuantidade($quantidade)){
            $this->quantidade = $quantidade;
        }

        if($this->validarPreco($preco)){
            $this->preco = $preco;
        }

        if($this->validarTaxa($taxa)){
            $this->taxa = $taxa;
        }

        $this->verificarValidacao();
    }

    public function __get($atributo)
    {
        return $this->$atributo;
    }

    private function validarData($data): bool
    {
        if ($data === "" || $data === null){
            $this->mostrarMensagensDeErro('O campo data não pode estar em branco');
            return false;
        }
        return true;
    }

    private function validarAplicacao($aplicacao):bool
    {
        if($aplicacao === "" || $aplicacao === null){
            $this->mostrarMensagensDeErro('O campo aplicação não pode estar em branco');
            return false;
        }
        return true;
    }

    private function validarAtivo($ativo): bool
    {
        if($ativo === "" || $ativo === null){
            $this->mostrarMensagensDeErro('Os campos de ativos não podem estar vazios');
            return false;
        }
        
        $quatroCaracteresIniciais = substr($ativo, 0 ,4);
        $filtrarNumeros = filter_var($quatroCaracteresIniciais, FILTER_SANITIZE_NUMBER_INT);

        if(is_numeric($filtrarNumeros)){
            $this->mostrarMensagensDeErro('Os quatro primeiros caracteres de um ativo devem ser somente letras.');
            return false;
        }
        return true;
    }

    private function validarOperacao($operacao):bool
    {
        if($operacao === "" || $operacao === null){
            $this->mostrarMensagensDeErro('Os campos de operações não podem estar vazios');
            return false;
        }
        return true;
    }

    private function validarQuantidade($quantidade): bool
    {
        $procurarVirgula = strpos($quantidade, ',');
        $procurarPonto = strpos($quantidade, '.');

        if($quantidade === "" || $quantidade === null){
            $this->mostrarMensagensDeErro('Os campos de quantidades não podem estar vazios');
            return false;
        }

        if((intval($quantidade) === 0) || $procurarVirgula || $procurarPonto){
            $this->mostrarMensagensDeErro('A quantidade deve ser um número e do tipo inteiro.');
            return false;
        }
        return true;
    }

    private function validarPreco($preco): bool
    {
        if($preco === "" || $preco === null){
            $this->mostrarMensagensDeErro('Os campos de preços não podem estar vazios');
            return false;
        }

        if((intval($preco) === 0)){
            $this->mostrarMensagensDeErro('O preço do ativo deve ser um número.');
            return false;
        }
        return true;
    }

    private function validarTaxa($taxa): bool
    {
        if($taxa === "" || $taxa === null){
            $this->mostrarMensagensDeErro('Os campos de taxas não podem estar vazios');
            return false;
        }

        if((intval($taxa) === 0)){
            $this->mostrarMensagensDeErro('A taxa da negociação deve ser um número.');
            return false;
        }
        return true;
    }

    public function verificarValidacao()
    {
        if($_SESSION['erros'] === 1){
            header('Location: /operacoes');
            exit();
        }
    }
}
