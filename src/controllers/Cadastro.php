<?php

namespace Deivz\CalculadoraIr\controllers;

use Deivz\CalculadoraIr\helpers\TVerificarErros;
use Deivz\CalculadoraIr\interfaces\IRequisicao;
use Deivz\CalculadoraIr\interfaces\IValidacao;
use Deivz\CalculadoraIr\models\Usuario;
use Error;

class Cadastro extends Renderizador implements IRequisicao, IValidacao
{
    use TVerificarErros;

    public function processarRequisicao(): void
    {
        echo $this->renderizarPagina('/cadastro');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->realizarCadastro($_POST['nome'], $_POST['cpf'], $_POST['email'], $_POST['senha']);
        }
    }

    private function realizarCadastro($nome, $cpf, $email, $senha)
    {
        $this->definirSessoes();
        
        if (!$this->verificarDuplicidade($cpf, $email)) {
            $this->verificarValidacao();
        }

        $user = new Usuario($nome, $cpf, $email, $senha);

        $req = [
            'nome' => $user->nome,
            'cpf' => $user->cpf,
            'email' => $user->email,
            'senha' => $user->senha
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

    private function definirSessoes()
    {
        $_SESSION['nome'] = $_POST['nome'];
        $_SESSION['cpf'] = $_POST['cpf'];
        $_SESSION['email'] = $_POST['email'];
    }

    private function verificarDuplicidade($cpf, $email): bool
    {
        $arquivo = '../src/repositorio/usuarios.txt';
        $stream = fopen($arquivo, 'r');
        while (!feof($stream)) {
            $usuario = json_decode(fgets($stream));
            if ($cpf === $usuario->{'cpf'}) {
                $this->mostrarMensagensDeErro('CPF já cadastrado no sistema!');
                return false;
            }

            if ($email === $usuario->{'email'}) {
                $this->mostrarMensagensDeErro('Email já cadastrado no sistema!');
                return false;
            }
        }
        fclose($stream);
        return true;
    }

    public function verificarValidacao()
    {
        if ($_SESSION['erros'] === 1) {
            header('Location: /cadastro');
            exit();
        }
    }
}
