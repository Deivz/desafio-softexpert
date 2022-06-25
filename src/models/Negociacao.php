<?php

namespace Deivz\CalculadoraIr\models;

use Deivz\CalculadoraIr\helpers\TVerificarErros;
use Deivz\CalculadoraIr\interfaces\IValidacao;
use Error;

class Negociacao implements IValidacao
{
    use TVerificarErros;

    private $data;
    private $aplicacao;
    private array $ativos;
    private array $operacoes;
    private array $quantidades;
    private array $precos;
    private array $taxas;

    public function __construct(string $data, string $aplicacao, array $ativos, array $operacoes, array $quantidades, array $precos, array $taxas)
    {
        $_SESSION['data'] = $data;
        $_SESSION['aplicacao'] = $aplicacao;
        for ($i=0; $i < count($ativos); $i++) { 
            $_SESSION["ativo{$i}"] = $ativos[$i];
            $_SESSION["operacao{$i}"] = $operacoes[$i];
            $_SESSION["quantidade{$i}"] = $quantidades[$i];
            $_SESSION["preco{$i}"] = $precos[$i];
            $_SESSION["taxa{$i}"] = $taxas[$i];
        }
        if($this->validarData($data)){
            $this->data = $data;
        }
        
        if($this->validarAplicacao($aplicacao)){
            $this->aplicacao = $aplicacao;
        }
        
        if($this->validarAtivo($ativos)){
            $this->ativos = $ativos;
        }
        
        if($this->validarOperacao($operacoes)){
            $this->operacoes = $operacoes;
        }
        
        if($this->validarQuantidade($quantidades)){
            $this->quantidades = $quantidades;
        }

        if($this->validarPreco($precos)){
            for($i = 0; $i < count($precos); $i++) {
                $procurarVirgula = strpos($precos[$i], ',');
                if($procurarVirgula){
                    $precos[$i] = str_replace(',', '.', $precos[$i]);
                }
            }
            $this->precos = $precos;
        }

        if($this->validarTaxa($taxas)){
            for($i = 0; $i < count($taxas); $i++) {
                $procurarVirgula = strpos($taxas[$i], ',');
                if($procurarVirgula){
                    $taxas[$i] = str_replace(',', '.', $taxas[$i]);
                }
            }
            $this->taxas = $taxas;
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
            $this->mostrarMensagensDeErro('O campo data não pode estar em branco.');
            return false;
        }

        $validarData = explode( '-', $data );
        try{
            if(!checkdate($validarData[1], $validarData[2], $validarData[0])){
                $this->mostrarMensagensDeErro('A data informada não corresponde a um valor válido para dd/mm/aaaa.');
                return false;
            }
        }catch(Error $err){
            $err->getMessage();
            $this->mostrarMensagensDeErro('A data informada não corresponde a um valor válido para dd/mm/aaaa.');
            return false;
        }

        return true;
    }

    private function validarAplicacao($aplicacao):bool
    {
        if($aplicacao === "" || $aplicacao === null){
            $this->mostrarMensagensDeErro('O campo aplicação não pode estar em branco.');
            return false;
        }

        $aplicacoes = require __DIR__ . '/../helpers/arrayAplicacoes.php';
        if(!in_array($aplicacao, $aplicacoes)){
            $this->mostrarMensagensDeErro('A aplicação informada não existe no nosso sistema.');
            return false;
        }

        return true;
    }

    private function validarAtivo($ativos): bool
    {
        foreach ($ativos as $ativo) {
            if($ativo === "" || $ativo === null){
                $this->mostrarMensagensDeErro('Os campos de ativos não podem estar vazios.');
                return false;
            }
    
            if (strlen($ativo) > 7){
                $this->mostrarMensagensDeErro('O campo ativo não pode conter mais que 7 caracteres.');
                return false;
            }
            
            $quatroCaracteresIniciais = substr($ativo, 0 ,4);
            $filtrarNumeros = filter_var($quatroCaracteresIniciais, FILTER_SANITIZE_NUMBER_INT);
    
            if(is_numeric($filtrarNumeros)){
                $this->mostrarMensagensDeErro('Os quatro primeiros caracteres de um ativo devem ser somente letras.');
                return false;
            }
        }
        return true;
    }

    private function validarOperacao($operacoes):bool
    {
        foreach ($operacoes as $operacao) {
            if($operacao === "" || $operacao === null){
                $this->mostrarMensagensDeErro('Os campos de operações não podem estar vazios.');
                return false;
            }

            $operacoes = require __DIR__ . '/../helpers/arrayOperacoes.php';
            if(!in_array($operacao, $operacoes)){
                $this->mostrarMensagensDeErro('A operação informada não existe no nosso sistema.');
                return false;
            }
        }
        return true;
    }

    private function validarQuantidade($quantidades): bool
    {
        foreach ($quantidades as $quantidade) {
            $procurarVirgula = strpos($quantidade, ',');
            $procurarPonto = strpos($quantidade, '.');

            if($quantidade === "" || $quantidade === null){
                $this->mostrarMensagensDeErro('Os campos de quantidades não podem estar vazios.');
                return false;
            }

            if (strlen($quantidade) > 7){
                $this->mostrarMensagensDeErro('O campo quantidade não pode conter mais que 7 caracteres.');
                return false;
            }

            if((intval($quantidade) === 0) || $procurarVirgula || $procurarPonto){
                $this->mostrarMensagensDeErro('A quantidade deve ser um número e do tipo inteiro.');
                return false;
            }
        }
        return true;
    }

    private function validarPreco($precos): bool
    {
        foreach ($precos as $preco) {
            if($preco === "" || $preco === null){
                $this->mostrarMensagensDeErro('Os campos de preços não podem estar vazios.');
                return false;
            }

            if (strlen($preco) > 7){
                $this->mostrarMensagensDeErro('O campo preço não pode conter mais que 7 caracteres.');
                return false;
            }

            if((intval($preco) === 0)){
                $this->mostrarMensagensDeErro('O preço do ativo deve ser um número.');
                return false;
            }
        }
        return true;
    }

    private function validarTaxa($taxas): bool
    {
        foreach ($taxas as $taxa) {
            if($taxa === "" || $taxa === null){
                $this->mostrarMensagensDeErro('Os campos de taxas não podem estar vazios.');
                return false;
            }

            if (strlen($taxa) > 5){
                $this->mostrarMensagensDeErro('O campo taxa não pode conter mais que 5 caracteres.');
                return false;
            }

            if((intval($taxa) === 0)){
                $this->mostrarMensagensDeErro('A taxa da negociação deve ser um número.');
                return false;
            }
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
