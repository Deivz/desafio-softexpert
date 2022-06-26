<?php

namespace Deivz\CalculadoraIr\controllers;

use Deivz\CalculadoraIr\interfaces\IRequisicao;

class ListaOperacoes extends Renderizador implements IRequisicao
{
    public function processarRequisicao(): void
    {
        $this->listarOperacoes();
        echo $this->renderizarPagina('/listaOperacoes');
    }

    private function listarOperacoes()
    {
        $arquivo = '../src/repositorio/negociacoes.txt';
        $stream = fopen($arquivo, 'r');
        $i = 0;  
        while (!feof($stream)) {
            $negociacao = json_decode(fgets($stream));
            if ($negociacao->Usuario === $_SESSION['cpf']) {
                $data = explode('-', $negociacao->Data);
                $_SESSION["negociacaoData"][$i] = "{$data[2]}/{$data[1]}/{$data[0]}";

                $_SESSION["negociacaoAplicacao"][$i] = $negociacao->Aplicacao;

                $ativos = $negociacao->Ativos;
                $operacoes = $negociacao->Operacoes;
                $quantidades = $negociacao->Quantidades;
                $precos = $negociacao->Precos;
                $taxas = $negociacao->Taxas;

                for ($j = 0; $j < count($ativos); $j++) {
                    $_SESSION["negociacaoAtivo"][$i][$j] = $ativos[$j];
                    $_SESSION["negociacaoOperacao"][$i][$j] = $operacoes[$j];
                    $_SESSION["negociacaoQuantidade"][$i][$j] = $quantidades[$j];
                    $_SESSION["negociacaoPreco"][$i][$j] = $precos[$j];
                    $_SESSION["negociacaoTaxa"][$i][$j] = $taxas[$j];
                }
                $i++;
            }
        }
        fclose($stream);
        $_SESSION['quantidadeDados'] = $i;
    }
}

   // foreach ($ativos as $ativo) {
                //     $_SESSION["negociacaoAtivo"][$i][$j] = $ativo;
                // }
                
                // $operacoes = $negociacao->Operacoes;
                // $j = 0;
                // foreach ($operacoes as $operacao) {
                //     $_SESSION["negociacaoOperacao"][$i][$j] = $operacao;
                // }

                // $quantidades = $negociacao->Quantidades;
                // $j = 0;
                // foreach ($quantidades as $quantidade) {
                //     $_SESSION["negociacaoQuantidade"][$i][$j] = $quantidade;
                // }

                // $precos = $negociacao->Precos;
                // $j = 0;
                // foreach ($precos as $preco) {
                //     $_SESSION["negociacaoPreco"][$i][$j] = $preco;
                // }

                // $taxas = $negociacao->Taxas;
                // $j = 0;
                // foreach ($taxas as $taxa) {
                //     $_SESSION["negociacaoTaxa"][$i][$j] = $taxa;
                // }