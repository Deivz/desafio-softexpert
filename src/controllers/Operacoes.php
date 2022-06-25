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
            $this->realizarEnvio(filter_input(INPUT_POST, 'quantidadeOperacoes', FILTER_SANITIZE_NUMBER_INT));
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
                $data = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_SPECIAL_CHARS);
                $aplicacao = filter_input(INPUT_POST, 'aplicacao', FILTER_SANITIZE_SPECIAL_CHARS); 
                $ativo = filter_input(INPUT_POST, "ativo{$i}", FILTER_SANITIZE_SPECIAL_CHARS);
                $operacao = filter_input(INPUT_POST, "operacao{$i}", FILTER_SANITIZE_SPECIAL_CHARS);
                $quantidade = filter_input(INPUT_POST, "quantidade{$i}", FILTER_SANITIZE_NUMBER_INT);
                $preco = filter_input(INPUT_POST, "preco{$i}", FILTER_SANITIZE_SPECIAL_CHARS);
                $taxa = filter_input(INPUT_POST, "taxa{$i}", FILTER_SANITIZE_SPECIAL_CHARS);
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