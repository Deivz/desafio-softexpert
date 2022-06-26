<?php

namespace Deivz\CalculadoraIr\controllers;

use Deivz\CalculadoraIr\interfaces\IRequisicao;
use Deivz\CalculadoraIr\models\Usuario;

class Login extends Renderizador implements IRequisicao
{
    public function processarRequisicao(): void
    {
        echo $this->renderizarPagina('/login');
        $this->realizarLogin(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS), $_POST['senha']);
    }

    public function realizarLogin(string $email, string $senha)
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!$this->buscarUsuario($email, $senha)){
                $_SESSION['tipoMensagem'] = 'danger';
                $_SESSION['email'] = $email;
                header('Location: /login');
                exit();
            }

            $_SESSION['logado'] = true;
            
            header('Location: /operacoes');
        }
    }

    public function buscarUsuario(string $email, string $senha): bool
    {
        $arquivo = '../src/repositorio/usuarios.txt';
        $stream = fopen($arquivo, 'r');

        while(!feof($stream)){
            $usuario = json_decode(fgets($stream));
            if($email === $usuario->{'email'}){
                if(password_verify($senha, $usuario->{'senha'})){
                    $_SESSION['nomeUsuario'] = $usuario->{'nome'};
                    $_SESSION['cpf'] = $usuario->{'cpf'};
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