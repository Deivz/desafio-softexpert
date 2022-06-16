<?php

namespace Deivz\CalculadoraIr\controllers;

use Deivz\CalculadoraIr\interfaces\IRequisicao;

class Login extends Renderizador implements IRequisicao
{
    public function processarRequisicao(): void
    {
        echo $this->renderizarPagina('/login');
    }

    public function realizarLogin()
    {
        if($_POST['email'] !== 'davi@email.com'){
            echo "Usuário não cadastrado!";
            exit();
        }

        $_SESSION['logado'] = true;
    }
}