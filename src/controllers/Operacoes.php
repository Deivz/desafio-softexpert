<?php

namespace Deivz\CalculadoraIr\controllers;

use Deivz\CalculadoraIr\helpers\TVerificarErros;
use Deivz\CalculadoraIr\interfaces\IRequisicao;
use Deivz\CalculadoraIr\models\Negociacao;



class Operacoes extends Renderizador implements IRequisicao
{
    
    use TVerificarErros;

    function processarRequisicao(): void
    {
        echo $this->renderizarPagina('/operacoes');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->realizarEnvio($_POST['quantidadeOperacoes']);
        }
    }

    private function realizarEnvio($quantidadeOperacoes)
    {
        if($quantidadeOperacoes === "" || $quantidadeOperacoes === null){
            $this->mostrarMensagensDeErro('Escolha a quantidade de operações a serem lançadas.');
            header('Location: /operacoes');
            return;
        }else{
            header('Location: /operacoes');
        }

        $_SESSION['quantidadeOperacoes'] = $quantidadeOperacoes;

        for ($i = 0; $i < $quantidadeOperacoes; $i++) {
            if(isset($_POST["ativo{$i}"])){
                $data = $_POST['data'];
                $aplicacao = $_POST['aplicacao']; 
                $ativo = $_POST["ativo{$i}"];
                $operacao = $_POST["operacao{$i}"];
                $quantidade = $_POST["quantidade{$i}"];
                $preco = $_POST["preco{$i}"];
                $taxa = $_POST["taxa{$i}"];
            }
        }

        $negociacao = new Negociacao($data, $aplicacao, $quantidadeOperacoes, $ativo, $operacao, $quantidade, $preco, $taxa);

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
        $removerSessoes = require __DIR__ . '/../helpers/removerSessoes.php';
        $removerSessoes($quantidadeOperacoes);
        header('Location: /operacoes');
    }
}