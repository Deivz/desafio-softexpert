<?php

namespace Deivz\CalculadoraIr\helpers;

trait TMensagensDeErro
{
    public function mostrarMensagensDeErro(string $mensagem)
    {   
        static $mensagens = [];
        if(!in_array($mensagem, $mensagens)){
            array_push($mensagens, $mensagem);
            $_SESSION['mensagens'] = $mensagens;
        }
    }
}