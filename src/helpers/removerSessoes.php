<?php

    $removerSessoes = function($quantidade)
    {
        for ($i = 0; $i < $quantidade; $i++) {
            unset($_SESSION['data']);
            unset($_SESSION['aplicacao']);
            unset($_SESSION['quantidadeOperacoes']);
            unset($_SESSION["ativo{$i}"]);
            unset($_SESSION["operacao{$i}"]);
            unset($_SESSION["quantidade{$i}"]);
            unset($_SESSION["preco{$i}"]);
            unset($_SESSION["taxa{$i}"]);
        }
    };

    return $removerSessoes;