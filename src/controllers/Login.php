<?php

namespace Deivz\CalculadoraIr\controllers;

use Deivz\CalculadoraIr\interfaces\IRequisicao;

class Login extends Renderizador implements IRequisicao
{
    public function processarRequisicao(): void
    {
        echo $this->renderizarPagina('/login');
        $this->realizarLogin();
    }

    public function realizarLogin()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if($_POST['email'] !== 'davi@email.com'){
                $_SESSION['tipoMensagem'] = 'danger';
                $_SESSION['mensagem'] = "Usuário não cadastrado!";
                header('Location: /login');
                exit();
            }

            $_SESSION['logado'] = true;
            header('Location: /operacoes');
        }
    }
}