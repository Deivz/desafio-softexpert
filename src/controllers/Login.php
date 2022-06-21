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
            if(!$this->buscarUsuario($_POST['email'], $_POST['senha'])){
                $_SESSION['tipoMensagem'] = 'danger';
                $_SESSION['email'] = $_POST['email'];
                header('Location: /login');
                exit();
            }

            $_SESSION['logado'] = true;
            header('Location: /operacoes');
        }
    }

    public function buscarUsuario(string $user, string $password): bool
    {
        $user = filter_var($user, FILTER_SANITIZE_SPECIAL_CHARS);

        $arquivo = '../src/repositorio/usuarios.txt';
        $stream = fopen($arquivo, 'r');

        while(!feof($stream)){
            $usuario = json_decode(fgets($stream));
            if($user === $usuario->{'email'}){
                if(password_verify($password, $usuario->{'senha'})){
                    return true;
                }
                $_SESSION['mensagem'] = "Senha inválida!";
                return false;
            }
        }
        $_SESSION['mensagem'] = "Usuário não cadastrado!";
        return false;
    }
}