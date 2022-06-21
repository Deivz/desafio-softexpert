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
        if ($this->verificarData($_POST['data'])){
            $data = $_POST['data'];
        }

        if ($this->verificarAplicacao($_POST['aplicacao'])){
            $aplicacao = $_POST['aplicacao'];
        }

        if ($_POST['quantidadeOperacoes'] === "" || $_POST['quantidadeOperacoes'] === null){
            $this->mostrarMensagensDeErro('O campo quantidade de operações está vazio!');
        }

        for ($i = 0; $i < $_POST['quantidadeOperacoes']; $i++) {
            if(isset($_POST["ativo{$i}"])){
                if ($this->verificarAtivo($_POST["ativo{$i}"])){
                    $ativo = $_POST["ativo{$i}"];
                }
                
                if ($this->verificarOperacao($_POST["operacao{$i}"])){
                    $operacao = $_POST["operacao{$i}"];
                }
                
                if ($this->verificarQuantidade($_POST["quantidade{$i}"])){
                    $quantidade = $_POST["quantidade{$i}"];
                }
                
                if ($this->verificarPreco($_POST["preco{$i}"])){
                    $preco = $_POST["preco{$i}"];
                }
                
                if ($this->verificarTaxa($_POST["taxa{$i}"])){
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
            'Ativos' => $negociacao->ativo,
            'Operações' => $negociacao->operacao,
            'Quantidades' => $negociacao->quantidade,
            'Preços' => $negociacao->preco,
            'Taxas' => $negociacao->taxa
        ];

        $dados = "\n" . json_encode($req, JSON_UNESCAPED_UNICODE);
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

    private function verificarData(string $data): bool
    {
        if ($data === "" || $data === null){
            $this->mostrarMensagensDeErro('O campo data não pode estar em branco');
            return false;
        }
        return true;
    }
    
    private function verificarAplicacao(string $aplicacao): bool
    {
        if($aplicacao === "" || $aplicacao === null){
            $this->mostrarMensagensDeErro('O campo aplicação não pode estar em branco');
            return false;
        }
        return true;
    }

    private function verificarAtivo(string $ativo):bool
    {
        if($ativo === "" || $ativo = null){
            $this->mostrarMensagensDeErro('Os campos de ativos não podem estar vazios');
            return false;
        }

        // if (intval(substr($_POST['ativo0'], 0, 4)) !== 0){
        //     echo $_POST['ativo0'];
        //     $this->mostrarMensagensDeErro('Os quatro primeiros caracteres de um ativo devem ser somente letras.');
        //     return false;
        // }

        return true;
    }

    private function verificarOperacao(string $operacao):bool
    {
        if($operacao === "" || $operacao = null){
            $this->mostrarMensagensDeErro('Os campos de operações não podem estar vazios');
            return false;
        }
        return true;
    }

    private function verificarQuantidade(string $quantidade):bool
    {
        if($quantidade === "" || $quantidade = null){
            $this->mostrarMensagensDeErro('Os campos de quantidades não podem estar vazios');
            return false;
        }
        return true;
    }

    private function verificarPreco(string $preco):bool
    {
        if($preco === "" || $preco = null){
            $this->mostrarMensagensDeErro('Os campos de preços não podem estar vazios');
            return false;
        }
        return true;
    }

    private function verificarTaxa(string $taxa):bool
    {
        if($taxa === "" || $taxa = null){
            $this->mostrarMensagensDeErro('Os campos de taxas não podem estar vazios');
            return false;
        }
        return true;
    }
}