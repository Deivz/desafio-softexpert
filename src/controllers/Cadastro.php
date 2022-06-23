<?php

namespace Deivz\CalculadoraIr\controllers;

use Deivz\CalculadoraIr\helpers\TVerificarErros;
use Deivz\CalculadoraIr\interfaces\IRequisicao;
use Deivz\CalculadoraIr\models\Usuario;
use Error;

class Cadastro extends Renderizador implements IRequisicao
{
    use TVerificarErros;

    public function processarRequisicao(): void
    {
        echo $this->renderizarPagina('/cadastro');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->realizarCadastro($_POST['nome'], $_POST['cpf'], $_POST['email'], $_POST['senha']);
        }
    }

    private function realizarCadastro($nome, $email, $cpf, $senha)
    {
       $user = new Usuario($nome, $email, $cpf, $senha);

        $req = [
            'nome' => $user->nome,
            'cpf' => $user->cpf,
            'senha' => $user->senha,
            'email' => $user->email
        ];

        $dados = "\n" . json_encode($req, JSON_UNESCAPED_UNICODE);
        $arquivo = fopen('../src/repositorio/usuarios.txt', 'a');
        fwrite($arquivo, $dados);
        fclose($arquivo);
        $_SESSION['sucesso'] = 'Cadastro realizado com sucesso!';
        unset($_SESSION['nome']);
        unset($_SESSION['cpf']);
        unset($_SESSION['email']);
        header('Location: /login');
    }
}