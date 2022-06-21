<?php

namespace Deivz\CalculadoraIr\controllers;

use Deivz\CalculadoraIr\helpers\TMensagensDeErro;
use Deivz\CalculadoraIr\interfaces\IRequisicao;
use Deivz\CalculadoraIr\interfaces\ISessoes;
use Deivz\CalculadoraIr\models\Negociacao;
use Error;


class Operacoes extends Renderizador implements IRequisicao, ISessoes
{
    use TMensagensDeErro;

    function processarRequisicao(): void
    {   
        echo $this->renderizarPagina('/operacoes');
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $this->realizarEnvio();
        }
    }

    private function realizarEnvio()
    {
        if ($this->validarData($_POST['data'])){
            $data = $_POST['data'];
        }

        if ($this->validarAplicacao($_POST['aplicacao'])){
            $aplicacao = $_POST['aplicacao'];
        }

        for ($i = 0; $i < $_POST['quantidadeOperacoes']; $i++) {
            if(isset($_POST["ativo{$i}"])){
                if ($this->validarNegociacao($_POST["ativo{$i}"], $_POST["ativo{$i}"], $_POST["quantidade{$i}"], $_POST["preco{$i}"], $_POST["taxa{$i}"])){
                    $ativo = $_POST["ativo{$i}"];
                    $operacao = $_POST["operacao{$i}"];
                    $quantidade = $_POST["quantidade{$i}"];
                    $preco = $_POST["preco{$i}"];
                    $taxa = $_POST["taxa{$i}"];
                }
            }     
        }

        try{
            $negociacao = new Negociacao($data, $aplicacao, $ativo, $operacao, $quantidade, $preco, $taxa);
        }catch(Error $err){
            $this->definirSessoes();
            header('Location: /operacoes');
            exit();
        }

        $req = [
            'Data' => $negociacao->data,
            'Aplicação' => $negociacao->aplicacao,
            'Ativos' => $negociacao->ativos,
            'Operações' => $negociacao->operacoes,
            'Quantidades' => $negociacao->quantidades,
            'Preços' => $negociacao->precos,
            'Taxas' => $negociacao->taxas
        ];

        $dados = "\n" . json_encode($req);
        $arquivo = fopen('../src/repositorio/negociacoes.txt', 'a');
        fwrite($arquivo, $dados);
        fclose($arquivo);
        $_SESSION['sucesso'] = 'Negociação inserida com sucesso!';
        header('Location: /operacoes');
    }

    public function definirSessoes()
    {
        $_SESSION['data'] = $_POST['data'];
        $_SESSION['aplicacao'] = $_POST['aplicacao'];
        $_SESSION['quantidadeOperacoes'] = $_POST['quantidadeOperacoes'];
        for ($i = 0; $i < $_SESSION['quantidadeOperacoes']; $i++) {
            $_SESSION["ativo{$i}"] = $_POST["ativo{$i}"];
            $_SESSION["operacao{$i}"] = $_POST["operacao{$i}"];
            $_SESSION["quantidade{$i}"] = $_POST["quantidade{$i}"];
            $_SESSION["preco{$i}"] = $_POST["preco{$i}"];
            $_SESSION["taxa{$i}"] = $_POST["taxa{$i}"];
        }
    }

    private function validarData(string $data): bool
    {
        if ($data === "" || $data === null){
            $this->mostrarMensagensDeErro('O campo data não pode estar em branco');
            return false;
        }
        return true;
    }
    
    private function validarAplicacao(string $aplicacao): bool
    {
        if($aplicacao === "" || $aplicacao === null){
            $this->mostrarMensagensDeErro('O campo aplicação não pode estar em branco');
            return false;
        }
        return true;
    }

    private function validarNegociacao(string $ativo, string $operacao, string $quantidade, string $preco, string $taxa):bool
    {
        if($ativo === "" || $ativo = null){
            $this->mostrarMensagensDeErro('Os campos de ativos não podem estar vazios');
        }
        
        if($operacao === "" || $operacao = null){
            $this->mostrarMensagensDeErro('Os campos de operações não podem estar vazios');
        }

        if($quantidade === "" || $quantidade = null){
            $this->mostrarMensagensDeErro('Os campos de quantidades não podem estar vazios');
        }

        if($preco === "" || $preco = null){
            $this->mostrarMensagensDeErro('Os campos de preços não podem estar vazios');
        }

        if($taxa === "" || $taxa = null){
            $this->mostrarMensagensDeErro('Os campos de taxas não podem estar vazios');
        }

        return true;
    }
}